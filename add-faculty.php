<?php
    include 'core/init.php';
	$user_id = $_SESSION['user_id'];
	$_SESSION['message'] = '';
	$user = $userObj->userData($user_id);
	$verifyObj->authOnly();


	if (isset($_POST['submit'])) {
		// Fetching variables of the form which travels in URL

		$FacID = $_POST['facID'];
		$FacName = $_POST['facName'];
		$Dept = $_POST['dept'];
		$Phone = $_POST['phone'];
		$Email = $_POST['email'];
		//FILES is a global varibale
		$Barcode_path = 'images/'.$_FILES['barcode']['name'];

		//make sure file type is image
		if (preg_match("!image!", $_FILES['barcode']['type'])) {

			//copy image to images/ folder
			if (copy($_FILES['barcode']['tmp_name'], $Barcode_path)) {

				//Insert into faculty table
				$user_id = $userObj->insert('faculty', array('facID' => $FacID, 'facName' => $FacName, 'department' => $Dept, 'phone' => $Phone, 'email' => $Email, 'bcImgFilename' => $Barcode_path));
				$_SESSION['message'] = "New record created successfully!";							
			} else {
				$_SESSION['message'] = "File upload failed!";
			}
		} else {
			$_SESSION['message'] = "Please only upload GIF, JPG, Jpeg or PNG images!";
		}
	}
?>


<!DOCTYPE html>
<html lang= "en">
<head>
	
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>Insert Faculty Information</title>
	<style>
    .submit {
        background: rgb(84, 118, 150);
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        }

    .submit:hover {
        background: rgb(255, 196, 37, 0.8);
        cursor: pointer;
    
        }
    </style>
</head>
<body class="body2">
<div class="banner">
	<h2>C.T.E EMS</h2>
</div>
<div class="home-nav">
	<a class="logout" href="<?php echo BASE_URL;?>home.php">Home</a>
    <a class="logout" href="<?php echo BASE_URL;?>report.php">Generate Report</a>
    <a class="logout" href="<?php echo BASE_URL;?>phpqrcode/qrgen.php">Generate QRCode</a>
    <a class="logout" href="<?php echo BASE_URL;?>available-equipment.php">Available Equipment</a>
	<a class="logout" href="<?php echo BASE_URL;?>equipment.php">Inventory</a>

	<div class="search-container">
		<form action="faculty-details.php" method="post">
			<input type="text" name="searchkey" placeholder="Find a Faculty.."/> 
			<button type="submit" name ="Search"><i class="fa fa-search"></i></button>
		</form>
	</div>
	
</div>

<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
		
		<h3>Add New Faculty</h3>
			<div class="sign-up-div">

			<form method="POST" enctype="multipart/form-data">
			<div class= "input"><?php echo $_SESSION['message'] ?></div>
            <!-- Method can be set as POST for hiding values in URL-->
            <!-- <label>Faculty ID:</label> -->
            <input class="input" name="facID" type="text" placeholder= "Faculty ID" value="" required/>
            <!-- <label>Factulty Name:</label> -->
            <input class="input" name="facName" type="text" placeholder= " LastName FirstName"value="" required/>
            <!-- <label>Department:</label> -->
            <input class="input" name="dept" type="text" placeholder= "Faculty Department" value="" required/>
			<!-- <label>Phone:</label> -->
            <input class="input" name="phone" type="text" placeholder= "Format XXXXXXXXXX" value="" required/>
            <!-- <label>Email:</label> -->
            <input class="input" name="email" type="email" placeholder= "Faculty Email"value="" required/>
            <label>QRCODE (Please click the "Generate QRCode" tab to generate a code for this facilty)</label>
            <input class="input" type="file" name="barcode" accept= "image/*" id="" required/>
            <input class="submit" name="submit" type="submit" value="Insert"/>
            </form>
			  
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>
</html>