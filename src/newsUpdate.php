<?php
   header('Content-Type: text/html; charset=UTF-8');
   //ini_set('display_errors',1);
   //error_reporting(E_ALL);

   include 'config.php';

   $input_updateId= $_REQUEST['updateId'];

   connectToDatabase();

   mysql_query('SET CHARACTER SET utf8');

   $app_id = getAppId();
   
   $query = "SELECT * FROM yisc_update WHERE app_id = '$app_id' ";
   if (isset($input_updateId) && $input_updateId != '-1') {
      $query = $query . ' AND id = ' . $input_updateId;
   } 

   $query = $query . ' ORDER BY ID DESC LIMIT 5';

   $result = mysql_query($query) or die(mysql_error());
   
   $data = array();
   while ($row = mysql_fetch_array($result)) {
         $rowData = array();
         $rowData['id'] = $row['id']; 
         $rowData['content'] = stripslashes($row['content']);
	  $rowData['title'] = stripslashes($row['title']);
         $rowData['hasImage'] = $row['has_image'];
         $rowData['time'] = $row['date'];
         $data[] = $rowData;
   }
  
   echo json_encode($data);

   
   mysql_close(); 	
?>
