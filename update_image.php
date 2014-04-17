<?php
    // just so we know it is broken
    //error_reporting(E_ALL);

   include 'SimpleImage.php';
   include 'database.php';


    // some basic sanity checks
    $updateId = $_REQUEST['update_id'];
    if(isset($updateId) && is_numeric($updateId)) {            
	//displayFromDb($updateId);
       displayFromdisc($updateId);
    }
    else {
        echo 'Please use a real id number';
    }

function displayFromDisc($updateId)  {
       $image_location = "image_upload/" . $updateId;
       $size = getimagesize($image_location);
       $img_type = $size['mime'];
	header("Content-type: ".$img_type);

	$image = new SimpleImage();
       $image->load($image_location);
       $image->resizeToWidth(720);
       $image->output();
}

function displayFromDb($updateId) {
        connectToDatabase();
 
        // get the image from the db
        $sql = "SELECT image FROM yisc_update_image WHERE yisc_update_id=" . $updateId;
 
        // the result of the query
        $result = mysql_query("$sql") or die("Invalid query: " . mysql_error());
 
        // set the header for the image
        header("Content-type: image/jpeg");
        echo mysql_result($result, 0);
 
        // close the db link
        mysql_close($link);
}
?>
