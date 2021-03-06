<?php

    class ReturnedAnalytics
    {
        private $date;
        private $source;
        private $medium;
        private $channel_grouping;
        private $device_category;
        private $landing_page_path;
        private $sessions;
        private $transactions;
        private $transaction_revenue;
        private $page_views;
        private $bounces;
        private $session_duration;
        private $hits;
        private $total_events;
        private $unique_events;
        private $users;
        private $entrances;
        private $exits;
        private $id;

    // constructor

        function __construct($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path, $sessions, $transactions, $transaction_revenue, $page_views, $bounces, $session_duration, $hits, $total_events, $unique_events, $users, $entrances, $exits, $id = null)
        {
            $this->date = $date;
            $this->source = $source;
            $this->medium = $medium;
            $this->channel_grouping = $channel_grouping;
            $this->device_category = $device_category;
            $this->landing_page_path = $landing_page_path;
            $this->sessions = $sessions;
            $this->transactions = $transactions;
            $this->transaction_revenue = $transaction_revenue;
            $this->page_views = $page_views;
            $this->bounces = $bounces;
            $this->session_duration = $session_duration;
            $this->hits = $hits;
            $this->total_events = $total_events;
            $this->unique_events = $unique_events;
            $this->users = $users;
            $this->entrances = $entrances;
            $this->exits = $exits;

            $this->id = $id;
        }

    // get/set date

        function setDate($new_date)
        {
            $this->date = $new_date;
        }
        function getDate()
        {
            return $this->date;
        }

    // get/set source

        function setSource($new_source)
        {
            $this->source = $new_source;
        }
        function getSource()
        {
            return $this->source;
        }

    // get/set medium

        function setMedium($new_medium)
        {
            $this->medium = $new_medium;
        }
        function getMedium()
        {
          return $this->medium;
        }

    // get/set channel_grouping

        function setChannelGrouping($new_channel_grouping)
        {
            $this->channel_grouping = $new_channel_grouping;

        }
        function getChannelGrouping()
        {
          return $this->channel_grouping;
        }

    // get/set device_category

        function setDeviceCategory($new_device_category)
        {
            $this->device_category = $new_device_category;
        }
        function getDeviceCategory()
        {
          return $this->device_category;
        }

    // get/set landing_page_path

        function setLandingPagePath($new_landing_page_path)
        {
            $this->landing_page_path = $new_landing_page_path;
        }
        function getLandingPagePath()
        {
            return $this->landing_page_path;
        }

    // get/set sessions

        function setSessions($new_sessions)
        {
            $this->sessions = $new_sessions;
        }
        function getSessions()
        {
            return $this->sessions;
        }

    // get/set transactions

        function setTransactions($new_transactions)
        {
            $this->transactions = $new_transactions;
        }
        function getTransactions()
        {
            return $this->transactions;
        }

    // get/set transaction_revenue

        function setTransactionRevenue($new_transaction_revenue)
        {
            $this->transaction_revenue = $new_transaction_revenue;
        }
        function getTransactionRevenue()
        {
            return $this->transaction_revenue;
        }

    // get/set page_views

        function setPageViews($new_page_views)
        {
            $this->page_views = $new_page_views;
        }
        function getPageViews()
        {
            return $this->page_views;
        }

    // get/set bounces

        function setBounces($new_bounces)
        {
            $this->bounces = $new_bounces;
        }
        function getBounces()
        {
            return $this->bounces;
        }

    // get/set session_duration

        function setSessionDuration($new_session_duration)
        {
            $this->session_duration = $new_session_duration;
        }
        function getSessionDuration()
        {
            return $this->session_duration;
        }

    // get/set hits

        function setHits($new_hits)
        {
            $this->hits = $new_hits;
        }
        function getHits()
        {
            return $this->hits;
        }

    // get/set total_events

        function setTotalEvents($new_total_events)
        {
            $this->total_events = $new_total_events;
        }
        function getTotalEvents()
        {
            return $this->total_events;
        }

    // get/set unique_events

        function setUniqueEvents($new_unique_events)
        {
            $this->unique_events = $new_unique_events;
        }
        function getUniqueEvents()
        {
            return $this->unique_events;
        }

    // get/set users

        function setUsers($new_users)
        {
            $this->users = $new_users;
        }
        function getUsers()
        {
            return $this->users;
        }

    // get/set entrances

        function setEntrances($new_entrances)
        {
            $this->entrances = $new_entrances;
        }
        function getEntrances()
        {
            return $this->entrances;
        }

    // get/set exits

        function setExits($new_exits)
        {
            $this->exits = $new_exits;
        }
        function getExits()
        {
            return $this->exits;
        }

    // get id

        function getId()
        {
            return $this->id;
        }

    /**
    * extractAnalytics method
    * Gets data from google analytics api in two calls
    * (due to metrics/dementions limets) and combine them.
    */

        static function extractAnalytics($analytics, $analytics_profile)
        {

        /**
         * Query the Analytics data part one.
         * date, source, medium,channel_grouping, device_category, landing_page_path, sessions,
         * transactions, transaction_revenue, page_views, bounces, session_duration, hits, total_events, unique_events
         */

            $results = $analytics->data_ga->get(
              'ga:' . $analytics_profile, //profile id
              'yesterday', // start date
              'yesterday',  // end date
              'ga:sessions, ga:transactions, ga:transactionRevenue, ga:pageViews, ga:bounces, ga:sessionDuration, ga:hits, ga:totalEvents, ga:uniqueEvents', //metrics

              array(
                'dimensions' => 'ga:date, ga:source, ga:medium, ga:channelGrouping, ga:deviceCategory, ga:landingPagePath ',
                'sort'        => 'ga:date',
                'max-results' => 1
              )
            );

            $returned_data = $results->getRows();

        /**
         * Query the Analytics data part two.
         * users, entrances, exits
         */

            $results_2 = $analytics->data_ga->get(
              'ga:' . $analytics_profile, //profile id
              'yesterday', // start date
              'yesterday',  // end date
              'ga:sessions, ga:users, ga:newUsers, ga:entrances, ga:exits' , //metrics

              array(
                'dimensions' => 'ga:date, ga:source, ga:medium, ga:channelGrouping, ga:deviceCategory, ga:landingPagePath ',
                'sort'        => 'ga:date',
                'max-results' => 1
              )
            );

            $returned_data_2 = $results_2->getRows();

        /**
         * Join part one and two of the returned Analytics data.
         */

            $packaged_data = array();
            $returned_data_length = sizeof($returned_data);

            for($i = 0; $i < $returned_data_length; $i++ ) {
                $sliced = array_slice($returned_data_2[$i], 7, 3);
                $merged = array_merge($returned_data[$i],$sliced);
                array_push($packaged_data, $merged);
            }

            return $packaged_data;

        }

    /**
    * transform method
    * accepts the api data and intances the object to prepare the data to be saved.
    */

        static function transform($packaged_data, $analytics_site)
        {


                $data = array();
                foreach($packaged_data as $row) {
                $date = $row[0];
                $source = $row[1];
                $medium = $row[2];
                $channel_grouping = $row[3];
                $device_category = $row[4];
                $landing_page_path = $row[5];
                $sessions = $row[6];
                $transactions = $row[7];
                $transaction_revenue = $row[8];
                $page_views = $row[9];
                $bounces = $row[10];
                $session_duration = $row[11];
                $hits = $row[12];
                $total_events = $row[13];
                $unique_events = $row[14];
                $users = $row[15];
                $entrances = $row[16];
                $exits = $row[17];

                $analytics_object = new ReturnedAnalytics($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path, $sessions, $transactions, $transaction_revenue, $page_views, $bounces, $session_duration, $hits, $total_events, $unique_events, $users, $entrances, $exits);

                // uncommet to view output in console
                // print_r($analytics_object);

                // uncomment to save to DB
                // $analytics_object->saveAll($analytics_site);

                }

        }

    /**
    * saveAll method
    * inserts data from google analytics api into mysql data warehouse.
    */

        function saveAll($analytics_site)
        {

            $val = $GLOBALS['DB']->query('select 1 from ' . $analytics_site . ' LIMIT 1');
            if($val == FALSE)
            {
                 // No table was found. So we create one.

                $GLOBALS['DB']->exec("CREATE TABLE " . $analytics_site . " (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `sites_id` int(11) DEFAULT NULL,
                  `date` varchar(255) DEFAULT NULL,
                  `source` varchar(255) DEFAULT NULL,
                  `medium` varchar(255) DEFAULT NULL,
                  `channel_grouping` varchar(255) DEFAULT NULL,
                  `device_category` varchar(255) DEFAULT NULL,
                  `landing_page_path` varchar(255) DEFAULT NULL,
                  `sessions` varchar(255) DEFAULT NULL,
                  `transactions` varchar(255) DEFAULT NULL,
                  `transaction_revenue` varchar(255) DEFAULT NULL,
                  `page_views` varchar(255) DEFAULT NULL,
                  `bounces` varchar(255) DEFAULT NULL,
                  `session_duration` varchar(255) DEFAULT NULL,
                  `hits` varchar(255) DEFAULT NULL,
                  `total_events` varchar(255) DEFAULT NULL,
                  `unique_events` varchar(255) DEFAULT NULL,
                  `users` varchar(255) DEFAULT NULL,
                  `entrances` varchar(255) DEFAULT NULL,
                  `exits` varchar(255) DEFAULT NULL COMMENT ' ',
                  PRIMARY KEY (`id`),
                  KEY `sites_id` (`sites_id`),
                  CONSTRAINT `" . $analytics_site . "_ibfk_1` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            }

                // table was found.
                // echo $analytics_site. " was found \n";

                $GLOBALS['DB']->exec("INSERT INTO " . $analytics_site . " (date, source, medium, channel_grouping, device_category, landing_page_path, sessions, transactions, transaction_revenue, page_views, bounces, session_duration, hits, total_events, unique_events, users, entrances, exits) VALUES ('{$this->date}', '{$this->source}', '{$this->medium}', '{$this->channel_grouping}', '{$this->device_category}', '{$this->landing_page_path}', '{$this->sessions}', '{$this->transactions}', '{$this->transaction_revenue}','{$this->page_views}', '{$this->bounces}', '{$this->session_duration}', '{$this->hits}', '{$this->total_events}', '{$this->unique_events}', '{$this->users}', '{$this->entrances}', '{$this->exits}')");
                $this->id = $GLOBALS['DB']->lastInsertId();

        }

        /**
        * getAll method
        * gets data from analytics table in data warehouse.
        */

        static function getAll($id)
        {
            $rows = array();
            $returned_data = $GLOBALS['DB']->query("SELECT * FROM analytics_site" . $id);
            foreach($returned_data as $data) {

                $date = $data['date'];
                $source = $data['source'];
                $medium = $data['medium'];
                $channel_grouping = $data['channel_grouping'];
                $device_category = $data['device_category'];
                $landing_page_path = $data['landing_page_path'];
                $sessions = $data['sessions'];
                $transactions = $data['transactions'];
                $transaction_revenue = $data['transaction_revenue'];
                $page_views = $data['page_views'];
                $bounces = $data['bounces'];
                $session_duration = $data['session_duration'];
                $hits = $data['hits'];
                $total_events = $data['total_events'];
                $unique_events = $data['unique_events'];
                $users = $data['users'];
                $entrances = $data['entrances'];
                $exits = $data['exits'];

                $analytics_object = new ReturnedAnalytics($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path, $sessions, $transactions, $transaction_revenue, $page_views, $bounces, $session_duration, $hits, $total_events, $unique_events, $users, $entrances, $exits);
                array_push($rows, $analytics_object);
            }
            return $rows;
        }

    }

 ?>
