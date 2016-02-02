<?php

    class ReturnedAnalyticsOne
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
    * saveAll method
    * inserts data from google analytics api into mysql data warehouse.
    */

        function saveAll()
        {
            $GLOBALS['DB']->exec("INSERT INTO analytics_site1 (date, source, medium, channel_grouping, device_category, landing_page_path, sessions, transactions, transaction_revenue, page_views, bounces, session_duration, hits, total_events, unique_events, users, entrances, exits) VALUES ('{$this->date}', '{$this->source}', '{$this->medium}', '{$this->channel_grouping}', '{$this->device_category}', '{$this->sessions}', '{$this->landing_page_path}', '{$this->transactions}', '{$this->transaction_revenue}','{$this->page_views}', '{$this->bounces}', '{$this->session_duration}', '{$this->hits}', '{$this->total_events}', '{$this->unique_events}', '{$this->users}', '{$this->entrances}', '{$this->exits}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

    /**
    * transform method
    * accepts the api data and intances the object to prepare the data to be saved.
    */


        static function transform($returned_data)
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

                $analytics_object = new ReturnedAnalyticsOne($date, $source, $medium, $channel_grouping, $device_category, $landing_page_path, $sessions, $transactions, $transaction_revenue, $page_views, $bounces, $session_duration, $hits, $total_events, $unique_events, $users, $entrances, $exits);

                // $analytics_object->save();

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
