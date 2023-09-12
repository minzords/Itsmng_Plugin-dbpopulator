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

if (isset($_POST['table']) && $_POST['table'] != 0 && isset($_POST['amount'])) {
    Session::checkRight("config", UPDATE);
    $db = new PluginDbpopulatorDbpopulator();
    $db->populate($_POST['prefix'], $_POST['table'], $_POST['amount']);
    Session::addMessageAfterRedirect(__('Database populated', 'dbpopulator'));
    
    Html::back();
}

global $DB;
$query = "SELECT GROUP_CONCAT(DISTINCT TABLE_NAME SEPARATOR ',') 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE COLUMN_NAME IN ('name') AND TABLE_SCHEMA = '".$DB->dbdefault."';
";
$result = $DB->query($query);
$tables = explode(',', $result->fetch_row()[0]);
$values = [];
foreach ($tables as $table) {
    $values[$table] = $table;
}
?>

<div class="center">
    <form method="post" action="dbpopulator.form.php">
        <table class='tab_cadre' cellpadding='5'>
            <tr>
                <th colspan='2'>Configuration</th>
            </tr>

            <tr class='tab_bg_1'>
                <td class='center b' colspan='2'>
                    <?php Dropdown::showFromArray('table', $values, ['display_emptychoice' => true]) ?><br><br>
                    <label for='amount'>Amount : </label>
                    <input type='number' name='amount' value='0'><br><br>
                    <label for="prefix">Prefix : </label>
                    <input type="text" name="prefix" value="">
                </td>
            </tr>
            <tr class='tab_bg_1'>
                <td class='center' colspan='2'>
                    <input type='submit' name='update' class='submit'>&nbsp;&nbsp;
                </td>
            </tr>
        </table>
        <?php Html::closeForm(); ?>
</div>
<?php Html::footer() ?>