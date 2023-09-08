<?php

class PluginDbpopulatorDbpopulator extends CommonDBTM {

    private $prefix;


    function __construct() {
        require_once '../vendor/autoload.php';
    }

    /**
     * Populate function
     * Select which function to call based on the array keys
     *
     * @param array $array
     * @return void
     */
    function populate(array $array) : void {

        self::setPrefix($array['prefix']);

        foreach ($array as $key => $value) {
            switch ($key) {
                case 'computers':
                    $this->populate_computer($value);
                    break;
                case 'users':
                    $this->populate_user($value);
                    break;
            }
        }
    }

    private function populate_item() {

    }

    /**
    * Populate computer in database with random data
    *
    * @param integer $number
    * @global object $DB
    * @return boolean
    */
    private function populate_computer(int $number) {
        global $DB;
        $faker = Faker\Factory::create();
        $name = array();
        $prefixe = self::getPrefix();

        foreach (range(1, $number) as $i) {
            $name[] =  $prefixe . $faker->randomNumber($nbDigits = NULL);
        }
        $query = "INSERT INTO `glpi_computers` (`name`) VALUES ('" . implode("'),('", $name) . "')";
        $DB->query($query) or die($DB->error());

        return true;
    }

    /**
     * Populate user in database with random data
     *
     * @param integer $number
     * @global object $DB
     * @return boolean
     */
    private function populate_user(int $number) : bool {
        global $DB;
        $faker = Faker\Factory::create();

        foreach (range(1, $number) as $i) {
            $name[] =  $faker->firstName();
        }
        $query = "INSERT INTO `glpi_users` (`name`) VALUES ('" . implode("'),('", $name) . "')";
        $DB->query($query) or die($DB->error());
        
        return true;
    }

    

    /**
     * Get the value of prefix
     * @return string
     */ 
    private function getPrefix() {
        return $this->prefix;
    }

    /**
     * Set the value of prefix
     *
     * @return  self
     */ 
    private function setPrefix($prefix) {
        // If prefix is empty, set it to fake_
        if (empty($prefix)) {
            $prefix = 'fake_';
        }

        $this->prefix = $prefix;

        return $this->prefix;
    }
}