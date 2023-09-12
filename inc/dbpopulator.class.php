<?php

class PluginDbpopulatorDbpopulator extends CommonDBTM
{

    private $prefix;


    /**
     * Constructor
     */
    function __construct()
    {
        require_once '../vendor/autoload.php';
    }

    /**
     * Populate function
     * Select which function to call based on the array keys
     *
     * @param array $array
     * @return void
     */
    function populate(string $prefix, string $type, int $quantity): void
    {
        echo "Populating " . $type . " with " . $quantity . " entries\n";
        self::setPrefix($prefix);
        self::populateTable($type, self::getPrefix(), $quantity);
    }

    /**
     * get the columns of a table
     * 
     * @param string $table
     * @global object $DB
     * 
     * @return array
     */
    private function getColumnsFromTable(string $table)
    {
        global $DB;
        $queryValue = "select GROUP_CONCAT(column_name) nonnull_columns 
        from information_schema.columns 
        where table_schema = '".$DB->dbdefault."' and
        table_name = '" . $table . "' and
        is_nullable = 'YES'";
        $values = explode(',', $DB->query($queryValue)->fetch_assoc()['nonnull_columns']);
        $queryValue = "select GROUP_CONCAT(column_type) nonnull_columns 
        from information_schema.columns 
        where table_schema = '".$DB->dbdefault."' and
        table_name = '" . $table . "' and
        is_nullable = 'YES'";
        $types = explode(',', $DB->query($queryValue)->fetch_assoc()['nonnull_columns']);

        $ret = [];
        foreach ($values as $index => $col) {
            $ret[$col] = $types[$index];
        }

        return $ret;
    }


    /**
     * Populate a table with fake data using faker
     * 
     * @param string $table
     * @param string $prefix
     * @param int $quantity
     * @global object $DB
     */
    private function populateTable(string $table, string $prefix, int $quantity) {
        global $DB;
        $faker = Faker\Factory::create();
        $columns = self::getColumnsFromTable($table);
        $query = "INSERT INTO " . $table . " (";
        foreach ($columns as $index => $value) {
            if ($index == 'name') {
                $query .= $index . ",";
            }
        }
        $query = substr($query, 0, -1);
        $query .= ") VALUES ";
        foreach (range(1, $quantity) as $number) {
            $query .= "(";
            foreach ($columns as $index => $value) {
                if ($index == "name") {
                    $query .= '"' . $prefix . "_" . $faker->randomNumber(6, true). '",';            
                }
            }
            $query = substr($query, 0, -1);
            $query .= "),";
        }
        $query = substr($query, 0, -1);
        $DB->query($query);
    }


    /**
     * Get the value of prefix
     * @return string
     */
    private function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the value of prefix
     *
     * @return  self
     */
    private function setPrefix($prefix)
    {
        // If prefix is empty, set it to fake_
        if (empty($prefix)) {
            $prefix = 'fake_';
        }

        $this->prefix = $prefix;

        return $this->prefix;
    }
}
