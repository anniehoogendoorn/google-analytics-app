<?php
/**
 * Load Google API library, Our ETL Classes, and authorization credentials
 */

require_once __DIR__."/../../vendor/autoload.php";
require_once __DIR__."/../../src/ReturnedAnalytics.php";
require_once __DIR__."/../../src/Sites.php";
require_once __DIR__."/../../src/user_data.php";


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
    require_once __DIR__."/../../lib/Google/autoload.php";

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

$details_length = sizeof($details);

print_r($details_length);
$n = 1;
for($i = 0; $i < $details_length; $i++) {

    $detail = $details[$i];
    echo $detail->name . " ";
    $packaged_data = ReturnedAnalytics::extractAnalytics( $analytics, $detail->analytics_profile );
    $foo = ("analytics_site" . $n++);
    print_r($foo);

    ReturnedAnalytics::transform( $packaged_data, $foo );

}



//
// /**
//  * Instance ReturnedAnalyticsOne Object via tranform method.
//  */
//
//  ReturnedAnalyticsOne::transform( $packaged_data );
