<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Sites.php";
    require "aws_user.php";

	try {
		$server = $server_placeholder;
		$username = $username_placeholder;
		$password = $password_placeholder;
		//setting up connection to our database
		$db = new PDO($server, $username, $password);
		//Throw an exception when an error is encountered in the query
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->exec("SET NAMES 'utf8'");
	} catch (Exception $e) {
	  	echo $e->getMessage(). " " .$e->getFile(). "\n";
	  exit;
	}

    class SitesTest extends PHPUnit_Framework_TestCase
	{
		function test_Sites_get()
		{

			//Arrange

			$id = null;
	        $services_id = null;
	        $name = 'hotel deluxe';
	        $analytics_profile = '5271170';

            $test_site = new Sites($id, $services_id, $name, $analytics_profile);

            //Act

            $result1 = $test_site->getId();
			$result2 = $test_site->getServicesId();
			$result3 = $test_site->getName();
			$result4 = $test_site->getAnalyticsProfile();

            //Assert

            $this->assertEquals($id, $result1);
			$this->assertEquals($service_id, $result2);
			$this->assertEquals($name, $result3);
			$this->assertEquals($analytics_profile, $result4);

		}

		function test_Sites_set()
		{

			//Arrange

			$id = null;
	        $services_id = null;
	        $name = 'hotel deluxe';
	        $analytics_profile = '5271170';

            $test_site = new Sites($id, $services_id, $name, $analytics_profile);

            //Act

			$test_site->setName('hotel max');
			$result1 = $test_site->getName();
			$test_site->setAnalyticsProfile('5271201');
			$result2 = $test_site->getAnalyticsProfile();

            //Assert

            $this->assertEquals('hotel max', $result1);
			$this->assertEquals('5271201', $result2);

		}

	}

?>
