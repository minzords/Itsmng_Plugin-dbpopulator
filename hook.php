<?php

use atoum\atoum\asserters\boolean;

/**
 * ---------------------------------------------------------------------
 * ITSM-NG
 * Copyright (C) 2023 ITSM-NG and contributors.
 *
 * https://www.itsm-ng.org
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
 **/
 
function plugin_dbpopulator_install(): bool {

    populate_database(200);

    return true ;
}

/**
 * Uninstall plugin
 *
 * @return boolean
 */
function plugin_dbpopulator_uninstall(): bool {
    return true;
}

/**
 * Populate database with random data
 *
 * @param integer $number
 * @return boolean
 */
function populate_database(int $number): bool{
    global $DB;
    require_once 'vendor/autoload.php';

    $migration = new Migration(101);
    $faker = Faker\Factory::create();

    foreach (range(1, $number) as $i) {
        $query = "INSERT INTO `glpi_computers` (`name`) VALUES ('%s');";
        $query = sprintf($query, $faker->word());
        $DB->query($query) or die($DB->error());
    }

    return true;
}