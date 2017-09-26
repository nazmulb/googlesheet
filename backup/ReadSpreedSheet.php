<?php

/**
 *
 */
namespace project\ReadSpreedSheet;

include_once "GoogleApi.php";


class ReadSpreedSheet
{
    private $googleApi = null;

    function fetch($fileName, $sheetName, $fetchFromLive = false)
    {
        $googleApi = new \project\GoogleApi\GoogleApi();
        return $googleApi->fetch($fileName, $sheetName, "deliverable", $fetchFromLive); //false = load from cache, true =  load from google sheet
    }

    function process($basicData)
    {
        $processedData = array();

        if(!empty($basicData)) {
            foreach($basicData as $data) {
                //pr($data);
                $tempArr                        = array();
                $tempArr["client"]              = isset($data["client"]) && $data["client"] != "." ? $data["client"] : "";
                $tempArr["project"]             = isset($data["project"]) && $data["project"] != "." ? $data["project"] : "";
                $tempArr["version"]             = isset($data["version"]) && $data["version"] != "." ? $data["version"] : "";
                $tempArr["sn"]                  = isset($data["sn"]) && $data["sn"] != "." ? $data["sn"] : "";
                $tempArr["task"]                = isset($data["task"]) && $data["task"] != "." ? $data["task"] : "";
                $tempArr["startdate"]           = isset($data["startdate"]) && $data["startdate"] != "." ? $data["startdate"] : "";
                $tempArr["releasedate"]         = isset($data["releasedate"]) && $data["releasedate"] != "." ? $data["releasedate"] : "";
                $tempArr["analysis"]            = isset($data["analysis"]) && $data["analysis"] != "." ? $data["analysis"] : "";
                $tempArr["pendingdebelopment"]  = isset($data["pendingdebelopment"]) && $data["pendingdebelopment"] != "." ? $data["pendingdebelopment"] : "";
                $tempArr["developmentcomplete"] = isset($data["developmentcomplete"]) && $data["developmentcomplete"] != "." ? $data["developmentcomplete"] : "";
                $tempArr["implementation"]      = isset($data["implementation"]) && $data["implementation"] != "." ? $data["implementation"] : "";
                $tempArr["comment"]             = isset($data["comment"]) && $data["comment"] != "." ? $data["comment"] : "";
                $tempArr["et"]                  = isset($data["et"]) && $data["et"] != "." ? $data["et"] : "";
                $tempArr["1"]                   = isset($data["_cyevm"]) && $data["_cyevm"] != "." ? $data["_cyevm"] : 0;
                $tempArr["2"]                   = isset($data["_cztg3"]) && $data["_cztg3"] != "." ? $data["_cztg3"] : 0;
                $tempArr["3"]                   = isset($data["_d180g"]) && $data["_d180g"] != "." ? $data["_d180g"] : 0;
                $tempArr["4"]                   = isset($data["_d2mkx"]) && $data["_d2mkx"] != "." ? $data["_d2mkx"] : 0;
                $tempArr["5"]                   = isset($data["_cssly"]) && $data["_cssly"] != "." ? $data["_cssly"] : 0;
                $tempArr["6"]                   = isset($data["_cu76f"]) && $data["_cu76f"] != "." ? $data["_cu76f"] : 0;
                $tempArr["7"]                   = isset($data["_cvlqs"]) && $data["_cvlqs"] != "." ? $data["_cvlqs"] : 0;
                $tempArr["8"]                   = isset($data["_cx0b9"]) && $data["_cx0b9"] != "." ? $data["_cx0b9"] : 0;
                $tempArr["9"]                   = isset($data["_d9ney"]) && $data["_d9ney"] != "." ? $data["_d9ney"] : 0;
                $tempArr["10"]                  = isset($data["_db1zf"]) && $data["_db1zf"] != "." ? $data["_db1zf"] : 0;
                $tempArr["11"]                  = isset($data["_dcgjs"]) && $data["_dcgjs"] != "." ? $data["_dcgjs"] : 0;
                $tempArr["12"]                  = isset($data["_ddv49"]) && $data["_ddv49"] != "." ? $data["_ddv49"] : 0;
                $tempArr["13"]                  = isset($data["_d415a"]) && $data["_d415a"] != "." ? $data["_d415a"] : 0;
                $tempArr["14"]                  = isset($data["_d5fpr"]) && $data["_d5fpr"] != "." ? $data["_d5fpr"] : 0;
                $tempArr["15"]                  = isset($data["_d6ua4"]) && $data["_d6ua4"] != "." ? $data["_d6ua4"] : 0;
                $tempArr["16"]                  = isset($data["_d88ul"]) && $data["_d88ul"] != "." ? $data["_d88ul"] : 0;
                $tempArr["17"]                  = isset($data["_dkvya"]) && $data["_dkvya"] != "." ? $data["_dkvya"] : 0;
                $tempArr["18"]                  = isset($data["_dmair"]) && $data["_dmair"] != "." ? $data["_dmair"] : 0;
                $tempArr["19"]                  = isset($data["_dnp34"]) && $data["_dnp34"] != "." ? $data["_dnp34"] : 0;
                $tempArr["20"]                  = isset($data["_dp3nl"]) && $data["_dp3nl"] != "." ? $data["_dp3nl"] : 0;
                $tempArr["21"]                  = isset($data["_df9om"]) && $data["_df9om"] != "." ? $data["_df9om"] : 0;
                $tempArr["22"]                  = isset($data["_dgo93"]) && $data["_dgo93"] != "." ? $data["_dgo93"] : 0;
                $tempArr["23"]                  = isset($data["_di2tg"]) && $data["_di2tg"] != "." ? $data["_di2tg"] : 0;
                $tempArr["24"]                  = isset($data["_djhdx"]) && $data["_djhdx"] != "." ? $data["_djhdx"] : 0;
                $tempArr["25"]                  = isset($data["_dw4je"]) && $data["_dw4je"] != "." ? $data["_dw4je"] : 0;
                $tempArr["26"]                  = isset($data["_dxj3v"]) && $data["_dxj3v"] != "." ? $data["_dxj3v"] : 0;
                $tempArr["27"]                  = isset($data["_dyxo8"]) && $data["_dyxo8"] != "." ? $data["_dyxo8"] : 0;
                $tempArr["28"]                  = isset($data["_e0c8p"]) && $data["_e0c8p"] != "." ? $data["_e0c8p"] : 0;
                $tempArr["29"]                  = isset($data["_dqi9q"]) && $data["_dqi9q"] != "." ? $data["_dqi9q"] : 0;
                $tempArr["30"]                  = isset($data["_drwu7"]) && $data["_drwu7"] != "." ? $data["_drwu7"] : 0;
                $tempArr["31"]                  = isset($data["_dtbek"]) && $data["_dtbek"] != "." ? $data["_dtbek"] : 0;

                $processedData[] = $tempArr;
            }

        }

        return $processedData;
    }

