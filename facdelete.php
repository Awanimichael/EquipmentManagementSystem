<?php
include 'core/init.php';
include 'core/db.php';
include 'facfunction.php';

if(isset($_POST["user_id"]))
{
 $image = get_image_name($_POST["user_id"]);
 if($image != '')
 {
  unlink("upload/" . $image);
 }
 $statement = $conn->prepare(
  "DELETE FROM faculty WHERE facID = :id"
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