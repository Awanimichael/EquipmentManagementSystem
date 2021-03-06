<?php

function upload_image()
{
 if(isset($_FILES["barcode"]))
 {
  $extension = explode('.', $_FILES['barcode']['name']);
  $new_name = rand() . '.' . $extension[1];
  $destination = 'images/' . $new_name;
  move_uploaded_file($_FILES['barcode']['tmp_name'], $destination);
  return $destination;
 }
}

function get_image_name($user_id)
{
 include('core/db.php');
 $statement = $conn->prepare("SELECT image FROM Inventory WHERE id = '$user_id'");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row["bcImgFilename"];
 }
}

function get_total_all_records()
{
 include 'core/db.php' ;
 $statement = $conn->prepare("SELECT * FROM inventory");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}

?>