    function fix($processedData)
    {
        $fixedData = array();
        if($processedData) {
            $clientName      = "";
            $projectName     = "";
            $versionNo       = "";
            $startDatePrev   = "";
            $releasedatePrev = "";

            foreach($processedData as $index => $data) {
                //pr($data);
                if($index == 0)
                    continue;

                $tempArr     = array();
                $client      = trim($data['client']);
                $project     = trim($data['project']);
                $version     = trim($data['version']);
                $serialNo    = strtolower(trim($data['sn']));
                $task        = trim($data['task']);
                $startDate   = $data['startdate'];
                $releasedate = $data['releasedate'];


                if(isset($client) && $client != '') {
                    $clientName = $client;
                }
                if(isset($project) && $project != '') {
                    $projectName = $project;
                }
                if(isset($version) && $version != '') {
                    $versionNo = $version;
                }
                if(isset($version) && $version != '') {
                    $versionNo = $version;
                }
                if(isset($startDate) && $startDate != '') {
                    $startDatePrev = $startDate;
                }
                if(isset($releasedate) && $releasedate != '') {
                    $releasedatePrev = $releasedate;
                }
                
                //var_dump($projectName, $versionNo, $startDatePrev, $releasedatePrev);


                if((empty($serialNo) && empty($task)) || ($serialNo == "." || $task == "." || $client == ".")) {
                    continue;
                }
                else {
                    $tempArr['sn'] = $serialNo;

                    if(empty($clientName) && empty($client)) {
                        $clientName = "--";
                    }
                    if(empty($projectName) && empty($project)) {
                        $projectName = "--";
                    }

                    $tempArr['client']  = empty($client) ? $clientName : $client;
                    $tempArr['project'] = empty($project) ? $projectName : $project;
                    $tempArr['version'] = empty($version) ? $versionNo : $version;

                    $tempArr['task']                = $task;
                    $tempArr['startdate']           = empty($startDate) ? $startDatePrev : $startDate;
                    $tempArr['releasedate']         = empty($releasedate) ? $releasedatePrev : $releasedate;
                    $tempArr['analysis']            = empty($data['analysis']) ? "" : $data['analysis'];
                    $tempArr['pendingdebelopment']  = empty($data['pendingdebelopment']) ? "" : $data['pendingdebelopment'];
                    $tempArr['developmentcomplete'] = empty($data['developmentcomplete']) ? "" : $data['developmentcomplete'];
                    $tempArr['implementation']      = empty($data['implementation']) ? "" : $data['implementation'];
                    $tempArr['comment']             = empty($data['comment']) ? "" : $data['comment'];
                    $tempArr['et']                  = empty($data['et']) ? 0.00 : number_format($data['et'], 2, '.', '');

                    for($day = 1; $day <= 31; $day++) {
                        $tempArr[$day] = empty($data[$day]) ? 0 : number_format($data[$day], 2, '.', '');
                    }

                    $fixedData[] = $tempArr;
                }
            }
        }

        return $fixedData;
    }

