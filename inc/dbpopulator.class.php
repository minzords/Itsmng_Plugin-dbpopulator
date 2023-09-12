<?php

/**
 * ---------------------------------------------------------------------
 * ITSM-NG
 * Copyright (C) 2022 ITSM-NG and contributors.
 *
 * https://www.itsm-ng.org
 *
 * based on GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2003-2014 by the INDEPNET Development Team.
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of ITSM-NG.
 *
 * ITSM-NG is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * ITSM-NG is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ITSM-NG. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 */

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
        $query = "INSERT INTO " . $table . " (name) VALUES ";
        foreach (range(1, $quantity) as $number) {
            $query .= "('" . self::generateFormatedValue($format) . "'),";
        }
        $query = substr($query, 0, -1);
        $DB->query($query);
    }

    /**
     * generate the formatted value
     * 
     * @param string $format
     * @return string
     */
    private function generateFormatedValue(string $format): string
    {
        $faker = Faker\Factory::create();
        $random_value = $faker->randomNumber(6);
        if (count(explode("%%", $format)) == 1) {
            return $format . $random_value;
        } else {
            return str_replace("%%", $random_value, $format);
        }
    }

    static function getTables(): array
    {
        global $DB;
        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='" . $DB->dbdefault . "'";
        $result = $DB->query($query);
        $ret = [];
        while ($row = $result->fetch_assoc()) {
            $ret[$row['TABLE_NAME']] = $row['TABLE_NAME'];
        }
        return $ret;
    }
}
