<?php

/**
 *
 */
namespace project\GoogleApi;
require_once __DIR__ . '/vendor/autoload.php';

use Google\Spreadsheet\SpreadsheetService;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\DefaultServiceRequest;
use Google_Client;
use Google_Service_Drive;
use Google\Spreadsheet\Batch;
use Google\Spreadsheet\Batch\BatchResponse;

class GoogleApi
{
    /**
     * GoogleApi initConfig.
     */
    public function initConfig()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/config/client_secret.json');
    }


    /**
     * @return mixed
     */
    public function getSheetFeed($fileName)
    {
        $this->initConfig();
        $client = new Google_Client;
        $client->useApplicationDefaultCredentials();

        $client->setApplicationName("Google Sheet Report");
        $client->addScope(Google_Service_Drive::DRIVE);

        if ($client->isAccessTokenExpired()) {
            $client->refreshTokenWithAssertion();
        }

        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        ServiceRequestFactory::setInstance(
            new DefaultServiceRequest($accessToken)
        );

        $spreadsheetService = new SpreadsheetService();
        $spreadsheet = $spreadsheetService->getSpreadsheetFeed()->getByTitle($fileName);

        return $spreadsheet;
    }

    function getListFeed($spreadsheet, $sheetName = 0)
    {
        try {
            // Get the first worksheet (tab)
            $worksheets = $spreadsheet->getWorksheetFeed();//->getEntries();
            //$worksheet = $worksheets[$sheetIndex];

            $worksheet = $worksheets->getByTitle($sheetName);

            $listFeed = $worksheet->getListFeed();

            return $listFeed;
        } catch (Exception $e) {
            echo "Error from getListFeed() in GoogleApi Model====";
            pr($e->getMessage());
            var_dump($e);
            die;
        }
    }

    function getFeedData($listFeed)
    {
        $dataRes   = $listFeed->getEntries();
        $returnArr = array();
        if($dataRes) {
            foreach($dataRes as $entry) {
                $returnArr[] = $entry->getValues();
            }
        }

        return $returnArr;

    }

    function saveInCache($returnArr, $fileName, $sheetName)
    {
        $fileName = "temp/" . $fileName . "_" . $sheetName . ".json";
        //var_dump($fileName);
        file_put_contents($fileName, json_encode($returnArr));

    }

    function GetCachedFilePath($fileName, $sheetName)
    {

        return "temp/" . $fileName . "_" . $sheetName . ".json";
    }

    function fetchFromCache($fileName, $sheetName, $fileType)
    {
        $jsonFileName = $this->GetCachedFilePath($fileName, $sheetName);

        if(file_exists($jsonFileName)) {
            return json_decode(file_get_contents($jsonFileName), true);
        }

        return -1; // file does not exist
    }

    function getDataFromLive($fileName, $sheetName)
    {
        $spreadsheet   = $this->getSheetFeed($fileName);
        $listFeedFormatted = $this->getListFeed($spreadsheet, $sheetName);
        if($listFeedFormatted != null) {
            $finalData = $this->getFeedData($listFeedFormatted);
            $this->saveInCache($finalData, $fileName, $sheetName);
        }
        else {
            $this->saveInCache(array(), $fileName, $sheetName);
            return -1;
        }




        return $finalData;
    }

    function fetch($fileName, $sheetName, $fileType, $fetchFromLive = false)
    {
        /*
         * 1. check cache file/ data has expired; valid for 30 mins
         * 2. if expired then load data from live google sheet
         */

        if($fetchFromLive == true) {
            $data = $this->GetDataFromLive($fileName, $sheetName);
            //pr($data);
        }
        else {
            $data = $this->fetchFromCache($fileName, $sheetName, $fileType);

            if($data == -1) { // -1 = cache expired or does not exist
                $data = $this->GetDataFromLive($fileName, $sheetName);
            }
        }

        return $data;

    }

    function writeDataInSpreadSheet($fileName, $resData, $selectedTabName = "-1", $noOfTab = -1){
        $spreadsheet   = $this->getSheetFeed($fileName);


        if($resData){
            $execute = false;
            $counter = 0;
            foreach ($resData as $tabName => $result){
                //$tabName = 'tasfin';
                //$worksheetFeed = $spreadsheet->getWorksheets();
                if($tabName == $selectedTabName){
                    $execute = true;
                    //die("ddd");
                }

                if($execute) {
                    $counter++;
                    $spreadsheet->addWorksheet($tabName, count($result) + 1, 4);
                    //$spreadsheet->addWorksheet("Tasfin", count($result)+1, 4);

                    $spreadsheet = $this->getSheetFeed($fileName);
                    $worksheets = $spreadsheet->getWorksheetFeed();//->getEntries();
                    // add header
                    $worksheet = $worksheets->getByTitle($tabName);

                    //var_dump($worksheet);
                    $cellFeed = $worksheet->getCellFeed();
                    $cellFeed->editCell(1, 1, "Title");
                    $cellFeed->editCell(1, 2, "Description");
                    $cellFeed->editCell(1, 3, "Steps");
                    $cellFeed->editCell(1, 4, "Expected Result");

                    // add row
                    if ($result) {
                        $listFeed = $worksheet->getListFeed();
                        $entries = $listFeed->getEntries();
                        //$listFeed->insert(["title" => "Someone", "description" => '25', "steps" => '25', "expectedresult" => '25']);
                        //print_r($entries[0]->getValues()); die;

                        //$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
                        $rowCount = 1;
                        foreach ($result as $key => $row) {
                            $rowCount++;
                            /*$batchRequest->addEntry($cellFeed->createCell($rowCount, 1, urlencode($row['title'])));
                            $batchRequest->addEntry($cellFeed->createCell($rowCount, 2, $row['description']));
                            $batchRequest->addEntry($cellFeed->createCell($rowCount, 3, $row['steps']));
                            $batchRequest->addEntry($cellFeed->createCell($rowCount, 4, $row['expectedresults']));*/

                            $listFeed->insert([
                                "title"          => $row['title'],
                                "description"    => $row['description'],
                                "steps"          => $row['steps'],
                                "expectedresult" => $row['expectedresults']
                            ]);
                        }
                        //$batchResponse = $cellFeed->insertBatch($batchRequest);
                    }
                }
                if($counter == $noOfTab){
                    break;
                }

            }
        }



        //$cellFeed = $worksheet->getCellFeed();



    }


}



