<?php
/*
Plugin Name: Cleanbook - Responsive plugin based on Bootstrap
Plugin URI: 
Description: Cleanbook shows a form, i18n, so you can book a rendez-vous. This plugin is based on Fastbook.
Text Domain: cleanbook
Domain Path: /languages
Version: 1.0
Author: David Francoeur
Author URI: http://davidfrancoeur.ca
License: GPLv3 or later 
*/

$siteurl = get_option('siteurl');
define('CLEANBOOK_FILE_PATH', dirname(__FILE__));
define('CLEANBOOK_ADMIN_FILE_PATH', CLEANBOOK_FILE_PATH . '/admin');
define('CLEANBOOK_FOLDER', dirname( plugin_basename(__FILE__) ));
define('CLEANBOOK_DIR_NAME', basename(CLEANBOOK_FILE_PATH));
define('CLEANBOOK_URL', plugin_dir_url( __FILE__ ));
define('CLEANBOOK_TABLE_APPOINTMENTS', 'cb_appointments');


function cleanbook_bootstrap(){
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

add_action( 'wp_enqueue_scripts', 'cleanbook_bootstrap' );

function cleanbook_scripts() {
    //css
    wp_enqueue_style('calendar-style', CLEANBOOK_URL . 'css/calendar.min.css',array());
    wp_enqueue_style('jquery-datetimepicker', CLEANBOOK_URL . 'css/jquery.datetimepicker.css', array());
    wp_enqueue_style('cleanbook-style', CLEANBOOK_URL . 'css/style.css',array());  

    //js
    wp_enqueue_script('jquery-datetimepicker-js', CLEANBOOK_URL . 'js/jquery.datetimepicker.js', array('jquery'), '', true);
    $language = get_bloginfo('language');

    if($language != "en-US"){
        wp_enqueue_script('calendar-i18n', CLEANBOOK_URL . 'js/language/' . $language . '.js', array('jquery', 'underscore'),'', true);
    }
    
    wp_enqueue_script('calendar-js', CLEANBOOK_URL . 'js/calendar.js', array('jquery', 'underscore'), '', true);

    wp_enqueue_script('cleanbook', CLEANBOOK_URL . 'js/cleanbook.js', array('calendar-js'),'', true);
    
    $cleanbook_ajax = array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'action_booking' => 'cleanbook_booking',
        'action_listing' => 'cleanbook_listing',
        'language'  =>  $language,
        'tmpl_path' =>  CLEANBOOK_URL . 'js/tmpls/'
        );
    wp_localize_script( 'cleanbook', 'cleanbook_ajax', $cleanbook_ajax, '', true );    
}
add_action( 'wp_enqueue_scripts', 'cleanbook_scripts' );

function cleanbook_admin_scripts(){
    wp_enqueue_style('cleanbook-admin-style', CLEANBOOK_URL . 'admin/css/style.css',array());  
}
add_action( 'admin_enqueue_scripts', 'cleanbook_admin_scripts' );
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
Add admin page links
*/
add_action('admin_menu','cleanbook_admin_menu');

function cleanbook_admin_menu()
{  
    add_menu_page(__('Manage appointments', 'cleanbook'), __('Cleanbook Appointments', 'cleanbook'), 'activate_plugins', "cb-appointments", "appointments", "dashicons-admin-generic"); 
    add_submenu_page('cb-appointments', __('Cleanbook Settings', 'cleanbook'),__('Cleanbook Settings', 'cleanbook'), 'activate_plugins', "cb-settings", "settings_page"); 
        //call register settings function
    add_action( 'admin_init', 'register_settings' );
}

/*
    Register Cleanbook options
*/
function register_settings() {
    //register our settings
    register_setting( 'cb-settings-group', 'cleanbook_options');
    add_settings_section('cleanbook_general', __('General Settings', 'cleanbook'), 'general_settings', 'cleanbook_general_page');
    add_settings_field('auto_register_bootstrap', __('Auto-register Bootstrap', 'cleanbook'), 'auto_register_bootstrap_string', 'cleanbook_general_page', 'cleanbook_general');
}

