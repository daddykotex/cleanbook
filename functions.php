<?php

/*
    Sends an email, if the option is activated, to the specified email address.
*/
function send_notification_email($appointment){

    $options = get_option('cleanbook_options');
    if($options['activate_email_notification'] && !empty($options['email'])){
        $to = $options['email'];
        $subject = sprintf(__('%s booked an appointment on %s.', 'cleanbook'), $appointment['name'], SITE_URL);
        $message =  __('Hi,') . '<br /><br />';
        $message .= sprintf(__('You received this email to let you know that %s as booked an appointment from your website. Here is the information regarding this appointment:'), $appointment['name']) . '<br /><br />';
        $message .= __('Fullname', 'cleanbook') . ' : ' . $appointment['name'] . '<br />';
        $message .= __('Email', 'cleanbook') . ' : ' . $appointment['email'] . '<br />';
        $message .= __('Phone', 'cleanbook') . ' : ' . $appointment['phone'] . '<br />';
        $message .= __('Date and time', 'cleanbook') . ' : ' . $appointment['datetime'] . '<br />';
        $message .= __('Comment', 'cleanbook') . ' : ' . $appointment['comment'] . '<br /><br />';

        $message .= sprintf(__('You can log in the administration panel of your site %s to confirm the appointment.'), get_option('blogname'));

        $headers[] = "Content-type: text/html";

         wp_mail( $to, $subject, $message, $headers ); 
    }
}

/*
    Build an array containing the appointment information
*/
function appointment_from_post(){
    $appointment = array();
    $appointment['name'] = trim($_POST['name']);
    $appointment['email']= trim($_POST['email']);
    $appointment['phone']= trim($_POST['phone']);
    $appointment['datetime']= trim($_POST['datetime']);
    $appointment['comment']= trim($_POST['comment']);
    $appointment['active']= trim($_POST['active']);
    if($appointment['active'] != 1){
        $appointment['active'] = 0;
    }

    return $appointment;
}

/*
    Validate if an appointment is legitimage
*/
function validate($appointment){
    $errors = array();
    if(empty($appointment['name'])){
        $errors[] = array('message' => __("Please provide a name.", "cleanbook"));
    }

    if(empty($appointment['email'])){
        $errors[] = array('message' => __("Please provide an email.", "cleanbook"));
    } else if (!is_email($appointment['email'])){
        $errors[] = array('message' => __("Please provide a valid email : valid@email.com.", "cleanbook"));
    }

    if(empty($appointment['phone'])){
        $errors[] = array('message' => __("Please provide a phone.", "cleanbook"));
    } else if (!preg_match("/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/", $appointment['phone'])){
        $errors[] = array('message' => __("Please provide a valid phone number : (514) 555-5555.", "cleanbook"));
    }

    if(empty($appointment['datetime'])){
        $errors[] = array('message' => __("Please provide a date and time", "cleanbook"));
    } else if (!strtotime($appointment['datetime'])){
        $errors[] = array('message' => __("Please provide a valid date and time : 2014-10-21 16:00:00.", "cleanbook"));
    }

    return $errors;
}

/*
    Remove any undesirable html from the user input
*/
function KSES_data($data){
    $valid = array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
    );

    foreach($data as $key=>$value){
        $data[$key] = wp_kses( $value, $valid );
    }

    return $data;
}
?>