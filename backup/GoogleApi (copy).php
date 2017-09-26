<?php

/**
 *
 */
namespace project\GoogleApi;

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\Exception;
use Google\Spreadsheet\ServiceRequestFactory;

class GoogleApi
{
    public $table = false;

    private $client_email;
    private $private_key;
    private $scopes;
    private $user_to_impersonate;
    private $credentials = array();

    /**
     * GoogleApi initConfig.
     */
    public function initConfig()
    {
        $this->client_email = 'googlesheetservice@melodic-lantern-180711.iam.gserviceaccount.com';
        $this->scopes       = array('https://spreadsheets.google.com/feeds');;
        $this->private_key         = "0bbab09bedb150d9177dbd8ac2bf6a7dd619d05b";
        $this->user_to_impersonate = 'tasfin.hasan@fieldnation.com';
        $this->credentials         = new \Google_Auth_AssertionCredentials($this->client_email, $this->scopes, $this->private_key, 'notasecret', // Default P12 password
            'http://oauth.net/grant_type/jwt/1.0/bearer', // Default grant type
            $this->user_to_impersonate);
    }


    public function getSheetFeed()
    {
        $this->initConfig();
        $client = new \Google_Client();
        $client->setAccessType("offline");
        $client->setAssertionCredentials($this->credentials);
        if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion();
        }

        $accessTokenObj = json_decode($client->getAccessToken());
        $accessToken    = $accessTokenObj->access_token;

        $serviceRequest = new DefaultServiceRequest($accessToken);

        ServiceRequestFactory::setInstance($serviceRequest);

        $spreadsheetService = new \Google\Spreadsheet\SpreadsheetService();
        $spreadsheetFeed    = $spreadsheetService->getSpreadsheets();

        return $spreadsheetFeed;
    }

    function getListFeed($spreadsheetFeed, $fileName, $sheetName)
    {
        try {
            $spreadsheet = $spreadsheetFeed->getByTitle($fileName);
            //$spreadsheet = $spreadsheetFeed->getByTitle('Python_Scrum_October_2015');

            if($spreadsheet != null) {
                $worksheetFeed = $spreadsheet->getWorksheets();

                if($worksheetFeed != null) {
                    $worksheet = $worksheetFeed->getByTitle($sheetName);
                    if($worksheet != null) {
                        $listFeed = $worksheet->getListFeed();
                    }
                    else {
                        return null;
                    }
                }
                else {
                    return null;
                }
            }
            else {
                return null;
            }

            return $listFeed;
        } catch (Exception $e) {
            echo "Error from getListFeed() in GoogleApi Model====";
            pr($e->getMessage());
            var_dump($e);
            die;
        }
    }

    function getFeedData($listFeedFormatted, $fileName, $sheetName)
    {
        $dataRes   = $listFeedFormatted->getEntries();
        $returnArr = array();
        if($dataRes) {
            foreach($dataRes as $entry) {
                $dataRow     = $entry->getValues();
                $returnArr[] = $dataRow;
            }
        }

        return $returnArr;

    }

    function SaveInCache($returnArr, $fileName, $sheetName)
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
            $fileArr          = stat($jsonFileName);
            $lastModifiedTime = $fileArr['mtime'];
            $currentTime      = time();


            $loadFromCacheStatus = false;
            if($fileType == "scrum") {
                $fileNameArr = explode("_", $fileName);
                $year        = $fileNameArr[count($fileNameArr) - 1];
                $sheetArr    = explode("_", $sheetName);
                $weekNo      = $sheetArr[count($sheetArr) - 1];
                $scrumModel  = $this->m->Scrum;
                $dateRange   = $scrumModel->GetWeekDateRange($weekNo, $year, 1);

                $currentDateRange = $scrumModel->GetWeekDateRange(Date("W"), Date("Y"), 1);

                if($dateRange['end'] < $currentDateRange['start']){
                    $loadFromCacheStatus = true;
                }
            }
            else {
                $sheetArr   = explode("_", $sheetName);
                $year       = $sheetArr[count($sheetArr) - 1];
                $monthName  = $sheetArr[count($sheetArr) - 2];
                if($monthName){
                    $monthNo = $this->m->Constant->getMonthName($monthName);
                }
                else{
                    $monthNo = Date("m");
                }

                $requestedDateTime  = strtotime($year."-".$monthNo."-01");
                $currentDateTime = strtotime(Date("Y-m-01"));

                if($requestedDateTime < $currentDateTime){
                    $loadFromCacheStatus = true;
                }
            }

            $validTime = Constant::$cacheValidTime;

            if(($lastModifiedTime + $validTime) >= $currentTime || $loadFromCacheStatus) {
                return json_decode(file_get_contents($jsonFileName), true);
            }
            else {
                return -1; // cache data expired
            }
        }

        return -1; // file does not exist
    }

    function GetDataFromLive($fileName, $sheetName)
    {
        $spreadsheetFeed   = $this->getSheetFeed();
        $listFeedFormatted = $this->getListFeed($spreadsheetFeed, $fileName, $sheetName);
        if($listFeedFormatted != null) {
            $finalData = $this->getFeedData($listFeedFormatted, $fileName, $sheetName);
            $this->SaveInCache($finalData, $fileName, $sheetName);
        }
        else {
            $this->SaveInCache(array(), $fileName, $sheetName);
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


}



