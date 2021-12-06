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

class PluginFpsatisfactionsurveyInstaller
{
   public function isInstalled(): bool
   {
      global $DB;

      return $DB->tableExists('glpi_plugin_fpsatisfactionsurvey_hashes');
   }

   public function initSchema(): void
   {
      global $DB;

      if (!$DB->runFile(PLUGIN_FPSATISFACTIONSURVEY_DIRECTORY . '/install/mysql/1.0.0-install.sql')) {
         throw new RuntimeException(
            'Error occurred during FP Satisfaction Survey setup - unable to set up database'
         );
      }
   }

   public function purgeSchema(): void
   {
      global $DB;

      if (!$DB->runFile(PLUGIN_FPSATISFACTIONSURVEY_DIRECTORY . '/install/mysql/1.0.0-uninstall.sql')) {
         throw new RuntimeException(
            'Error occurred while removing Satisfaction Survey - unable to purge database'
         );
      }
   }
}
