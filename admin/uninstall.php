<?php 

  global $wpdb;
  $appointments = $wpdb->prefix . CLEANBOOK_TABLE_APPOINTMENTS;   
  $wpdb->query("DROP TABLE IF EXISTS $appointments");
   
?>