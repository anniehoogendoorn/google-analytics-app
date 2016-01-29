<?php

    class ReturnedAnalyticsOne
    {
        private $date;
        private $source;
        private $medium;
        private $id;

        function __construct($date, $source, $id = null)
        {
            $this->date = $date;
            $this->source = $source;
            $this->medium = $medium;
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
            $GLOBALS['DB']->exec("INSERT INTO analytics_site1 (date, source, medium) VALUES ('{$this->date}', '{$this->source}', '{$this->medium}')");
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

                $analytics_object = new ReturnedAnalyticsOne($date, $source, $medium);
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
