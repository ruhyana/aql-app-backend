<?php
  //ini_set('display_errors',1);
  //error_reporting(E_ALL);
  include 'config.php';

  $reg_id = $_REQUEST['reg_id'];
  $phone_id = $_REQUEST['phone_id'];
  $email = $_REQUEST['email'];
  $app_version = $_REQUEST['app_version'];
  $app_id = getAppId();

  if (isset($reg_id)) {
  connectToDatabase();
  
  $query = "INSERT INTO mobile_reg (phone_id, reg_id, email, app_version, app_id) VALUES ('$phone_id', '$reg_id', '$email', '$app_version', '$app_id') ";
  $query = $query . "ON DUPLICATE KEY UPDATE reg_id = VALUES(reg_id), email = VALUES(email), app_version = VALUES(app_version), app_id = VALUES(app_id)";
  if (!mysql_query($query)) {
    echo "REG_ERROR";
    die('Error: ' . mysql_error());
  }
  mysql_close();
  echo "REG_OK";
}
?> 
