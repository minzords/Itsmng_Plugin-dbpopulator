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

include_once('../../../inc/includes.php');

Html::header(__("Populate database", "dbpopulator"), $_SERVER['PHP_SELF'], 'tools', PluginDbpopulatorConfig::class);

ini_set('display_errors', 1);
require_once GLPI_ROOT . "/ng/twig.class.php";
$template_dir[] = GLPI_ROOT . "/templates";
$template_dir[] = Plugin::getPhpDir("dbpopulator") . "/templates";
$twig = Twig::load($template_dir, false);

// show page only to authorized users
$plugin = new Plugin();
if ($plugin->isActivated("dbpopulator")) {
    Session::checkRight("config", READ);
} else {
    Html::displayRightError();
}

// populate database if a post request is received
if (isset($_POST['table']) && $_POST['table'] != 0 && isset($_POST['amount'])) {
    Session::checkRight("config", UPDATE);
    $db = new PluginDbpopulatorDbpopulator();
    $db->populate($_POST['format'], $_POST['table'], $_POST['amount']);
    Session::addMessageAfterRedirect(__('Database populated', 'dbpopulator'));
    Html::back();
}
echo $twig->render('dbpopulator.form.twig', [
    'tables' => PluginDbpopulatorDbpopulator::getTables(),
    'crsf' => Session::getNewCSRFToken(),
]);
Html::footer();
?>