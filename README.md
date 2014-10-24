
# Cleanbook WordPress plugin

## What is it?

This plugin is very simple as of now. It shows a calendar of all the active appointments using [Bootstrap Calendar] and a form is available right next to it to allow registration of new events. The calendar only show active appointments.

The administrator can activate/deactive event via a list in the admin section of your Wordpress installation.

## Installation
You can find the plugin using your current WordPress installation by looking for it using the "cleanbook" keyword.

You can also manually install the plugin by uploading the content of the latest tagged version to your wp-content/plugins/ folder. Here are the minimum steps:

  - Download the archive
  - Extract it
  - Upload the cleanbook folder to your wp-content/plugins folder on your WordPress installation. Make sure your install looks like this wp-content/plugins/cleanbook/cleanbook.php
  - Activate it from the plugins page in our WordPress installation


## Usage
In order to use the plugin, you have to add the following shortcode in the page:
```
[cleanbook]
```

Note that this plugin heavily depends on Bootsrap 3.2 so make sure a container is around the plugin. If not then you can add one directly aroung the plugin:

```
<div class="container">
    [cleanbook]
</div>
```

## Bootstrap 3.2
This plugin uses Bootstrap to render properly. If the plugin can't find the Bootstrap CSS and JS files, it will add them automatically. If your theme already import those files, you can't prevent reimportation by changing the handle used by the plugin to look for the files by the one our theme is using.

For example, your theme register the CSS and the JS using the following handles respectively: "mytheme-bootstrap-css" and "mytheme-bootstrap-js". You can change the following lines (cleanbook.php):
```
    $cssHandle = 'bootstrap-css';
    $jsHandle = 'bootstrap-js';
```
By :
```
    $cssHandle = 'mytheme-bootstrap-css';
    $jsHandle = 'mytheme-bootstrap-js';
```
This way the plugin won't reimport the files. It is possible that your theme import the CSS using the `@Import` instruction of your style.css, I'm working on a setting option that would be used to deactivate this auto-import behavior of the plugin.

## I18n
This plugin supports mutiple languages. Currently the following language are provided:
 - French
 - English (default)

It is easy to add support for another language. Pick a PO Editor program, load the cleanbook.pot file that is available in the languages folder, translate all the fields and save your .po and .mo files with the proper names.

## Behind the scenes
When you activate the plugin, it create the structure it needs in the database. All informations related to your CleanBook plugin are stored in table that use a name like this : wpprefix_cb_tablename where "wpprefix" is the prefix of all your WordPress tables and "cb" is the prefix used by the plugin.

Be careful, as of now, when you deactivate the plugin, it drops all of the table related to the plugin. That means that all the data regarding appointments taken via the plugin will be lost. 

## Support

If you have W3TC, and have an UNEXPECTED TOKEN ILLEGAL ERROR. The minifying process of W3TC had problem with underscore.min.js at the time I wrote this. Adding this file to the excluded list of minified js in your W3TC configuration should fix it.

The name I used is : wp-includes/js/underscore.min.js

## Todo
Add settings to deactivate auto-import

Add settings for a notification email 

A lot of CSS fixes to prevent crashes from coming from the theme.

[bootstrap calendar]:http://bootstrap-calendar.azurewebsites.net/
