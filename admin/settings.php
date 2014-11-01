<?php



function cleanbook_admin_scripts() {
    //css
    wp_enqueue_style('jquery-datetimepicker', CLEANBOOK_URL . 'css/jquery.datetimepicker.css', array());
    
    wp_enqueue_style('cleanbook-admin-style', CLEANBOOK_URL . 'admin/css/style.css',array()); 

    //js
    wp_enqueue_script('jquery-datetimepicker-js', CLEANBOOK_URL . 'js/jquery.datetimepicker.js', array('jquery'), '', true);   
}

add_action( 'admin_enqueue_scripts', 'cleanbook_admin_scripts' );


function cleanbook_admin_menu()
{  
    add_menu_page(__('Manage appointments', 'cleanbook'), __('Cleanbook Appointments', 'cleanbook'), 'activate_plugins', "cb-appointments", "appointments", "dashicons-admin-generic"); 
    add_submenu_page('cb-appointments', __('Cleanbook Settings', 'cleanbook'),__('Cleanbook Settings', 'cleanbook'), 'activate_plugins', "cb-settings", "settings_page"); 
        //call register settings function
    add_action( 'admin_init', 'register_settings' );
}
add_action('admin_menu','cleanbook_admin_menu');

/*
    Register Cleanbook options
*/
function register_settings() {
    //register our settings
    register_setting( 'cb-settings-group', 'cleanbook_options', 'validate_options');

    //General settings
    add_settings_section('cleanbook_general', __('General Settings', 'cleanbook'), 'general_settings', 'cleanbook_general_page');
    add_settings_field('auto_register_bootstrap', __('Auto-register Bootstrap', 'cleanbook'), 'auto_register_bootstrap_string', 'cleanbook_general_page', 'cleanbook_general');

    //General settings
    add_settings_section('cleanbook_email', __('Email Notification Settings', 'cleanbook'), 'email_settings', 'cleanbook_general_page');
    add_settings_field('activate_email_notification', __('Activate email notification', 'cleanbook'), 'email_activation_string', 'cleanbook_general_page', 'cleanbook_email');
    add_settings_field('email', __('Email to notify', 'cleanbook'), 'email_string', 'cleanbook_general_page', 'cleanbook_email');
}

/*
    Print out a description of the general settings section
*/
function general_settings(){
    echo "<p>" . __("This is where you will find all of the general settingsthat affects the behavior of your Cleanbook plugin.", 'cleanbook') . "</p>";
}
/*
    Prints out Auto register option
*/
function auto_register_bootstrap_string() {
    $options = get_option('cleanbook_options');

    echo "<input id='auto_register_bootstrap' name='cleanbook_options[auto_register_bootstrap]' 
             type='checkbox' value='1'" . checked($options['auto_register_bootstrap'], 1, false ) . " />";
}

/*
    Print out a description of the email notification
*/
function email_settings(){
    echo "<p>" . __("This is where you will find all of the settings regarding notification by email.", 'cleanbook') . "</p>";
}
/*
    Prints out function for email settings
*/
function email_activation_string() {
    $options = get_option('cleanbook_options');

    echo "<input id='activate_email_notification' name='cleanbook_options[activate_email_notification]' 
             type='checkbox' value='1'" . checked($options['activate_email_notification'], 1, false ) . " />";
}

function email_string() {
    $options = get_option('cleanbook_options');

    $isActivated = $options['activate_email_notification'];

    echo "<input id='email' name='cleanbook_options[email]' 
             type='text' value='{$options['email']}' ". disabled( !$isActivated, true, false) . " />";
}

/*
    Validate the settings
*/
function validate_options($input){
    $newinput['auto_register_bootstrap'] = trim($input['auto_register_bootstrap']);
    $newinput['activate_email_notification'] = trim($input['activate_email_notification']);
    $newinput['email'] = trim($input['email']);
    
    if($newinput['auto_register_bootstrap'] == 1) {
        $newinput['auto_register_bootstrap'] = $input['auto_register_bootstrap'];
    } else {
        $newinput['auto_register_bootstrap'] = 0;
    }

    if($newinput['activate_email_notification'] == 1) {
        $newinput['activate_email_notification'] = $input['activate_email_notification'];
    } else {
        $newinput['activate_email_notification'] = 0;
    }

    if(!is_email($newinput['email'])) {
        $newinput['email'] = '';
    }
    
    return $newinput;
}


function settings_page(){
   include_once(CLEANBOOK_ADMIN_FILE_PATH . '/settings-page.php');
}

?>