    function all($fileName, $sheetName, $fetchFromLive = false)
    {
        return $basicData = $this->fetch($fileName, $sheetName, $fetchFromLive);

        if($basicData == -1) {
            return $basicData;
        }
        $processedData = $this->process($basicData);

        $fixedData = $this->fix($processedData);
        
        return $fixedData;
    }

    function MakeCache($fileName, $sheetName)
    {
        $basicData = $this->fetch($fileName, $sheetName, true);

        return $basicData;
    }

    function GetProjectWiseEtDtData($fileName, $sheetName, $fetchFromLive = false)
    {
        $resData = $this->all($fileName, $sheetName, $fetchFromLive);

        $devData = array();
        if($resData) {
            foreach($resData as $index => $data) {
                $project = $this->m->Department->getProjectName($data["project"]);
                if(empty($project)) {
                    $project = "--";
                }
                $devData[$project]["et"] += $data["et"];
                $devData[$project]["dt"] += $data["dt"];
            }
        }

        if($devData) {
            foreach($devData as $developer => &$data) {
                $data['et'] = number_format($data['et'], 2, ".", '');
                $data['dt'] = number_format($data['dt'], 2, ".", '');
            }
        }

        return $devData;
    }

    function GetProjectVersionWiseEtDtData($fileName, $sheetName, $fetchFromLive = false)
    {
        $resData = $this->all($fileName, $sheetName, $fetchFromLive);

        $projectData = array();
        if($resData) {
            foreach($resData as $index => $data) {
                $project = $this->m->Department->getProjectName($data["project"]);
                if(empty($project)) {
                    $project = "--";
                }

                $version = $data["version"];
                $projectData[$project][$version]["et"] += $data["et"];

                $dayArr = array();
                for($day = 1; $day <= 31; $day++) {
                    $dayVal = !empty($data[$day]) ? $data[$day] : 0;
                    if($dayVal) {
                        $dayArr[$day] = $dayVal;
                    }

                    $projectData[$project][$version]["dt"] += $data[$day];
                }

                if(!isset($projectData[$project][$version]["days"])) {
                    $projectData[$project][$version]["days"] = array();
                }

                $margeArr = $this->m->Department->__GetMargeDate($projectData[$project][$version]["days"], $dayArr);

                $projectData[$project][$version]["days"] = $margeArr;

            }

        }

        if($projectData) {
            foreach($projectData as $projectNm => &$project) {
                foreach($project as $versionN => &$data) {
                    $data['et'] = number_format($data['et'], 2, ".", '');
                    $data['dt'] = number_format($data['dt'], 2, ".", '');
                }
            }
        }

        return $projectData;
    }


    function GetProjectVersionWiseData($fileName, $sheetName, $fetchFromLive = false)
    {
        $resData = $this->all($fileName, $sheetName, $fetchFromLive);
        //pr($resData); die;

        $projectData = array();
        if($resData) {
            foreach($resData as $index => $data) {
                $project = $this->m->Department->getProjectName($data["project"]);
                if(empty($project)) {
                    $project = "--";
                }
                //$version = $this->getVersion($data["version"]);
                $version = $data["version"];
                $totalDT = 0;
                for($day = 1; $day <= 31; $day++) {
                    $totalDT += $data[$day];
                }
                $data['total_dt']                  = $totalDT;
                $projectData[$project][$version][] = $data;
            }
        }

        $projectData = $this->__GetLowestHighestReleaseDate($projectData);

        return $projectData;
    }

    private function __GetLowestHighestReleaseDate($projectData)
    {
        //pr($projectData); die;
        $resData = array();
        if($projectData) {
            foreach($projectData as $projectName => $project) {
                foreach($project as $versionN0 => $version) {
                    //pr($version);
                    $lowestDate  = 0;
                    $highestDate = 0;
                    $dataArr     = array();
                    foreach($version as $data) {
                        $start = $data['startdate'];
                        $end   = $data['releasedate'];

                        //echo $start." === ".$end."<br />";

                        if($lowestDate == 0 && $highestDate == 0) {
                            $lowestDate  = $start;
                            $highestDate = $end;
                        }

                        if(!empty($start) && strtotime($lowestDate) > strtotime($start)) {
                            $lowestDate = $start;
                        }
                        if(!empty($end) && strtotime($highestDate) < strtotime($end)) {
                            $highestDate = $end;
                        }

                        $dataArr[] = $data;

                    }

                    $resData[$projectName][$versionN0][] = array("date" => $dataArr, "version" => array("lowest" => $lowestDate, "highest" => $highestDate));

                }
            }
        }

        return $resData;

    }

    function GetFileName($department, $year)
    {
        //$formattedFile = "PHP_Deliverables_2016";

        if(empty($year)) {
            $year = Date("Y");
        }

        return $department . "_Deliverables_" . $year;

    }

    function GetSheetName($year, $monthName)
    {
        //$formattedFile = "February_2016";

        if(empty($year)) {
            $year = Date("Y");
        }
        if(empty($monthName)) {
            $monthName = Date("F");
        }
        else {
            $monthName = ucfirst(strtolower($monthName));
        }

        return $monthName . "_" . $year;

    }


}


?>
