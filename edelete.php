<?php
include 'core/init.php';
include 'core/db.php';
include 'efunction.php';

if(isset($_POST["user_id"]))
{
 $image = get_image_name($_POST["user_id"]);
 if($image != '')
 {
  unlink("upload/" . $image);
 }
 $statement = $conn->prepare(
  "DELETE FROM inventory WHERE itemID = :id"
 );
 $result = $statement->execute(
  array(
   ':id' => $_POST["user_id"]
  )
 );
 
 if(!empty($result))
 {
  echo 'Data Deleted';
 }
}



?>