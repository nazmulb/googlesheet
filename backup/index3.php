<?php
/**
 * Created by PhpStorm.
 * User: tasfin
 * Date: 25/09/17
 * Time: 14:29
 */

require_once "GoogleApi.php";
require_once "DataParser.php";

set_time_limit(0);

//echo "<pre>";
$fileName  = 'Backup_test_cases_xlsx_1_2';
$fromCache = false;

$googleApi = new \project\GoogleApi\GoogleApi();

$testCaseData   = $googleApi->fetch($fileName, "testcase",  $fromCache);
$stepMapData    = $googleApi->fetch($fileName, "steps",     $fromCache);
$stepResData    = $googleApi->fetch($fileName, "step",      $fromCache);

//print_r($stepResData); //die;

$tabData = mergeData($testCaseData, $stepMapData, $stepResData);
print_r($tabData); DIE;

//$googleApi->writeDataInSpreadSheet($fileName, $tabData);


echo "============= Done ====================";




/*
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/config/client_secret.json');
$client = new Google_Client;
$client->useApplicationDefaultCredentials();

$client->setApplicationName("Something to do with my representatives");
$client->addScope(Google_Service_Drive::DRIVE);

if ($client->isAccessTokenExpired()) {
    $client->refreshTokenWithAssertion();
}

$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
ServiceRequestFactory::setInstance(
    new DefaultServiceRequest($accessToken)
);

$spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
    ->getSpreadsheetFeed()
    ->getByTitle('Tour_2017');

// Get the first worksheet (tab)
$worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
$worksheet = $worksheets[0];

$listFeed = $worksheet->getListFeed();


foreach ($listFeed->getEntries() as $entry) {
    $representative = $entry->getValues();
    var_dump($representative); die;
}*/
?>


