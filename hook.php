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

function plugin_fpsatisfactionsurvey_install(): bool
{
   $fpsatisfactionsurvey = new PluginFpsatisfactionsurveyInstaller();

   if (!$fpsatisfactionsurvey->isInstalled()) {
      try {
         $fpsatisfactionsurvey->initSchema();
      } catch (Throwable $e) {
         log_fpsatisfactionsurvey_error($e->getMessage());
         exit(1);
      }
   }

   return true;
}

/**
 * Because we've created a table, do not forget to destroy if the plugin is uninstalled.
 *
 * @return boolean Needs to return true if success
 */
function plugin_fpsatisfactionsurvey_uninstall(): bool
{
   $fpsatisfactionsurvey = new PluginFpsatisfactionsurveyInstaller();

   if ($fpsatisfactionsurvey->isInstalled()) {
      try {
         $fpsatisfactionsurvey->purgeSchema();
      } catch (Throwable $e) {
         log_fpsatisfactionsurvey_error($e->getMessage());
         exit(1);
      }
   }

   return true;
}

function log_fpsatisfactionsurvey_error(string $message): void
{
   $migration = new Migration(PLUGIN_FPSATISFACTIONSURVEY_VERSION);
   $migration->displayMessage($message);
}
