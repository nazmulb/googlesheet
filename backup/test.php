<?php
/**
 * Created by PhpStorm.
 * User: tasfin
 * Date: 25/09/17
 * Time: 14:29
 */

/*require_once __DIR__ . '/vendor/autoload.php';

use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\DefaultServiceRequest;*/
require_once "GoogleApi.php";

set_time_limit(0);
echo "<pre>";
$fileName = 'Backup_test_cases_xlsx_1';
$sheet1Name = '0';
$sheet2Name = '';
$sheet3Name = '';

$googleApi = new \project\GoogleApi\GoogleApi();
$data = $googleApi->fetch($fileName, "testcase", false);
//$data = $googleApi->fetch($fileName, "step", false);
//$data = $googleApi->fetch($fileName, "steps", false);

print_r($data);


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
    print_r($representative);// die;
}*/



