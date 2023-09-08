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

 define('DBPOPULATOR_VERSION', '1.0');
 define('DBPOPULATOR_AUTHOR', 'Minzord,AntoineLemarchand');
 define('DBPOPULATOR_HOMEPAGE', 'https://github.com/minzords/Itsmng_Plugin-dbpopulator');


/**
 * Define Name,Version,Author... of the plugin
 *
 * @return void
 */
function plugin_version_dbpopulator(): array {
    return array(
        'name'           => "dbpopulator",
        'version'        => DBPOPULATOR_VERSION,
        'author'         => DBPOPULATOR_AUTHOR,
        'license'        => 'GPLv3+',
        'homepage'       => DBPOPULATOR_HOMEPAGE,
        'requirements'   => [
            'glpi'   => [
               'min' => '9.5'
            ],
            'php'    => [
                'min' => '8.0'
            ]
         ]
    );
}

/**
 * Check prerequisites before install
 *
 * @return boolean
 */
function plugin_dbpopulator_check_prerequisites(): bool {
    if (version_compare(ITSM_VERSION, '1.0', 'lt')) {
        echo "This plugin requires ITSM >= 1.0";
        return false;
    }
    return true;
}

/**
 * Check configuration
 *
 * @return boolean
 */
function plugin_dbpopulator_check_config(): bool {
    return true;
}

/**
 * Function called at plugin activation
 * This function is used to register class
 * 
 * @global array $PLUGIN_HOOKS
 */
function plugin_init_dbpopulator(): void {
    global $PLUGIN_HOOKS;

    // Declaration des HOOKS
    $PLUGIN_HOOKS['csrf_compliant']['dbpopulator'] = true;
    $PLUGIN_HOOKS['menu_toadd']['dbpopulator'] = ['tools' => array(PluginDbPopulatorConfig::class)];
}