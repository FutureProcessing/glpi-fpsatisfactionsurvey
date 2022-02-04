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

class PluginFpsatisfactionsurveySurveyLink
{
   const FP_SATISFACTION_SURVEY_HASHES_TABLE = 'glpi_plugin_fpsatisfactionsurvey_hashes';

   public $satisfaction_survey_link;
   private $ticket_id;
   private $user_id;
   private $satisfaction_hash;

   function __construct($user_id, $ticket_id)
   {
      $this->user_id = $user_id;
      $this->ticket_id = $ticket_id;

      $this->prepareSatisfactionSurveyLink();
      $this->saveSatisfactionSurveyHash();
   }

   private function prepareSatisfactionSurveyLink(): void
   {
      global $CFG_GLPI;

      $salt = bin2hex(random_bytes(5));
      $this->satisfaction_hash = crypt(
         sprintf('?user=%s&ticket=%d', $this->user_id, $this->ticket_id),
         $salt
      );

      $this->satisfaction_survey_link = sprintf(
         "%s/plugins/fpsatisfactionsurvey/front/responsepage.form.php?satisfaction=%s",
         $CFG_GLPI["url_base"],
         $this->satisfaction_hash
      );
   }

   private function saveSatisfactionSurveyHash(): void
   {
      global $DB;

      $DB->insert(
         PluginFpsatisfactionsurveySurveyLink::FP_SATISFACTION_SURVEY_HASHES_TABLE,
         [
            'ticket_id' => $this->ticket_id,
            'satisfaction_survey_hash' => $this->satisfaction_hash
         ]
      );
   }

   /**
    * Returns direct satisfaction survey link with value of satisfaction level.
    *
    * @param int $satisfaction_level
    *   Access only value from 1 to 5.
    *
    * @return string
    * @throws Exception
    */
   public function getSatisfactionSurveyLinkForMailTemplate(int $satisfaction_level): string
   {
      if ($satisfaction_level > 5 || $satisfaction_level < 1) {
         throw new Exception("Invalid value of satisfaction level. The value of satisfaction level can't be less than 1 and bigger than 5.");
      }

      return $this->satisfaction_survey_link . sprintf('&satisfactionLevel=%d', $satisfaction_level);
   }

   public static function getTicketIdBySatisfactionSurveyHash(
      string $satisfaction_survey_hash
   ): string
   {
      global $DB;

      $db_query = $DB->request(
         [
            'SELECT' => 'ticket_id',
            'FROM' => PluginFpsatisfactionsurveySurveyLink::FP_SATISFACTION_SURVEY_HASHES_TABLE,
            'WHERE' => ['satisfaction_survey_hash' => $satisfaction_survey_hash]
         ]
      );

      $ticket_id = '';
      foreach ($db_query as $data => $ticket) {
         $ticket_id = $ticket['ticket_id'];
      }

      return $ticket_id;
   }
}
