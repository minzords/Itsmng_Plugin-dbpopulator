<?php

class PluginDbpopulatorDbpopulator extends CommonDBTM
{
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
    function populate(string $format, string $table, int $quantity): void
    {
        global $DB;
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
                    $query .= '"' .self::generateFormatedValue($format). '",';            
                }
            }
            $query = substr($query, 0, -1);
            $query .= "),";
        }
        $query = substr($query, 0, -1);
        $DB->query($query);
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
     * generate the formatted value
     * 
     * @param string $format
     * @return string
     */
    private function generateFormatedValue(string $format): string {
        $faker = Faker\Factory::create();
        $random_value = $faker->randomNumber(6);
        if (count(explode("%%", $format)) == 1) {
            return $format.$random_value;
        } else {
            return str_replace("%%", $random_value, $format);
        }
    }
}
