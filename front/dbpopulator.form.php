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

include_once('../../../inc/includes.php');

Html::header(__("Populate database", "dbpopulator"), $_SERVER['PHP_SELF'], 'tools', PluginDbpopulatorConfig::class);

$plugin = new Plugin();
if ($plugin->isActivated("dbpopulator")) {
    Session::checkRight("config", READ);
} else {
    Html::displayRightError();
}

if (isset($_POST['computers']) || isset($_POST['users'])) {
    Session::checkRight("config", UPDATE);
    $computers = $_POST['computers'];
    $users = $_POST['users'];
    $prefix = $_POST['prefix'];
    $db = new PluginDbpopulatorDbpopulator();
    $db->populate(['computers' => $computers, 'users' => $users, 'prefix' => $prefix]);
    echo '<div class="center">Database populated</div>';
}

$item=['computers','monitor','phone','printer','users']

?>
<div class="center">


    <form method="post" action="dbpopulator.form.php">
        <table class='tab_cadre' cellpadding='5'>
            <tr>
                <th colspan='2'>Configuration</th>
            </tr>
            
            <tr class='tab_bg_1'>
                <td class='center b' colspan='2'>
                    <br>

                    <?php
                        $elements = ['computers', 'users'];

                        foreach ($elements as $element) {
                            echo "<div>
                                    <label for='$element'>Amount of $element to create</label><br>
                                    <input type='number' name='$element' value='0'>
                                </div>
                                <br>";
                        }
                    ?>
                    <br>
                    <div>
                        <label for="prefix">Prefix</label><br>
                        <input type="text" name="prefix" value="">
                    </div>
                </td>
            </tr>
            <tr class='tab_bg_1'>
                <td class='center' colspan='2'>
                    <input type='submit' name='update' class='submit'>&nbsp;&nbsp;
                </td>
            </tr>
        </table>
  <?php Html::closeForm(); ?>