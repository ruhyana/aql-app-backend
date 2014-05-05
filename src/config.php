<?php
 function connectToDatabase() {
    $username ="k2214867_publish";
    $password="inipwdnya";
    $database="k2214867_publish";
    $con = mysql_connect("localhost",$username,$password);
    if (!$con)
    {
      die('Could not connect: ' . mysql_error());
    }

    @mysql_select_db($database) or die( "Unable to select database");
  }

 function getSendpassword() {
    return 'pwdaql';
 }

 function getMaxUploadImageWidthInPixel() {
    return 1024;
 }

 function getMaxUploadImageHeightInPixel() {
    return 768;
 }

 function getAppId() {
    return 'aql';
 }

 function get_gcm_api_key() {
    return 'AIzaSyDfX3S4TiDPZoExzBeierI_piUoI5MDIS8';

 }
?>
