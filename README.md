# glpi-fpsatisfactionsurvey

## General Information

This plugin creates a new satisfaction survey shortcut that we can use in an email template.

### Requirements

GLPI 9.5.5 or above

### Installation instructions

Installation is similar to those of other plugins: copy to `plugins/` directory, ensure that name of the folder that
contains the plugin files is `fpsatisfactionsurvey`, and then install and enable from Administration/Plugins section. This will
create the database table.

### Uninstallation instructions

Use Uninstall option in Administration/Plugins section.

**Please keep in mind that this will remove the database table related to this plugin**.

## Basic use

1. Install and enable on the plugin list
2. Visit top menu > Setup > Notifications > Notifications template.
3. Find **Ticket Satisfaction**, next click on **'Template translations'** from the left side.
4. Next click on **'Default translation'**.
5. On Template translation page you can put new shortcut -> **##ticket.satisfactionSurvey##** into **Email HTML body section**.

## Database details

* `glpi_plugin_fpsatisfactionsurvey_hashes` - hashes related to satisfaction survey

## Detailed behavior
1. User can see satisfaction survey into email related to the **Ticket Satisfaction template** (if we used **##ticket.satisfactionSurvey##** into template).
2. The template consists of 5 images (smileys), each image has a link attached to it (direct url to vote on satisfaction survey)
3. If the user clicks on the image, a new page will open and the value of satisfaction level will be saved (or not if there is an error). 
