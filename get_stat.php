<?php
 
/**
 * 1. create project at https://console.developers.google.com/project
 * 2. enable 'Analytics API' under 'APIs & auth' / APIs
 * 3. create 'NEW CLIENT ID' (OAuth client) under 'APIs & auth' / Credentials
 *    i.  select 'Service account'
 *    ii. save generated key file to 'key.p12'
 *    iii. remember CLIENT ID
 * 4. under GA account add 'Read & Analyze' access to newly generated email (access to GA Account not Property nor View)
 * 5. get View ID. go to GA Admin section, select proper Account, than proper Property, than proper View.
      Under View click on 'View settings' and copy the number below 'View ID' (that is your GA_VIEW_ID number)
 * 5. download google php library https://github.com/google/google-api-php-client
 * 6. use the code below, use info from google API console (1.)
 *    doc here: https://developers.google.com/analytics/devguides/reporting/realtime/v3/reference/data/realtime/get 
 *    real time metrics doc: https://developers.google.com/analytics/devguides/reporting/realtime/dimsmets/
 */
 
set_include_path('src/' . PATH_SEPARATOR . get_include_path());
require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';
 
$CLIENT_ID = 'XXX.apps.googleusercontent.com';
$CLIENT_EMAIL = 'YYY@developer.gserviceaccount.com';
$SCOPE = 'https://www.googleapis.com/auth/analytics.readonly';
$KEY_FILE = 'key.p12';
$GA_VIEW_ID = 'ga:ZZZ';
 
$client = new Google_Client();
$client->setClientId($CLIENT_ID);
$client->setAssertionCredentials(
    new Google_Auth_AssertionCredentials(
        $CLIENT_EMAIL,
        array($SCOPE),
        file_get_contents($KEY_FILE)
    )
);
 
$service = new Google_Service_Analytics($client);
try {
    $result = $service->data_realtime->get(
        $GA_VIEW_ID,
        'rt:activeVisitors'
    );
    var_dump($result->totalsForAllResults['rt:activeVisitors']);
} catch(Exception $e) {
    var_dump($e);
}