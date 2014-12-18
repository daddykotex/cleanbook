<?php
/*
Plugin Name: Cleanbook
Plugin URI: https://wordpress.org/plugins/cleanbook/
Description: Cleanbook shows a beautiful calendar and a form right next to it. The form is used to register appointments that have to be activated by an administrator from the control panel.
Text Domain: cleanbook
Domain Path: /languages
Version: 1.3.1
Author: David Francoeur
Author URI: http://davidfrancoeur.ca
License: GPLv2 or later 
*/

define('SITE_URL', get_option('siteurl'));
define('CLEANBOOK_FILE_PATH', dirname(__FILE__));
define('CLEANBOOK_ADMIN_FILE_PATH', CLEANBOOK_FILE_PATH . '/admin');
define('CLEANBOOK_FOLDER', dirname( plugin_basename(__FILE__) ));
define('CLEANBOOK_DIR_NAME', basename(CLEANBOOK_FILE_PATH));
define('CLEANBOOK_URL', plugin_dir_url( __FILE__ ));
define('CLEANBOOK_TABLE_APPOINTMENTS', 'cb_appointments');


function cleanbook_bootstrap(){

    $options = get_option('cleanbook_options');
    if($options['auto_register_bootstrap']){
        //this handle can be changed to whatever our theme use to register / enqueue the Bootstrap's CSS file
        $cssHandle = 'bootstrap-css';
        //this handle can be changed to whatever our theme use to register / enqueue the Bootstrap's JS file
        $jsHandle = 'bootstrap-js';

         if (!wp_script_is( 'bootstrap-js')) { 
            wp_register_script( $jsHandle, CLEANBOOK_URL . 'js/bootstrap.min.js', array('jquery'), '3.2.0', true );
            wp_enqueue_script( $jsHandle );
         }
         if(!wp_style_is ( $cssHandle)){
            wp_register_style( $cssHandle, CLEANBOOK_URL . 'css/bootstrap.min.css', array());
            wp_enqueue_style( $cssHandle);
         }
     }
}

add_action( 'wp_enqueue_scripts', 'cleanbook_bootstrap' );

function cleanbook_scripts() {
    //css
    wp_enqueue_style('calendar-style', CLEANBOOK_URL . 'css/calendar.min.css',array());
    wp_enqueue_style('jquery-datetimepicker', CLEANBOOK_URL . 'css/jquery.datetimepicker.css', array());
    wp_enqueue_style('cleanbook-style', CLEANBOOK_URL . 'css/style.css',array());  

    //js
    wp_enqueue_script('jquery-datetimepicker-js', CLEANBOOK_URL . 'js/jquery.datetimepicker.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-inputmask-js', CLEANBOOK_URL . 'js/jquery.inputmask.bundle.min.js', array('jquery'), '', true);
    
    $language = get_bloginfo('language');
    $exploded_language = explode("-", $language);

    if($language != "en-US"){
        wp_enqueue_script('calendar-i18n', CLEANBOOK_URL . 'js/language/' . $language . '.js', array('jquery', 'underscore'),'', true);
    }
    
    wp_enqueue_script('calendar-js', CLEANBOOK_URL . 'js/calendar.js', array('jquery', 'underscore'), '', true);

    wp_enqueue_script('cleanbook', CLEANBOOK_URL . 'js/cleanbook.js', array('calendar-js'),'', true);
    
    $options = get_option('cleanbook_options');

    $events = false;
    if($options['load_events_once'] == 1){
        $events = cleanbook_fetch_appointments(!current_user_can('activate_plugins'));
    }

    $cleanbook_ajax = array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'action_booking' => 'cleanbook_booking',
        'action_listing' => 'cleanbook_listing',
        'language_country'  =>  $language,
        'language'  =>  $exploded_language[0],
        'country'  =>  $exploded_language[1],
        'events_list' => $events,
        'tmpl_path' =>  CLEANBOOK_URL . 'js/tmpls/',
        'error_message' => __("An error has occured. Please contact the administrator.", "cleanbook")
        );
    wp_localize_script( 'cleanbook', 'cleanbook_ajax', $cleanbook_ajax, '', true );    
}
add_action( 'wp_enqueue_scripts', 'cleanbook_scripts' );
/*
    Load translations
*/
function cleanbook_load_plugin_textdomain() {
    load_plugin_textdomain( 'cleanbook', FALSE, CLEANBOOK_DIR_NAME . '/languages/' );
}
add_action( 'plugins_loaded', 'cleanbook_load_plugin_textdomain' );

/*
    Install hook
*/
function cleanbook_install(){  
   include_once(CLEANBOOK_ADMIN_FILE_PATH . '/install.php');
}
register_activation_hook( __FILE__, 'cleanbook_install' );

