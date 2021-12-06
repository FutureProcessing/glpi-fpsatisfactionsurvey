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

const PLUGIN_FPSATISFACTIONSURVEY_VERSION = '1.0.0';
const PLUGIN_FPSATISFACTIONSURVEY_DIRECTORY = __DIR__;

/**
 * Get the name and the version of the plugin
 * REQUIRED
 *
 * @return array
 */
function plugin_version_fpsatisfactionsurvey()
{
   return [
      'name' => 'FP Satisfaction Survey',
      'version' => PLUGIN_FPSATISFACTIONSURVEY_VERSION,
      'author' => '<a href="http://www.future-processing.com">Future Processing</a>',
      'license' => '',
      'homepage' => '',
      'requirements' => [
         'glpi' => [
            'min' => '9.5',
         ]
      ]
   ];
}

/**
 * Init hooks of the plugin.
 * REQUIRED
 *
 * @return void
 */
function plugin_init_fpsatisfactionsurvey()
{
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['fpsatisfactionsurvey'] = true;
   $PLUGIN_HOOKS['item_get_datas']['fpsatisfactionsurvey'] = [
      'NotificationTargetTicket' => [
         'PluginFpsatisfactionsurveyMailTemplate',
         'fpsatisfactionsurvey_mail_template_alter'
      ]
   ];
}
