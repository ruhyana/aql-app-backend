<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

function scaleImage($files) {

// Create image from file
switch(strtolower($files['type']))
{
    case 'image/jpeg':
        $image = imagecreatefromjpeg($files['tmp_name']);
        break;
    case 'image/png':
        $image = imagecreatefrompng($files['tmp_name']);
        break;
    case 'image/gif':
        $image = imagecreatefromgif($files['tmp_name']);
        break;
    default:
        exit('Unsupported type: '.$files['type']);
}

// Target dimensions
$max_width = 720;
$max_height = 720;

// Get current dimensions
$old_width  = imagesx($image);
$old_height = imagesy($image);

// Calculate the scaling we need to do to fit the image inside our frame
$scale      = min($max_width/$old_width, $max_height/$old_height);

// Get the new dimensions
$new_width  = ceil($scale*$old_width);
$new_height = ceil($scale*$old_height);

// Create new empty image
$new = imagecreatetruecolor($new_width, $new_height);

// Resize old image into new
imagecopyresampled($new, $image, 
    0, 0, 0, 0, 
    $new_width, $new_height, $old_width, $old_height);

// Catch the imagedata
ob_start();
imagejpeg($new, NULL, 90);
$data = ob_get_clean();

// Destroy resources
imagedestroy($image);
imagedestroy($new);

// Set new content-type and status code
//header("Content-type: image/jpeg", true, 200);
//echo $data;

// Output data
return $data;
}

function saveToDisk($files, $update_id) {
  $tmp_name = $files["tmp_name"];
  move_uploaded_file($tmp_name, 'image_upload/' .$update_id);
}

function saveImageToDb($files, $update_id) {
    $maxsize = 10000000;    
    connectToDatabase();

 // check the file is less than the maximum file size
        if($files['size'] < $maxsize)
            {
        // prepare the image for insertion
        $imgData =addslashes (file_get_contents($files['tmp_name']));
 
        // get the image info..
          $size = getimagesize($files['tmp_name']);

         $smallImage = addslashes (scaleImage($files));
 
        // our sql query
        $sql = "INSERT INTO yisc_update_image 
                (yisc_update_id , type ,image, size, name)
                VALUES
                ('" . $update_id . "', '{$size['mime']}', '{$smallImage}', '{$size[3]}', '{$files['name']}')";


        // insert the image
        if(!mysql_query($sql)) {
            echo 'Unable to upload file';
            echo mysql_error();
            } 
        }
}

?>
