<?php

    /**
     * Sets timezone for Symfony
     */

    date_default_timezone_set('America/Los_Angeles');
    /**
     * Load PHP library, Our ETL Classes, and database login info
     */


    require_once __DIR__."/../../vendor/autoload.php";
    require_once __DIR__."/../../src/ReturnedAnalytics.php";
    require_once __DIR__."/../../src/Sites.php";
    require_once __DIR__."/../../src/user_data.php";


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

    $app = new Silex\Application();
    $app["debug"] = true;


    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //This takes the user to "/" page, in which we render our index.html.twig page. It also pushes our categories to be listed.
    $app->get("/", function() use ($app){
    return $app['twig']->render('index.html.twig', array('sites' => Sites::getAll()));

    });

    $app->get('/site/{id}', function($id) use ($app) {
        return $app['twig']->render('site.html.twig', array('analytics' => ReturnedAnalytics::getAll($id)));
    });

    return $app;

?>
