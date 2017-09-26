<?php
/**
 * Created by PhpStorm.
 * User: tasfin
 * Date: 25/09/17
 * Time: 14:29
 */

function mergeData($testCaseData, $stepMapData, $stepResData){
    $mergeData = getDataByIndex($testCaseData, "testcaseid", false);
    $stepMapData = getDataByIndex($stepMapData, "stepsid", false);
    $stepResData = getDataByIndex($stepResData, "stepsid", true);

    //print_r($mergeData); die;

    $stepMergeData = getStepMergedData($stepMapData, $stepResData);
    $stepMergeData = getStepMergedDataByTestCaseId($stepMergeData);
    $mergeData     = getTestCaseMergedDataWithStep($mergeData, $stepMergeData);
    $mergeTabData  = getTestCaseByTabName($mergeData);

    //print_r($mergeTabData); die;
    return $mergeTabData;
}

function getTestCaseByTabName($mergeData){
    $resData = array();
    if($mergeData){
        $tabName = "";
        foreach ($mergeData as $testCaseID => $data){
            if(!empty(trim($data['tabname']))){
                $tabName = trim($data['tabname']);
            }
            $resData[$tabName][] = getTabWisePreparedData($data);
        }
    }

    return $resData;
}

function getTabWisePreparedData($row){
    $resData = [];
    if($row){
        $title = !empty($row['title']) ? trim($row['title']) : "";
        $description = !empty($row['description']) ? trim($row['description']) : "";
        $steps = "";
        $expectedResults = "";
        if(!empty($row['step_result']['step_result'])){
            $counter = 1;
            foreach ($row['step_result']['step_result'] as $stepData){
                $steps .= !empty($stepData['teststeps']) ? $counter.") ".trim($stepData['teststeps'])."\n\n" : "";
                $expectedResults .= !empty($stepData['expectedresults']) ? $counter.") ".trim($stepData['expectedresults'])."\n\n" : "";
                $counter++;
            }
        }

        $resData['title'] = str_replace("&", "and", preg_replace('/\t+/', '', $title));
        $resData['description'] = str_replace("&", "and", preg_replace('/\t+/', '', $description));
        $resData['steps'] = str_replace("&", "and", preg_replace('/\t+/', '', $steps));
        $resData['expectedresults'] = str_replace("&", "and", preg_replace('/\t+/', '', $expectedResults));

    }
    return $resData;
}

function getTestCaseMergedDataWithStep($mergeData, $stepMergeData){
    if($mergeData){
        foreach ($mergeData as $testCaseId => $data){
            $mergeData[$testCaseId]['step_result'] = !empty($stepMergeData[$testCaseId]) ? $stepMergeData[$testCaseId] : [];
        }
    }

    return $mergeData;
}

function getStepMergedDataByTestCaseId($stepMergeData){
    $mergeData = array();
    if($stepMergeData){
        foreach ($stepMergeData as $stepId => $stepData){
            $mergeData[$stepData['testcaseid']] = $stepData;
        }
    }

    return $mergeData;
}

function getStepMergedData($stepMapData, $stepResData){
    if($stepMapData){
        foreach ($stepMapData as $key => $stepMap){
            $stepMapData[$key]['step_result'] = $stepResData[$key];
        }
    }

    return $stepMapData;
}


function getDataByIndex($data, $index = 'testcaseid', $isMultiLevelArr = false){
    $resultData = array();
    if($data){
        foreach ($data as $row){
            if($isMultiLevelArr)
                $resultData[$row[$index]][] = $row;
            else
                $resultData[$row[$index]] = $row;
        }
    }

    return $resultData;
}