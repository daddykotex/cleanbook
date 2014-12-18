=== Plugin Name ===
Contributors: francoeurdavid
Tags: booking, appointment, form, bootstrap, cleanbook, calendar, multilingual
Requires at least: 3.8.1
Tested up to: 4.1
Stable tag: 1.3.1
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UJ5KDKRGHQZES
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows a calendar of all the active appointments and a form to submit an appointment.

== Description ==

This plugin is very simple as of now. It shows a calendar of all the active appointments using [Bootstrap Calendar](http://bootstrap-calendar.azurewebsites.net/) and a form is available right next to it to allow registration of new events. The calendar only show active appointments.

The administrator can activate/deactivate appointment via a list in the admin section of your Wordpress installation. The administrator can also manage all appointments data from there. It is also possible to receive en email upon the registration of a new event.

The plugin is based upon another similar plugin called [Fastbook](https://wordpress.org/plugins/fastbook-responsive-appointment-booking-and-scheduling-system/). While not much was kept, I used it to learn and to build upon. Thanks a lot to the Fastbook team.

== Usage ==
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
This plugin uses Bootstrap to render properly. If the plugin can't find the Bootstrap CSS and JS files, it will add them automatically. If your theme already import those files, you can either turn that option off from the admin panel or you can prevent it by changing the handle used by the plugin to look for the files by the one your theme is using.

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


== Translators ==

* French (fr) - David Francoeur

== Installation ==
You can find the plugin using your current WordPress installation by looking for it using the "cleanbook" keyword.

You can also manually install the plugin by uploading the content of the latest tagged version to your wp-content/plugins/ folder. Here are the minimum steps:

1. Download the archive
1. Extract it
1. Upload the cleanbook folder to your wp-content/plugins folder on your WordPress installation. Make sure your install looks like this wp-content/plugins/cleanbook/cleanbook.php
1. Activate it from the plugins page in our WordPress installation
1. Place a `[cleanbook]` shortcode where you want the plugin to appear.

== Screenshots ==
1. screenshot.png 
2. screenshot_fr.png

== Frequently Asked Questions ==

Q: I have W3TC and our plugin doesn't work well with it, what can I do?

A: If you have W3TC, and have an UNEXPECTED TOKEN ILLEGAL ERROR. The minifying process of W3TC had problem with underscore.min.js at the time I wrote this. Adding this file to the excluded list of minified js in your W3TC configuration should fix it.

The name I used is : wp-includes/js/underscore.min.js

== Changelog ==

= 1.3.1 =
Compatibility with Wordpress 4.1

= 1.3 =

* Added option to allow plugin to fetch calendar events at every event or that the data be given once on the page load. (good for slow hosts).

= 1.2 =

* Appointment editable via the list and a modal popup

= 1.1 =

* Fixed distribution issue with the readme.txt

= 1.0 =

* Initial release