/*
Uninstall plugin, removes all data
To be reconsidered
*/
function cleanbook_uninstall() {
    
   include_once(CLEANBOOK_ADMIN_FILE_PATH . '/uninstall.php');

}
register_deactivation_hook( __FILE__, 'cleanbook_uninstall' );

/*
    include files
*/
//Add required functions
include_once(CLEANBOOK_FILE_PATH . '/functions.php');
//Add admin page
include_once(CLEANBOOK_ADMIN_FILE_PATH . '/settings.php');

/*
    The reason for this array to exist is that the tools used to 
    generate de pot (makepot.php) only looks in one file for strinag to be i18ned.

    An improvement would allow me to remove this non-sense.
*/
function appointments(){   
    include_once(CLEANBOOK_ADMIN_FILE_PATH . '/listdata.php');
}

/*
Hook that is called on "[cleanbook]" shortcode
*/
function appointment(){
    ob_start();
    include_once(CLEANBOOK_FILE_PATH . '/view.php');
    return ob_get_clean();
}
add_shortcode( 'cleanbook', 'appointment' );

/*
Insert appointment function
*/
function cleanbook_booking() {
    global $wpdb;
    $appointment_table_name = $wpdb->prefix . CLEANBOOK_TABLE_APPOINTMENTS;  

    $appointment = appointment_from_post();
    $appointment = KSES_data($appointment);

    $errors = validate($appointment) ;
    if(empty($errors)){
        $success = $wpdb->insert(  
            $appointment_table_name,  
            array(  
               'name'       => $appointment['name'],  
               'email'     => $appointment['email'],
               'phone'     => $appointment['phone'],
               'datetime'  => $appointment['datetime'],
               'comment'   => $appointment['comment'],
               'type'      => 'RENDEZ-VOUS',
               ),  
            array(  
                '%s',  
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                ));
        
        $message = $success ? __("The booking has been added. It will be reviewed and you'll be contacted for confirmation.", "cleanbook"):
        __("An error has occured. Please contact the administrator.", "cleanbook");
        if($success){
            send_notification_email($appointment);
        }
        echo json_encode(
            array(  'success'=> $success, 
                'messages' => array(array('message' => $message))
                ));
    } else {
        echo json_encode(
            array(  'success'=> false, 
                'messages' => $errors
                ));
    }

    die;
}

add_action( 'wp_ajax_cleanbook_booking', 'cleanbook_booking' ); 
add_action( 'wp_ajax_nopriv_cleanbook_booking', 'cleanbook_booking' ); 

function cleanbook_fetch_active_appointments(){
    cleanbook_fetch_appointments_ajax(true);    
}

function cleanbook_fetch_all_appointments(){
    cleanbook_fetch_appointments_ajax(false);
}

function cleanbook_fetch_appointments($active_only) {
    
    if($_GET['from'] && $_GET['to']){
        $start = date('Y-m-d', trim($_GET['from']) / 1000);
        $end   = date('Y-m-d', trim($_GET['to']) / 1000);
    } else {
        $one_year_in_seconds = 31536000;

        $start = date('Y-m-d', time() - $one_year_in_seconds);
        $end = date('Y-m-d', time() + $one_year_in_seconds);
    }

    global $wpdb;

    $appointments = $wpdb->prefix . CLEANBOOK_TABLE_APPOINTMENTS;
    if($active_only){
        $appointments_query = $wpdb->prepare(
            "SELECT * FROM $appointments WHERE `datetime` BETWEEN %s and %s and ACTIVE = %s",
            $start, 
            $end,
            $active_only
            );
    } else {
        $appointments_query = $wpdb->prepare(
            "SELECT * FROM $appointments WHERE `datetime` BETWEEN %s and %s",
            $start, 
            $end
            );
    }
    $results = $wpdb->get_results($appointments_query , ARRAY_A); 

    $out = array();
    foreach($results AS $appointment){ 
        $out[] = array(
            'id' => $appointment['id'],
            'title' => $appointment['type'],
            'start' => strtotime($appointment['datetime']) . '000',
            'end' => strtotime($appointment['datetime']) + 3600 . '000'
            );
    }

    return array('success' => 1, 'result' => $out);

}

function cleanbook_fetch_appointments_ajax($active_only) {
    $events = cleanbook_fetch_appointments($active_only);

    if($events['success'] == 1){
        echo json_encode($events);
    } else {
        echo json_encode(array('success' => 0));
    }
    die;
}

add_action( 'wp_ajax_nopriv_cleanbook_listing', 'cleanbook_fetch_active_appointments' ); 
add_action( 'wp_ajax_cleanbook_listing', 'cleanbook_fetch_all_appointments' ); 
?>
