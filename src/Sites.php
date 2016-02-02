<?php

    class Sites
    {
        private $id;
        private $services_id;
        private $name;
        private $analytics_profile;

    // constructor

        function __construct($id = null, $services_id, $name, $analytics_profile)
        {

            $this->id = $id;
            $this->services_id = $services_id;
            $this->name = $name;
            $this->analytics_profile = $analytics_profile;

        }

    // get id

        function getId()
        {
            return $this->Id;
        }

    // get services_id

        function getServicesId()
        {
            return $this->services_id;
        }

    // get/set name

        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function getName()
        {
            return $this->name;
        }

    // get/set analytics_profile

        function setAnalyticsProfile($new_analytics_profile)
        {
            $this->analytics_profile = $new_analytics_profile;
        }
        function getAnalyticsProfile()
        {
            return $this->analytics_profile;
        }

    /**
    * getAll method
    * Queries site details from database.
    */

        static function getAll()
        {
            $sites = array();
            $returned_sites = $GLOBALS['DB']->query("SELECT * FROM sites;");
            foreach($returned_sites as $site) {
                $id = $site['id'];
                $services_id = $site['services_id'];
                $name = $site['name'];
                $analytics_profile = $site['analytics_profile'];
                $new_site = new Sites($id, $services_id, $name, $analytics_profile);

                array_push($sites, $new_site);
            }
            return $sites;
        }



    }

?>
