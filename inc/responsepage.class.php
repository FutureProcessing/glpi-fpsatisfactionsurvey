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

class PluginFpsatisfactionsurveyResponsePage extends CommonDBTM
{
   public function displayPage(): string
   {
      $ticket_id = PluginFpsatisfactionsurveySurveyLink::getTicketIdBySatisfactionSurveyHash(
         $_GET['satisfaction']
      );
      if (!$this->satisfactionSurveyValidation() || empty($ticket_id)) {
         return '<div>' . __(
               'Sorry, something went wrong, please contact with page administrator.'
            ) . '</div>';
      }

      if ($this->setSatisfactionSurveyAnswer($ticket_id, $_GET['satisfactionLevel'])) {
         return '<div>' . __(
               'Your answer has been saved. Thanks for completing the satisfaction survey'
            ) . '</div>';
      }

      return '<div>' . __(
            'Sorry, we cannot save your response, please contact with page administrator.'
         ) . '</div>';
   }

   private function setSatisfactionSurveyAnswer($ticket_id, int $answer): bool
   {
      global $DB;

      return $DB->update(
         'glpi_ticketsatisfactions',
         ['satisfaction' => $answer, 'date_answered' => date('Y-m-d H:i:s')],
         ['tickets_id' => $ticket_id]);
   }

   private function satisfactionSurveyValidation(): bool
   {
      if (!isset($_GET['satisfaction']) || !isset($_GET['satisfactionLevel'])) {

         return false;
      }

      if ($_GET['satisfactionLevel'] > 5 || $_GET['satisfactionLevel'] < 1)
      {
         return false;
      }

      return true;
   }
}
