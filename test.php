<?php set_include_path("../src/" . PATH_SEPARATOR . get_include_path());
require_once ('Google/Client.php');
require_once ('Google/Service/Analytics.php');
// Initialise the Google Client object $client = new Google_Client();
$client->setApplicationName('Your product name');

$client->setAssertionCredentials(
    new Google_Auth_AssertionCredentials(
        'your_service_account_email@developer.gserviceaccount.com',
        array('https://www.googleapis.com/auth/analytics.readonly'),
        file_get_contents("YOUR_P12_FILE_LOCATION.p12")
    )
);

// Get this from the Google Console, API Access page
$client->setClientId('YOUR_CLIENT_ID.apps.googleusercontent.com');
$client->setAccessType('offline_access');

// Create the Analytics object, build the query and make a call ot the API
$analytics = new Google_Service_Analytics($client);
$analytics_id   = 'ga:11111111';
$lastWeek       = date('Y-m-d', strtotime('-52 week'));
$today          = date('Y-m-d');
    try {
        $optParams = array();
        //Uncomment any of the optional parameters to include them in your query
        #$optParams['dimensions'] = "";
        #$optParams['sort'] = "";
        #$optParams['filters'] = "";
        #$optParams['max-results'] = "";
        $metrics = 'ga:visits';
        $results = $analytics->data_ga->get($analytics_id,
                            $lastWeek,
                            $today,$metrics,$optParams);
        print_r($results);
    } catch(Exception $e) {
        echo 'There was an error : - ' . $e->getMessage();
    }
