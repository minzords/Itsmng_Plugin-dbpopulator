<?php

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
    global $DB;
    if (!$DB->tableExists("glpi_plugin_dbpopulator_profiles")) {
        $query = "CREATE TABLE `glpi_plugin_dbpopulator_profiles` (
            `id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
            `right` char(1) collate utf8_unicode_ci default NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $DB->queryOrDie($query, $DB->error());

        include_once(GLPI_ROOT."/plugins/dbpopulator/inc/profile.class.php");
        PluginDbpopulatorProfile::createAdminAccess($_SESSION['glpiactiveprofile']['id']);

        foreach (PluginDbpopulatorProfile::getRightsGeneral() as $right) {
            PluginDbpopulatorProfile::addDefaultProfileInfos($_SESSION['glpiactiveprofile']['id'],[$right['field'] => $right['default']]);
        }
    }

    return true ;
}

/**
 * Uninstall plugin
 *
 * @return boolean
 */
function plugin_dbpopulator_uninstall(): bool {
    global $DB;

    if($DB->tableExists('glpi_plugin_dbpopulator_profiles')) {
        $DB->queryOrDie("DROP TABLE `glpi_plugin_dbpopulator_profiles`",$DB->error());
    }

    // Clear profiles
    foreach (PluginDbpopulatorProfile::getRightsGeneral() as $right) {
        $query = "DELETE FROM `glpi_profilerights` WHERE `name` = '".$right['field']."'";
        $DB->query($query);

        if (isset($_SESSION['glpiactiveprofile'][$right['field']])) {
           unset($_SESSION['glpiactiveprofile'][$right['field']]);
        }
   }

    return true;
}