function general_settings(){
    echo "<p>" . _e("This is where you will find all of the general settings 
                    that affects the behavior of your Cleanbook plugin.", 'cleanbook') . "</p>";
}

function auto_register_bootstrap_string() {
    $options = get_option('cleanbook_options');

    echo "<input id='auto_register_bootstrap' name='cleanbook_options[auto_register_bootstrap]' 
             type='checkbox' value='1'" . checked(1, $options['auto_register_bootstrap'], false ) . "' />";
}

function validate_options($input){
    $newinput['auto_register_bootstrap'] = trim($input['auto_register_bootstrap']);
    
    if($newinput['auto_register_bootstrap'] == 1 
        || $newinput['auto_register_bootstrap'] == 0) {
        $newinput['auto_register_bootstrap'] = 0;
    }
    
    return $newinput;
}


function settings_page(){
    $translated_labels = array(
        'settings-title'        =>  __('Cleanbook Settings', 'cleanbook'),
        'auto_register_bootstrap-label'       => __( 'Do you want Bootstrap to be automatically registered?', 'cleanbook' )
    );

   include_once(CLEANBOOK_ADMIN_FILE_PATH . '/settings.php');
}


/*
    The reason for this array to exist is that the tools used to 
    generate de pot (makepot.php) only looks in one file for strinag to be i18ned.

    An improvement would allow me to remove this non-sense.
*/
function appointments(){   
    $translated_labels = array(
    'id'        =>  __('ID', 'cleanbook'),
    'name'       => __( 'Fullname', 'cleanbook' ), 
    'phone'       => __( 'Phone', 'cleanbook' ), 
    'email'       => __( 'Email', 'cleanbook' ), 
    'datetime'       => __( 'Date and time', 'cleanbook' ), 
    'comment'       => __( 'Comment', 'cleanbook' ),
    'activate'       => __( 'Activate', 'cleanbook' ),
    'deactivate'       => __( 'Deactivate', 'cleanbook'),
    'listing-title'       => __('Manage appointments', 'cleanbook')
    );


    include_once(CLEANBOOK_ADMIN_FILE_PATH . '/listdata.php');
}

/*
Hook that is called on "[cleanbook]" shortcode
*/
function appointment(){
    ob_start();

    $translated_labels = array(
        'form-title'       => __( 'Schedule an appointment', 'cleanbook' ), 
        'name'       => __( 'Fullname', 'cleanbook' ), 
        'name-placeholder'       => __( 'First name Last name', 'cleanbook' ), 
        'phone'       => __( 'Phone', 'cleanbook' ), 
        'phone-placeholder'       => __( '(514) 555-5555', 'cleanbook' ), 
        'email'       => __( 'Email', 'cleanbook' ), 
        'email-placeholder'       => __( 'example@email.com', 'cleanbook' ), 
        'datetime'       => __( 'Date and time', 'cleanbook' ), 
        'comment'       => __( 'Comment', 'cleanbook' ),
        'comment-placeholder'       => __( 'Please add any note regarding the booking...', 'cleanbook' ),
        'previous'       => __( 'Previous', 'cleanbook' ),
        'next'       => __( 'Next', 'cleanbook' ),
        'today'       => __( 'Today', 'cleanbook' ),
        'year'       => __( 'Year', 'cleanbook' ),
        'month'       => __( 'Month', 'cleanbook' ),
        'week'       => __( 'Week', 'cleanbook' ),
        'day'       => __( 'Day', 'cleanbook' ),
        'submit'       => __( 'Submit', 'cleanbook' )
        );

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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $datetime = $_POST['datetime'];
    $comment = $_POST['comment'];

    $errors = validate($name, $email, $phone, $datetime) ;
    if(empty($errors)){
        $success = $wpdb->insert(  
            $appointment_table_name,  
            array(  
               'name'       => $name,  
               'email'     => $email,
               'phone'     => $phone,
               'datetime'  => $datetime,
               'comment'   => $comment,
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
        echo json_encode(
            array(  'success'=> $success, 
                'messages' => array(array('message' => $message))
                ));
    } else{
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
    cleanbook_fetch_appointments(true);    
}

function cleanbook_fetch_all_appointments(){
    cleanbook_fetch_appointments(false);
}

function cleanbook_fetch_appointments($active_only) {
    $start = date('Y-m-d', $_GET['from'] / 1000);
    $end   = date('Y-m-d', $_GET['to'] / 1000);

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

    echo json_encode(array('success' => 1, 'result' => $out));

    die;

}

add_action( 'wp_ajax_nopriv_cleanbook_listing', 'cleanbook_fetch_active_appointments' ); 
add_action( 'wp_ajax_cleanbook_listing', 'cleanbook_fetch_all_appointments' ); 


/*
Insert appointment function
*/
function cleanbook_toggle_active_status() {

    $id =  $_POST['id'];
    $active = $_POST['active'];

    if($active == "false"){
        $active = 0;
    } else if($active == "true"){
        $active = 1;
    }

    global $wpdb;
    $appointment_table_name = $wpdb->prefix . CLEANBOOK_TABLE_APPOINTMENTS;   

    $success = $wpdb->update( 
                    $appointment_table_name, 
                    array( 
                        'active' => $active, //column and values to set
                    ), 
                    array( 'id' => $id ), //where
                    array( 
                        '%b',   // value type
                    ), 
                    array( '%d' ) 
                );
    $active_label = $active ? "active" : "inactive";
    $message = $success ? sprintf(__("The booking was marked as %s.", "cleanbook"), $active_label) :
    __("An error has occured. Please contact the administrator.", "cleanbook");

    echo json_encode(
        array(  'success'=> $success, 
                'errors' => $message
        )
    );

    die;
}

add_action( 'wp_ajax_toggle_active_status', 'cleanbook_toggle_active_status' ); 


function validate($name, $email, $phone, $datetime){
    $errors = array();
    if(empty($name)){
        $errors[] = array('message' => __("Please provide a name.", "cleanbook"));
    }

    if(empty($email)){
        $errors[] = array('message' => __("Please provide an email.", "cleanbook"));
    } else if (!is_email($email)){
        $errors[] = array('message' => __("Please provide a valid email : valid@email.com.", "cleanbook"));
    }

    if(empty($phone)){
        $errors[] = array('message' => __("Please provide a phone.", "cleanbook"));
    } else if (!preg_match("/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/", $phone)){
        $errors[] = array('message' => __("Please provide a valid phone number : (514) 555-5555.", "cleanbook"));
    }

    if(empty($datetime)){
        $errors[] = array('message' => __("Please provide a date and time", "cleanbook"));
    } else if (!strtotime($datetime)){
        $errors[] = array('message' => __("Please provide a valid date and time : 2014-10-21 16:00:00.", "cleanbook"));
    }
    return $errors;
}
?>