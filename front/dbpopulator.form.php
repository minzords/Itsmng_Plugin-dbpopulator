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
?>
<div class="center">
    <form method="post" action="dbpopulator.form.php">
        <div>
            <label for="computers">Amount of computers to create</label><br>
            <input type="number" name="computers" value="1">
        </div>
        <br>
        <div>
            <label for="users">Amount of users to create</label><br>
            <input type="number" name="users" value="1">
        </div>
        <br>
        <div>
            <label for="prefix">Prefix</label><br>
            <input type="text" name="prefix" value="">
        </div>
        <button type="submit">Populate</button>
        <?php
        Html::footer();
        Html::closeForm();
        echo "</div>"
        ?>