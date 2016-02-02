<?php
/**
 * Load Google API library
 */
require_once 'vendor/autoload.php';
require_once 'src/ReturnedAnalyticsOne.php';
require_once 'src/user_data.php';

/**
 * Start session to store auth data
 */
session_start();
//
// try {
//   $server = $server_placeholder;
//   $username = $username_placeholder;
//   $password = $password_placeholder;
//   //setting up connection to our database
//   $DB = new PDO($server, $username, $password);
//   //Throw an exception when an error is encountered in the query
//   $DB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//   $DB->exec("SET NAMES 'utf8'");
//   // var_dump($DB);
// } catch (Exception $e) {
//   echo "Could not connect to the database";
//   exit;
// }



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
 * Query the Analytics data
 */

$results = $analytics->data_ga->get(
  'ga:' . $google_account[ 'profile' ], //profile id
  'yesterday', // start date
  'today',  // end date
  'ga:sessions, ga:transactions, ga:transactionRevenue, ga:pageViews, ga:bounces, ga:sessionDuration, ga:hits, ga:totalEvents, ga:uniqueEvents', //metrics

  array(
    'dimensions' => 'ga:date, ga:source, ga:medium, ga:channelGrouping, ga:deviceCategory, ga:landingPagePath ',
    'sort'        => 'ga:date',
    'max-results' => 3
  )
);

// print_r($results);

$returned_data = $results->getRows();

//print_r($returned_data);

// print "<pre>";
// print_r($returned_data);
// print "</pre>";

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


/**
 * Query the Analytics data a second time
 */

$results_2 = $analytics->data_ga->get(
  'ga:' . $google_account[ 'profile' ], //profile id
  'yesterday', // start date
  'today',  // end date
  'ga:sessions, ga:users, ga:newUsers, ga:entrances, ga:exits' , //metrics

  array(
    'dimensions' => 'ga:date, ga:source, ga:medium, ga:channelGrouping, ga:deviceCategory, ga:landingPagePath ',
    'sort'        => 'ga:date',
    'max-results' => 3
  )
);

$returned_data_2 = $results_2->getRows();

//print_r($returned_data_2);

$all_things = array();
$thing = sizeof($returned_data);
print_r($thing);
for($i = 0; $i < $thing; $i++ ) {
    $sliced = array_slice($returned_data_2[$i], 7, 3);
    $merged = array_merge($returned_data[$i],$sliced);
    array_push($all_things, $merged);
}

//print_r($all_things);
ReturnedAnalyticsOne::transform($all_things);


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
