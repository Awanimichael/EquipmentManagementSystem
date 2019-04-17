<?php
include 'core/init.php';
include 'core/db.php';
include 'efunction.php';

if(isset($_POST["operation"]))
{
 if($_POST["operation"] == "Add")
 {
  $bcImgFilename = '';
  if($_FILES["barcode"]["name"] != '')
  {
   $bcImgFilename = upload_image();
  }

  
  $statement = $conn->prepare("INSERT INTO inventory (itemID, itemType, itemNotes, bcImgFilename) VALUES (:itemID, :itemType, :itemNotes, :bcImgFilename) ");

  $result = $statement->execute(
    array(
    ':itemID' => $_POST["itemID"],
    ':itemType' => $_POST["itemType"],
    ':itemNotes' => $_POST["itemNotes"],
    ':bcImgFilename'  => $bcImgFilename
   ));
  if(!empty($result))
    {
    echo 'Data Inserted Click Ok to Continue';
    }
    else {
      echo 'An Error Occured';
    }
 }

 if($_POST["operation"] == "Edit")
 {
  $bcImgFilename = '';
  if($_FILES["barcode"]["name"] != '')
  {
   $bcImgFilename = upload_image();
  }
  else
  {
   $bcImgFilename = $_POST["hidden_user_image"];
  }
  $statement = $conn->prepare("UPDATE inventory SET itemID = :itemID, itemType = :itemType, itemNotes = :itemNotes, bcImgFilename = :bcImgFilename  
   WHERE itemID = :id"
  );
  $result = $statement->execute(
   array(
    ':itemID' => $_POST["itemID"],
    ':itemType' => $_POST["itemType"],
    ':itemNotes' => $_POST["itemNotes"],
    ':bcImgFilename'  => $bcImgFilename,
    ':id'   => $_POST["user_id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Updated';
  }
  else{
    echo 'result empty';
  }
 }
}

?>