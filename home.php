<?php
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
		$user = $userObj->userData($user_id);
		$verifyObj->authOnly();
    // echo $user->username;
    // echo $_SESSION['suer_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/indexstyle.css"/>
	<link href="assets/css/grid.css" rel="stylesheet" type="text/css" />

	<title>Home</title>
	
<style>

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    /* background-color: #333; */
		background-color: #4f2582;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
	background-color: #fec325;
	/* background-color: #111; */
	color: white;
}

</style>

</head>

<body class="body">
	<div class="wrapper">
	<div class="wrapper-inner">
		<div class="header-wrapper">
			<div class="logo">
        <img src="assets/img/cte_logo.png"/>
      </div>
			<h1>C.T.E EMS</h1>
			<ul>
				<li><a href="<?php echo BASE_URL;?>faculty.php">FACULTY</a></li>
				<li><a href="<?php echo BASE_URL;?>report.php"> GENERATE REPORT</a></li>
				<li><a href="<?php echo BASE_URL;?>equipment.php">INVENTORY</a></li>
				<li><a href="<?php echo BASE_URL;?>phpqrcode/qrgen.php"> GENERATE QRCODE</a></li>
				<li><a href="<?php echo BASE_URL;?>available-equipment.php"> AVAILABLE EQUIPMENT</a></li>
			</ul>
		</div><!--HEADER WRAPPER ENDS-->
		<div class="xop-section">
                    <div class="xop-grid">
                      <li>
                        <div class="xop-box xop-img-1">
                        	<a href="<?php echo BASE_URL;?>faculty.php">
							  <img src="assets/img/faculty.png" alt="Faculty" style="width:100%; height:170px">
							</a>
                           	<h3>Faculty</h3>
                            <p>Add a New Faculty</p>	
                        </div>
                      </li>
                      <li>
					  	<div class="xop-box xop-img-1">
                        	<a href="<?php echo BASE_URL;?>report.php">
							  <img src="assets/img/report.png" alt="Faculty" style="width:100%; height:170px">
							</a>
                           	<h3>Lending Activities</h3>
                            <p>Generate Report</p>	
                        </div>
                      </li>
                      <li>
					  	<div class="xop-box xop-img-1">
                        	<a href="<?php echo BASE_URL;?>equipment.php">
							  <img src="assets/img/inventory.png" alt="Faculty" style="width:100%; height:170px">
							</a>
                           	<h3>Inventory</h3>
                            <p>Update Inventory</p>	
                        </div>
					  </li>
					  <li>
					  	<div class="xop-box xop-img-1">
                        	<a href="<?php echo BASE_URL;?>phpqrcode/qrgen.php">
							  <img src="assets/img/qrcode.jpg" alt="Faculty" style="width:100%; height:170px">
							</a>
                           	<h3>QRcode</h3>
                            <p>Generate QRcode</p>	
                        </div>
					  </li>
					  <li>
					  	<div class="xop-box xop-img-1">
                        	<a href="<?php echo BASE_URL;?>available-equipment.php">
							  <img src="assets/img/equipment.png" alt="Faculty" style="width:100%; height:170px">
							</a>
                           	<h3>Equipment</h3>
                            <p>Available Equipment</p>	
                        </div>
                      </li>
					</div>
        </div>

		<div class="signed-div">
		<div class="signed-in">
			<div class="profile-name">
			<!-- <a href="#"> <?//php echo $user->firstName. ' ' .$user->lastName;?></a> -->
			<a href="#"> <?php echo $user->name?></a>
			</div>
			<div class="profile-date-l">
				<?php $date = $user->joined;?>
					Joined Date: <?php echo date('F - Y', strtotime($date));?>
			</div>
			<div class="profile-footer">
				<button class="log-out" onclick="location.href='includes/logout.php';">Log out</button>
				<button class="setting" onclick="location.href='account/settings';">Settings</button>
			</div><!--profile-footer ends-->
			
		</div>
		</div>
	</div><!--CONTENT WRAPPER ENDS-->

	</div><!--WRAPPER ENDS-->
	
</body>

</html>
