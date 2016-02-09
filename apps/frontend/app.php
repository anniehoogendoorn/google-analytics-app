<?php
/**
 * Load Google API library, Our ETL Classes, and authorization credentials
 */

    require_once __DIR__."/../../vendor/autoload.php";
    require_once __DIR__."/../../src/ReturnedAnalytics.php";
    require_once __DIR__."/../../src/Sites.php";
    require_once __DIR__."/../../src/user_data.php";

    $app = new Silex\Application();
    $app["debug"] = true;

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

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();




?>
