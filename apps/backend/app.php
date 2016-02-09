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
 * Set timestamp for logging
 */

date_default_timezone_set('Etc/GMT');
$today = date('Y-m-d H:i:s', strtotime( $today." GMT+8"));

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
        echo $today . " " .$e->getMessage(). " In file " .$e->getFile(). " line " .$e->getLine(). "\n";
        exit;
}

/**
 * Set Google service account details
 */

$google_account = array(
      'email'   => $google_email_placeholder,
      'key'     => file_get_contents( $google_key_placeholder ),
      'profile' => $google_profile_placeholder
);

$email_check = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
if (preg_match($email_check, $google_account[email]) === 1) {
    // the email is valid
} else {
    trigger_error('Invalid email address in google_accont ', E_USER_NOTICE);
}

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
 * Gets objects from the site table
 */

$site_details = Sites::getAll();

$site_details_length = sizeof($site_details);
if ($site_details_length <= 0) {
    trigger_error('Size of site_details_length must be greater than zero', E_USER_NOTICE);
}
echo "*******************" . "\n";
echo "* total sites : " . $site_details_length . " *" . "\n";
echo "*******************" . "\n";


/**
 * Query the Analytics data.
 * date, source, medium,channel_grouping, device_category, landing_page_path, sessions,
 * transactions, transaction_revenue, page_views, bounces, session_duration, hits, total_events,
 * unique_events, users, entrances, exits
 */

$num = 1;
for($i = 0; $i < $site_details_length; $i++) {

    $detail = $site_details[$i];
    echo $detail->name . "\n";
    $packaged_data = ReturnedAnalytics::extractAnalytics( $analytics, $detail->analytics_profile );
    $analytics_site = ("analytics_site" . $num++);
    echo $analytics_site . "\n";

    /**
     * Instance ReturnedAnalyticsOne Object via tranform method.
     */

    //ReturnedAnalytics::transform( $packaged_data, $analytics_site);

}

?>
