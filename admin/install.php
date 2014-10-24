<?php 
  global $wpdb;  

   $appointments = $wpdb->prefix . CLEANBOOK_TABLE_APPOINTMENTS;      
   $appointments_sql = "CREATE TABLE  IF NOT EXISTS $appointments (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            type ENUM('RENDEZ-VOUS') NOT NULL DEFAULT 'RENDEZ-VOUS',
        		name VARCHAR(50) NOT NULL,
        		email VARCHAR(50) NOT NULL,
        		phone VARCHAR(25) NOT NULL,
        		datetime DATETIME NOT NULL,
        		comment VARCHAR(1500) NOT NULL,
            active TINYINT(1) NOT NULL DEFAULT 0,
        		UNIQUE KEY id (id),
              PRIMARY KEY (`id`)
            );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   
   dbDelta( $appointments_sql );
   
?>