
<?php
    include '../core/init.php';
	$user_id = $_SESSION['user_id'];
    $user = $userObj->userData($user_id);
    $verifyObj->authOnly();

?>


<!DOCTYPE html>
<html>
<head>
	<title>Query and Generate Reports</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">


</head>
<style>
	.reset:hover {
        background: rgb(255, 196, 37, 0.8);
        cursor: pointer;
		}

	#footer {
      position: fixed;
      left:0;
      bottom:0;
      width: 100%;
      height: auto;
      background-color:white;
      /* text-align:center; */
      padding-top: 10px;
    }
</style>
<body class="body2">
	<div class="banner">
		<div class="logo">
			<img src="../assets/img/cte_logo.png"/>
		</div>
		<h2>C.T.E EMS</h2>
	</div>
	<div class="home-nav">
		<a class="logout" href="<?php echo BASE_URL;?>home.php">Home</a>
		<a class="logout" href="<?php echo BASE_URL;?>report.php">Report</a>
		<a class="logout" href="<?php echo BASE_URL;?>faculty.php">Faculty</a>
		<a class="logout" href="<?php echo BASE_URL;?>available-equipment.php">Available Equipment</a>
		<a class="logout"  href="<?php echo BASE_URL;?>equipment.php"> Inventory </a>
	</div>
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">

            <h2>Generate QR Code</h2><br />

            <form action= "qrcode.php" method= "POST">
			<textarea rows="10" cols="40" width= 50% style= "font-size:15px" name="text" placeholder="Enter QRcode Data"></textarea> 
			<p>
				If you creating a Qrcode for faculty enter: <b><i>Faculty ID, Name, Department, Phone and Email.</i></b>
			</p>
			<p>
				If you creating a Qrcode for Equipment enter: <b><i>Equipment ID, Equipment Type and Note.</i></b>
			</p>
			<br />
            <input class= "reset" type= "submit" name= "btnsubmit" value="Create QR Code" />
            <input class="reset" type= "reset" value="Reset" name="reset" />
            </form> 
			  
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->

<?php
    include '../footer.php';
?>

</body>
</html>