=== Plugin Name ===
Contributors: francoeurdavid
Tags: booking, appointment, form, bootstrap, cleanbook
Requires at least: 3.8.1
Tested up to: 4.0
Stable tag: 1.0
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UJ5KDKRGHQZES
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows a calendar of all the active appointments and a form to submit an appointment.

== Description ==

This plugin is very simple as of now. It shows a calendar of all the active appointments using [Bootstrap Calendar] and a form is available right next to it to allow registration of new events. The calendar only show active appointments.

The administrator can activate/deactivate appointment via a list in the admin section of your Wordpress installation.

The plugin is based upon another similar plugin called [Fastbook]. While not much was kept, I used it to learn and to build upon. Thanks a lot to the Fastbook team.

== Installation ==
You can find the plugin using your current WordPress installation by looking for it using the "cleanbook" keyword.

You can also manually install the plugin by uploading the content of the latest tagged version to your wp-content/plugins/ folder. Here are the minimum steps:

  - Download the archive
  - Extract it
  - Upload the cleanbook folder to your wp-content/plugins folder on your WordPress installation. Make sure your install looks like this wp-content/plugins/cleanbook/cleanbook.php
  - Activate it from the plugins page in our WordPress installation

=== Usage ===
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

== Bootstrap 3.2 ==
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

== Frequently Asked Questions ==

Q: I have W3TC and our plugin doesn't work well with it, what can I do?

A: If you have W3TC, and have an UNEXPECTED TOKEN ILLEGAL ERROR. The minifying process of W3TC had problem with underscore.min.js at the time I wrote this. Adding this file to the excluded list of minified js in your W3TC configuration should fix it.

The name I used is : wp-includes/js/underscore.min.js

== Screenshots ==
1. screenshot.png 
<<<<<<< HEAD
2. screenshot_french.png
=======
1. screenshot_french.png
>>>>>>> master

== Translators ==

* French (fr) - David Francoeur

[bootstrap calendar]:http://bootstrap-calendar.azurewebsites.net/
[fastbook]:https://wordpress.org/plugins/fastbook-responsive-appointment-booking-and-scheduling-system/
