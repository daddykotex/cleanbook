<?php


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

/*
	Print out a description of the general settings page
*/
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
   include_once(CLEANBOOK_ADMIN_FILE_PATH . '/settings-page.php');
}

?>