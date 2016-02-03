<?php
/**
 * Load Google API library, Our ETL Classes, and authorization credentials
 */

require_once 'vendor/autoload.php';
require_once 'src/ReturnedAnalyticsOne.php';
require_once 'src/Sites.php';
require_once 'src/user_data.php';

/**
 * Start session to store auth data
 */

session_start();

/**
 * Connect to database
 */

try {
  $server = $server_placeholder;
  $username = $username_placeholder;
  $password = $password_placeholder;
  //setting up connection to our database
  $DB = new PDO($server, $username, $password);
  //Throw an exception when an error is encountered in the query
  $DB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $DB->exec("SET NAMES 'utf8'");
} catch (Exception $e) {
  echo "Could not connect to the database";
  exit;
}

$details = Sites::getAll();
$detail = $details[0];

// print_r($detail->analytics_profile);

/**
 * Set Google service account details
 */

$google_account = array(
      'email'   => $google_email_placholder,
      'key'     => file_get_contents( $google_key_placeholder ),
      'profile' => $google_profile_placholder
);

/**
 * Get Analytics API object
 */

function getService( $service_account_email, $key ) {
    // Creates and returns the Analytics service object.

    // Load the Google API PHP Client Library.
    require_once 'vendor/autoload.php';

    // Create and configure a new client object.
    $client = new Google_Client();
    $client->setApplicationName( 'Google Analytics Dashboard' );
    $analytics = new Google_Service_Analytics( $client );

    // Read the generated client_secrets.p12 key.
    $cred = new Google_Auth_AssertionCredentials(
      $service_account_email,
      array( Google_Service_Analytics::ANALYTICS_READONLY ),
      $key
    );
    $client->setAssertionCredentials( $cred );
    if( $client->getAuth()->isAccessTokenExpired() ) {
    $client->getAuth()->refreshTokenWithAssertion( $cred );
    }

    return $analytics;
}

/**
 * Get Analytics API instance
 */

$analytics = getService(
  $google_account[ 'email' ],
  $google_account[ 'key' ]
);

/**
 * Query the Analytics data.
 * date, source, medium,channel_grouping, device_category, landing_page_path, sessions,
 * transactions, transaction_revenue, page_views, bounces, session_duration, hits, total_events,
 * unique_events, users, entrances, exits
 */

$foo = $detail->analytics_profile; // hotel delux
$packaged_data = ReturnedAnalyticsOne::extractAnalytics( $analytics, $foo );

/**
 * Instance ReturnedAnalyticsOne Object via tranform method.
 */

 ReturnedAnalyticsOne::transform( $packaged_data );


















// ========================================================================/
//  The
//     Bone
//          yard
// ========================================================================/


/**
* Format and output data as JSON
*/

// $data = array();
// foreach( $returned_data as $row ) {
//   $data[] = array(
//     //dimensions
//     'date'   => $row[0],
//     'source'  => $row[1],
//     'medium' => $row[2],
//     'channelGrouping'=> $row[3],
//     'deviceCategory' => $row[4],
//     'landingPagePath' => $row[5],
//     //metrics
//     'sessions' => $row[6],
//     'transactions' => $row[7],
//     'transactionRevenue'=> $row[8],
//     'pageViews' => $row[9],
//     'bounces' =>$row[10],
//     'sessionDuration' => $row[11],
//     'hits' => $row[12],
//     'totalEvents' => $row[13],
//     'uniqueEvents' => $row[14]
//   );
// }

// echo json_encode( $data );
//Get the returned analytics data and save it to the database

//print_r($returned_data_2);

// print "<pre>";
// print_r($returned_data_two);
// print "</pre>";

/**
* Format and output second data set as JSON
*/
// $data_2 = array();
// foreach( $returned_data_2 as $row ) {
//   $data_2[] = array(
//     //dimensions
//     'date'   => $row[0],
//     'source'  => $row[1],
//     'medium' => $row[2],
//     'channelGrouping'=> $row[3],
//     'deviceCategory' => $row[4],
//     'landingPagePath' => $row[5],
//     //metrics
//     'sessions' => $row[6],
//     'users' => $row[7],
//     'entrances' => $row[8],
//     'exits'=> $row[9]
//
//   );
// }

// echo json_encode( $data_2 );
// print "<pre>";
// print_r($data_2);
// print "</pre>";

//Treehouse example

// try {
//   $results = $DB->query("SELECT date, sessions FROM sessions");
//   echo "Our query ran succesfully.";
// } catch (Exception $e) {
//   echo "Data could not be retrieved from the database.";
//   exit;
// }
