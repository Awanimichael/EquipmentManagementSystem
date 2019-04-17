<?php
include 'core/init.php';
include 'core/db.php';
include 'facfunction.php';

if(isset($_POST["operation"]))
{
 if($_POST["operation"] == "Add")
 {
  $bcImgFilename = '';
  if($_FILES["barcode"]["name"] != '')
  {
   $bcImgFilename = upload_image();
  }

  
  $statement = $conn->prepare("INSERT INTO faculty (facID, facName, department, phone, email, bcImgFilename) VALUES (:facID, :facName, :department, :phone, :email, :bcImgFilename) ");

  $result = $statement->execute(
    array(
    ':facID' => $_POST["facID"],
    ':facName' => $_POST["facName"],
    ':department' => $_POST["department"],
    ':phone' => $_POST["phone"],
    ':email' => $_POST["email"],
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
  $statement = $conn->prepare("UPDATE faculty SET facID = :facID, facName = :facName, department = :department, phone = :phone, email = :email, bcImgFilename = :bcImgFilename  
   WHERE facID = :id"
  );
  $result = $statement->execute(
   array(
    ':facID' => $_POST["facID"],
    ':facName' => $_POST["facName"],
    ':department' => $_POST["department"],
    ':phone' => $_POST["phone"],
    ':email' => $_POST["email"],
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