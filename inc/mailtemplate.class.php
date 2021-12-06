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

class PluginFpsatisfactionsurveyMailTemplate
{
   public static function fpsatisfactionsurvey_mail_template_alter(CommonDBTM $item)
   {
      if ($item->raiseevent === 'satisfaction') {

         $ticket_id = $item->obj->fields['id'];
         $user_id = null;

         if (isset($item->target) && !empty($item->target) && count($item->target) === 1) {
            foreach ($item->target as $target_info) {
               $user_id = $target_info['users_id'];
               break;
            }
         }

         if (!empty($user_id)) {
            $satisfaction_survey_direct_vote_link = new PluginFpsatisfactionsurveySurveyLink(
               $user_id, $ticket_id
            );
            $item->data['##ticket.satisfactionSurvey##'] = self::getSatisfactionSurveySkeleton(
               $satisfaction_survey_direct_vote_link
            );
         }
      }

      return $item;
   }

   /**
    * Returns satisfaction survey HTML skeleton for mail.
    *
    * @param $satisfaction_survey_direct_vote_link
    *
    * @return string
    */
   private static function getSatisfactionSurveySkeleton(
      PluginFpsatisfactionsurveySurveyLink $satisfaction_survey_direct_vote_link
   ): string
   {
      try {
         $skeleton = '<div class="satisfaction-survey" style="text-align: center;">';
         for ($number = 1; $number <= 5; $number++) {
            $file_name = 'SmileyFace' . $number . '.png';
            $alternative_text = $number . '/5';
            $skeleton .= '<a href="' .
                         $satisfaction_survey_direct_vote_link->getSatisfactionSurveyLinkForMailTemplate(
                            $number
                         ) .
                         '"><img src="' . self::encodeImg($file_name)
                         . '" style="width: 100px; margin-right: 10px;" alt="' .
                         $alternative_text . '"></a>';
         }

         $skeleton .= '</div>';

         return $skeleton;
      } catch (Throwable $exception) {
         Toolbox::logError($exception->getMessage());
      }

      return '';
   }

   /**
    * Encodes img for satisfaction survey mail.
    *
    * @param string $file_name
    *
    * @return string
    */
   private static function encodeImg(string $file_name): string
   {
      global $CFG_GLPI;

      $path = $CFG_GLPI['url_base'] . '/plugins/fpsatisfactionsurvey/' . $file_name;
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);

      return 'data:image/' . $type . ';base64,' . base64_encode($data);
   }
}
