<?php

    class ReturnedAnalyticsOne
    {
        public $date;
        public $source;
        public $id;

        function __construct($date, $source, $id = null)
        {
            $this->date = $date;
            $this->source = $source;
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
            $GLOBALS['DB']->exec("INSERT INTO analytics_site1 (date, source) VALUES ('{$this->date}', '{$this->source}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll($returned_data)
        {
            try {
                $data = array();
                foreach($returned_data as $row) {
                $date = $row[0];
                $source = $row[1];
                $analytics_object = new ReturnedAnalyticsOne($date, $source);
                $analytics_object->save();

                array_push($data, $analytics_object);
                }
                print_r ($data);
            }   catch (Exception $e) {
                echo "Data could not be saved to the database.";
                exit;
                }

        }






    }




 ?>
