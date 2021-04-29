# README

This README documents whatever steps are necessary to get this plugin up and running.

## How do I get set up

-   Unzip and/or move all files to the /wp-content/plugins/persberichten directory
-   Log into WordPress admin and activate the ‘Yard | Persberichten’ plugin through the ‘Plugins’ menu.
-   Go to the 'Persberichten instellingen' in the left-hand menu to enter some of the required settings.
    If the 'Yard | OpenPub Base' plugin is activated the 'Persberichten instellingen' are placed, as submenu item, beneath the 'OpenPub instellingen' page.
    The setting 'Portal URL' will also be removed from the 'Persberichten instellingen'. You'll find this setting on the 'OpenPub instellingen' page.

## How does the plugin work

-   First of all a new press release should be connected to the taxonomy 'Verzendlijsten'.
    Each term must contain a Laposta mailinglist ID as meta value.
-   Create a press release and make sure to connect it with a term of the taxonomy 'Verzendlijsten'.
-   When a press release is saved for the first time this plug-in will create a new campaign and send the content of the press release to the connected Laposta campaign.
    Finally the campaign will be send to all the subscribers right away!
