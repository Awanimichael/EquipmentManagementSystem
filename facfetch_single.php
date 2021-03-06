<?php
include 'core/init.php';
require 'core/db.php';
require 'facfunction.php';

if(isset($_POST["user_id"]))
{
 $output = array();
 $statement = $conn->prepare(
  "SELECT * FROM faculty
  WHERE facID = '".$_POST["user_id"]."' 
  LIMIT 1"
 );
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["facID"] = $row["facID"];
  $output["facName"] = $row["facName"];
  $output["department"] = $row["department"];
  $output["phone"] = $row["phone"];
  $output["email"] = $row["email"];
  if($row["bcImgFilename"] != '')
  {
   $output['barcode'] = '<img src="'.$row["bcImgFilename"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_user_image" value="'.$row["bcImgFilename"].'" />';
  }
  else
  {
   $output['barcode'] = '<input type="hidden" name="hidden_user_image" value="" />';
  }
 }
 echo json_encode($output);
}
?>