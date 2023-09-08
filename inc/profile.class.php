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

class PluginDbpopulatorProfile extends CommonDBTM {
    static function canCreate(): bool {
        if (isset($_SESSION['profile'])) {
            return $_SESSION['profile']['dbpopulator'] == 'w';
        } else {
            return false;
        }
    }

    static function canView() {
        if (isset($_SESSION['profile'])) {
            return $_SESSION['profile']['dbpopulator'] == 'r' || $_SESSION['profile']['dbpopulator'] == 'w';
        } else {
            return false;
        }
    }

    static function createAdminAccess($ID) {
        $profile = new self();
        if (!$profile->getFromDB($ID)) {
            $profile->add(array('id' => $ID, 'right' => 'w'));
        }
    }

    static function addDefaultProfileInfos($profiles_id, $rights) {
        $profileRight = new ProfileRight();
        foreach ($rights as $right => $value) {
           if (!countElementsInTable('glpi_profilerights',
                                     ['profiles_id' => $profiles_id, 'name' => $right])) {
              $myright['profiles_id'] = $profiles_id;
              $myright['name']        = $right;
              $myright['rights']      = $value;
              $profileRight->add($myright);
              //Add right to the current session
              $_SESSION['glpiactiveprofile'][$right] = $value;
           }
        }
     }
  
    static function getRightsGeneral() {
        $rights = [
            ['itemtype'  => 'PluginDbpopulatorProfile',
                  'label'     => __('Use dbpopulator', 'dbpopulator'),
                  'field'     => 'plugin_dbpopulator_dbpopulator',
                  'rights'    =>  [UPDATE    => __('Allow editing', 'dbpopulator')],
                  'default'   => 23]];
        return $rights;
    }
}
