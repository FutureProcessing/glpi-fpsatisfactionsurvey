<?php

/*
   ------------------------------------------------------------------------
   FPSatisfactionSurvey
   Copyright (C) 2021 by Future Processing
   ------------------------------------------------------------------------

   LICENSE

   This file is part of FPFutures project.

   FPSatisfactionSurvey Plugin is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   FPSatisfactionSurvey is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with FPSatisfactionSurvey. If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------

   @package   FPFutures
   @author    Future Processing
   @co-author
   @copyright Copyright (c) 2021 by Future Processing
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @since     2021

   ------------------------------------------------------------------------
*/

include("../../../inc/includes.php");

$plugin = new Plugin();
if (!$plugin->isInstalled('fpsatisfactionsurvey') || !$plugin->isActivated('fpsatisfactionsurvey')) {
   Html::displayNotFoundError();
}

Html::header("FP Satisfaction survey response page");
echo Html::css('plugins/fpsatisfactionsurvey/css/responsepage.css');
$object = new PluginFpsatisfactionsurveyResponsePage();
echo $object->displayPage();
