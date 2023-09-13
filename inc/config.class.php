<?php

/**
 * ---------------------------------------------------------------------
 * ITSM-NG
 * Copyright (C) 2022 ITSM-NG and contributors.
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
 */

class PluginDbpopulatorConfig extends CommonDBTM
{

    static $rightname = 'config';

    /**
     * getTypeName
     *
     * @param  int $nb
     * @return string
     */
    static function getTypeName($nb = 0)
    {
        return __("Translation editor", 'edittraduction');
    }

    /**
     * get menu content
     *
     * @return array
     */
    static function getMenuContent()
    {
        $menu = array();

        $menu['title'] = "Popupate database";
        $menu['page'] = "/plugins/dbpopulator/front/dbpopulator.form.php";
        $menu['icon']  = "fas fa-database";
        return $menu;
    }
}
