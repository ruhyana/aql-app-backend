<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<?php
  header('Content-Type: text/html; charset=UTF-8');
  //ini_set('display_errors',1);
  //error_reporting(E_ALL);

  include 'database.php';
  include 'image.php';

  $input_title = $_REQUEST['title'];
  $input_text = $_REQUEST['text'];
  $input_image = $_FILES['imageFile'];
  $pwd = $_REQUEST['pwd'];     

  if (!isset($input_title)) {
     echo "Form harap diisi dengan benar";
  } 

if ($pwd === getSendpassword()) {
     connectToDatabase();
    $input_title = mysql_real_escape_string($input_title);
    $input_text = mysql_real_escape_string($input_text);
    $imageExist = ($_FILES["imageFile"]["size"] > 0);

    $updateId = insertIntoDatabase($input_title, $input_text, $imageExist);
    
    $tmp_name = $input_image["tmp_name"];
    list($width, $height, $type, $attr) = getimagesize($tmp_name);

    if ($width > getMaxUploadImageWidthInPixel()) {
       echo "Ukuran image harus lebih kecil dari " . getMaxUploadImageWidthInPixel() . "x" . getMaxUploadImageHeightInPixel();
    } else {
      if ($imageExist) {
         saveImage($updateId);
      } 
      sendMessageToAllUsers($input_title, $input_text, $updateId, $imageExist);
    }
  } else {
    echo "Password anda salah";
  }

  mysql_close(); 	

/////////////////////////////////////// funtions //////////////////////////////////////////

 

  function saveImage($imageId) {    
     //saveImageToDb($_FILES['imageFile'], $imageId);
       saveToDisk($_FILES['imageFile'], $imageId);
  }

  function insertIntoDatabase($title, $content, $imageExist) {
      $hasImage = 0;
      if ($imageExist) {
         $hasImage = 1;
      }

      $app_id = getAppId();
      $query = "INSERT into yisc_update (title, content, has_image, app_id) VALUES ('$title', '$content', $hasImage, '$app_id');";
      mysql_query("SET NAMES 'utf8'");
      mysql_query($query);   
      return mysql_insert_id();
  }

  function sendMessageToAllUsers($title, $text, $updateId, $imageExist) {
    $app_id = getAppId();
    $query = "SELECT distinct reg_id from mobile_reg WHERE app_id = '$app_id'";
    $result = mysql_query($query);

     $regs = array();
     while($row = mysql_fetch_assoc($result))
    {
       $curReg = $row['reg_id'];
       $regs[] = $curReg;       
    }
    //comment this for all users
    //$regs = array('APA91bHqe8-BcuycyKYGPhK3JO8gYwPib7t7bxDzk6o1y5CqgHWAyHw3_f0CcHzwyG4lda8O8wiy58FP-Edn_Tb3JRSWhnjIX5M2QJ6SQOsWDxE7FFQNPLKxUXxor7VQd1Z2bFPTSJRg', 'APA91bEPmA3FP-Eae-XFZ8DnsjqVZ6lSGjApggO4QomryaULfR2fi6MrIvj2UOy6fLkRcjBHrQ_bSMbiHfYJ9EN6k4Msw_n_kvxF4A9wWe06W-Yvk3zRrPa4ncdwz5Nb1QbPC_sRD6dekIIlvGYA_YLf3L5KVGEexQ');

    sendMessageToPhone($regs, $title, $text, $title, $updateId, $imageExist);    
  }
 
function sendMessageToPhone($deviceToken, $collapseKey, $messageText, $title, $updateId, $imageExist)    
{    
    $yourKey = 'AIzaSyDfX3S4TiDPZoExzBeierI_piUoI5MDIS8';  

    $headers = array('Authorization:key=' . $yourKey, 'Content-Type: application/json');    

    $data = array(    
        'registration_ids' => $deviceToken,    
        'collapse_key' => $collapseKey,    
        'data' => array ("title" => $title, "time" => current_millis(), "id" => $updateId, "has_image" => $imageExist)
    );     
    $ch = curl_init();    
    
    curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");    
    if ($headers)    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
    curl_setopt($ch, CURLOPT_POST, true);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));    
    
    $response = curl_exec($ch);    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);    
    if (curl_errno($ch)) {    
        //request failed    
        return false;//probably you want to return false    
    }    
    if ($httpCode != 200) {     
        //request failed    
        return false;//probably you want to return false    
    }    

    $header_size = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
    $body = substr( $response, $header_size );
    $json_response = json_decode($response, true);
    $results = $json_response['results'];

    $x = 0;
    $success_count = 0;
    foreach ($results as $device_response) {
       $msg_id =  $device_response['message_id'];
       $error_msg =  $device_response['error'];
       $new_reg_id = $device_response['registration_id'];
       $old_reg_id =  $deviceToken[$x];


       if (isset($error_msg)) {
          if ($error_msg === 'NotRegistered') {
             //echo $old_reg_id . " is not registered, deleted from database"; 
             $query = "DELETE FROM mobile_reg WHERE reg_id = '" . $old_reg_id . "';";
             mysql_query($query) or die(mysql_error());
          } else if ($error_msg === 'InvalidRegistration') {
             echo $old_reg_id . " is invalid"; 
          } else if ($error_msg === 'Unavailable') {
             echo $old_reg_id . " is unavailable";
          }
       } 
       if (isset($new_reg_id)) {
           //echo $old_reg_id . " needs a new registration id, replacing with a new one";
           $query = "UPDATE mobile_reg set reg_id = '" . $new_reg_id . "' WHERE reg_id = '" . $old_reg_id . "';";
           mysql_query($query) or die(mysql_error());
       }
       if (isset($msg_id)) {
           $success_count = $success_count + 1;
       }
        
       $x = $x + 1;
    }
     echo "Pesan sukses terkirim ke " . $success_count . "/" . count($deviceToken);
    curl_close($ch);    



    return $response;    
} 

// return our current unix time in millis
   function current_millis() {
    list($usec, $sec) = explode(" ", microtime());
    return round(((float)$usec + (float)$sec) * 1000);
   }
?> 

<html>
<body>
<form enctype="multipart/form-data" method="POST" accept-charset="utf-8">
Title: <input type="text" name="title">
<br> 
Foto: <input type="file" name="imageFile" accept="image/jpeg"> 
<br>
Password: <input type="password" name="pwd">
<BR>
Text: 
<textarea rows="4" cols="50" name="text">
</textarea><BR>
<input type="submit" value="Submit" ></form>
</form>
</body>
</html>
