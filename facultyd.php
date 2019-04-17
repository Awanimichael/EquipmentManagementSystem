<?php
include 'core/init.php';
require 'core/db.php';
$user_id = $_SESSION['user_id'];
$user = $userObj->userData($user_id);
$verifyObj->authOnly();

if(isset($_POST['searchkey'])){
    $searchkey= $_POST['searchkey'];
    // echo $searchkey;
    $stmt = $conn->prepare("SELECT facName, department, bcImgFilename FROM faculty WHERE facName LIKE '%$searchkey%'");
    $stmt->bindValue(1, "%searchkey%", PDO::PARAM_STR);
    $stmt->execute();
}
?>