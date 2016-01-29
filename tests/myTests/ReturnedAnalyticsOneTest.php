<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/ReturnedAnalyticsOne.php";
    require_once "aws_user.php";

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
	  	echo "Could not connect to the database";
	  exit;
	}

    class ReturnedAnalyticsOneTest extends PHPUnit_Framework_TestCase
	{
		function test_ReturnedAnalyticsOne_get()
		{

			//Arrange

            $date = "20160121";
            $source = '(direct)';
            $medium = '(none)';
			$channel_grouping = 'direct';
	        $device_category = 'desktop';
	        $landing_page_path = 'www.hoteldeluxe.com/';
	        $id = null;
            $test_returnedOne = new ReturnedAnalyticsOne($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path, $id);

            //Act

            $result1 = $test_returnedOne->getDate();
			$result2 = $test_returnedOne->getSource();
			$result3 = $test_returnedOne->getMedium();
			$result4 = $test_returnedOne->getChannelGrouping();
			$result5 = $test_returnedOne->getDeviceCategory();
			$result6 = $test_returnedOne->getLandingPagePath();
			$result7 = $test_returnedOne->getId();

            //Assert

            $this->assertEquals($date, $result1);
			$this->assertEquals($source, $result2);
			$this->assertEquals($medium, $result3);
			$this->assertEquals($channel_grouping, $result4);
			$this->assertEquals($device_category, $result5);
			$this->assertEquals($landing_page_path, $result6);
			$this->assertEquals($id, $result7);
		}

		function test_ReturnedAnalyticsOne_set()
		{

			//Arrange

            $date = "20160121";
            $source = '(direct)';
            $medium = '(none)';
			$channel_grouping = 'direct';
	        $device_category = 'desktop';
	        $landing_page_path = 'www.hoteldeluxe.com/';
	        $id = null;
            $test_returnedOne = new ReturnedAnalyticsOne($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path, $id);

            //Act

			$test_returnedOne->setDate("19771024");
            $result1 = $test_returnedOne->getDate();
			$test_returnedOne->setSource("(bananas)");
			$result2 = $test_returnedOne->getSource();
			$test_returnedOne->setMedium("(some)");
			$result3 = $test_returnedOne->getMedium();
			$test_returnedOne->setChannelGrouping("indirect");
			$result4 = $test_returnedOne->getChannelGrouping();
			$test_returnedOne->setDeviceCategory("reststop");
			$result5 = $test_returnedOne->getDeviceCategory();
			$test_returnedOne->setLandingPagePath("www.reddit.com/");
			$result6 = $test_returnedOne->getLandingPagePath();

            //Assert

            $this->assertEquals("19771024", $result1);
			$this->assertEquals("(bananas)", $result2);
			$this->assertEquals("(some)", $result3);
			$this->assertEquals("indirect", $result4);
			$this->assertEquals("reststop", $result5);
			$this->assertEquals("www.reddit.com/", $result6);

		}



	}	

?>
