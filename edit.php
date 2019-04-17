<?php
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
    $itemID = $_GET['itemID'];
    $item = $itemObj->itemData($itemID);
    $user = $userObj->userData($user_id);
    $_SESSION['message'] = '';
   
    if (isset($_POST['update'])) {

	    $itemID = $_POST['itemID'];
		$itemType = $_POST['itemType'];
		$itemNotes = $_POST['itemNotes'];
		$chkInout = $_POST['chkInout'];
		$Barcode_path = 'images/'.$_FILES['barcode']['name'];

		//make sure file type is image
		if (preg_match("!image!", $_FILES['barcode']['type'])) {

			//copy image to images/ folder
			if (copy($_FILES['barcode']['tmp_name'], $Barcode_path)) {
				$item_id = $itemObj->update('inventory', array('itemID' => $itemID, 'itemType' => $itemType, 'itemNotes' => $itemNotes, 'chkInout' => $chkInout , 'bcImgFilename' => $Barcode_path), array('itemID' => $itemID));
                $_SESSION['message'] = "Record Updated";
                $userObj->redirect('Equipment.php');
               						
			} else {
				$_SESSION['message'] = "File upload failed";
			}
		} else {
			$_SESSION['message'] = "Please only upload GIF, JPG, Jpeg or PNG images";
        }
    }
	
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    
    <title>Insert Department Equipment</title>

    <style>
    .submit {
        background: rgb(84, 118, 150);
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        }

    .submit:hover {
        background: rgb(68, 127, 182);
        cursor: pointer;
    
        }
    </style>
</head>

<body class="body2">
<div class="home-nav">
	<a href="<?php echo BASE_URL;?>home.php">Home</a>
    <a href="<?php echo BASE_URL;?>phpqrcode/qrgen.php"> GENERATE QRCODE</a>
</div>
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
        <h2>Update Item in CTE Inventory.</h2>
			<div class="sign-up-div">
            <form method="POST" enctype="multipart/form-data">
            <!-- Method can be set as POST for hiding values in URL-->
            <div class= "input"><?php echo $_SESSION['message'] ?></div>
            <label>Item ID:</label>
            <input class="input" name="itemID" type="text" placeholder= "Insert Item Unique ID" value="<?= $item->itemID;?>" required/>

            <label>Item Type:</label>
            <input class="input" name="itemType" type="text" placeholder= "Insert Item Type" value="<?= $item->itemType;?>" required/>

            <label>Item Notes:</label>
            <input class="input" name="itemNotes" type="text" placeholder= "Insert Item Note" value="<?= $item->itemNotes;?>" required/>

            <label>Item Status:</label>
            <input class="input" name="chkInout" type="text" placeholder= "Default value is (IN)" value="<?= $item->chkInout;?>" required/>

            <label>Barcode:</label>
            <input class="input" type="file" name="barcode" accept= "image/*" id="" required/>
            <input class="submit" name="update" type="submit" value="Update"/>
            </form>
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>

</html>