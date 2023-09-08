<?php

class PluginDbpopulatorDbpopulator extends CommonDBTM {

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
        $words = array();
        $prefixe = 'nodejs_';

        foreach (range(1, $number) as $i) {
            $words[] =  $prefixe . $faker->randomNumber($nbDigits = NULL);
        }
        die ($query = "INSERT INTO `glpi_computers` (`name`) VALUES ('" . implode("'),('", $words) . "')");
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

        // foreach (range(1, $number) as $i) {
        //     $query = "INSERT INTO `glpi_computers` (`name`) VALUES ('%s');";
        //     $query = sprintf($query, $faker->word());
        //     $DB->query($query) or die($DB->error());
        // }

        // die('Not implemented yet');

        return true;
    }
}