<?php

    class ReturnedAnalyticsOne
    {
        private $date;
        private $source;
        private $medium;
        private $channel_grouping;
        private $device_category;
        private $landing_page_path;
        private $id;

        function __construct($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path, $id = null)
        {
            $this->date = $date;
            $this->source = $source;
            $this->medium = $medium;
            $this->channel_grouping = $channel_grouping;
            $this->device_category = $device_category;
            $this->landing_page_path = $landing_page_path;
            $this->id = $id;
        }

        function setDate($new_date)
        {
            $this->date = $new_date;
        }

        function getDate()
        {
            return $this->date;
        }

        function setSource($new_source)
        {
            $this->source = $new_source;

        }

        function getSource()
        {
          return $this->source;
        }

        function setMedium($new_medium)
        {
            $this->medium = $new_medium;

        }

        function getMedium()
        {
          return $this->medium;
        }

        function setChannelGrouping($new_channel_grouping)
        {
            $this->channel_grouping = $new_channel_grouping;

        }

        function getChannelGrouping()
        {
          return $this->channel_grouping;
        }

        function setDeviceCategory($new_device_category)
        {
            $this->device_category = $new_device_category;

        }

        function getDeviceCategory()
        {
          return $this->device_category;
        }

        function setLandingPagePath($new_landing_page_path)
        {
            $this->landing_page_path = $new_landing_page_path;
        }

        function getLandingPagePath()
        {
            return $this->landing_page_path;
        }



        // function setSessions($new_sessions)
        // {
        //     $this->sessions = $new_sessions;
        // }
        //
        // function getSessions()
        // {
        //     return $this->sessions;
        // }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO analytics_site1 (date, source, medium, channel_grouping, device_category, landing_page_path) VALUES ('{$this->date}', '{$this->source}', '{$this->medium}', '{$this->channel_grouping}', '{$this->device_category}', '{$this->landing_page_path}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll($returned_data)
        {
            try {
                $data = array();
                foreach($returned_data as $row) {
                $date = $row[0];
                $source = $row[1];
                $medium = $row[2];
                $channel_grouping = $row[3];
                $device_category = $row[4];
                $landing_page_path = $row[5];

                $analytics_object = new ReturnedAnalyticsOne($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path);
                $analytics_object->save();

                array_push($data, $analytics_object);
                }
                print "<pre>";
                print_r ($data);
                Print "</pre>";
            }   catch (Exception $e) {
                echo "Data could not be saved to the database.";
                exit;
                }

        }






    }




 ?>
