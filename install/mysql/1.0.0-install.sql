CREATE TABLE `glpi_plugin_fpsatisfactionsurvey_hashes`
(
    `id`                       INT(11)      NOT NULL AUTO_INCREMENT,
    `ticket_id`                INT(11)      NOT NULL,
    `satisfaction_survey_hash` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
