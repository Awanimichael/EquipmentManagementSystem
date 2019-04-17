<?php
   include 'core/init.php';
   $user_id = $_SESSION['user_id'];
   $user = $userObj->userData($user_id);
   $verifyObj->authOnly();
?>

<!DOCTYPE html>
<html>
<head>

	<!-- Required meta tags -->
    <meta charset="UTF-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
	<title>Query and Generate Reports</title>

    <!-- Bootstrap CSS -->
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css"/>
	
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

<style>
	.sign-up-inner{
		background: rgba(255,255,255, 0.9);
	}
	th {font-size: 16px;}
	td {font-size: 14px;}

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

</head>
<body class="body2">
<div class="banner">
	<div class="logo">
		<img src="assets/img/cte_logo.png"/>
	</div>
	<h2>C.T.E EMS</h2>
</div>
	<div class="home-nav">
		<a class="logout" href="<?php echo BASE_URL;?>home.php">Home</a>
		<a class="logout" href="<?php echo BASE_URL;?>report.php">Generate Report</a>
		<a class="logout" href="<?php echo BASE_URL;?>phpqrcode/qrgen.php">Generate QRCode</a>
		<a class="logout" href="<?php echo BASE_URL;?>faculty.php">Faculty</a>
		<a class="logout"  href="<?php echo BASE_URL;?>equipment.php"> Inventory </a>
	</div>

	<div class="p2-wrapper">
		<div class="sign-up-wrapper">
			<div class="sign-up-inner">
	
				<div class="container" style="margin-top: 20px;">
					<div class= "row" style="padding-bottom:50px">
						<div class="col-md-8 ">
							<table class="table table-bordered table-hover" style="width:100%">
								<thead>
									<tr>
										<th> Equipment ID</th>
										<th> Equipment Type</th>
										<th> Equipment Notes</th>
							
									</tr>
								</thead>
								<tbody> 
								<?php
								require 'core/db.php';
								// Equipment presently out (All equipment - equipment Out)
								// $sql = 'SELECT itemID,itemType,itemNotes FROM inventory WHERE itemID NOT IN (SELECT itemID FROM iteminout WHERE chkInout = "OUT")';
								$sql =  'SELECT itemID,itemType,itemNotes FROM inventory WHERE itemID NOT IN (SELECT itemID from (SELECT itemID, count(itemID) as F FROM iteminout Group By itemID) as T where T.F % 2 <> 0)';
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								$data =$stmt->fetchAll(PDO::FETCH_OBJ);

								foreach ($data as $dat):?>
								<tr>
									<td><?= $dat->itemID;?></td>
									<td><?= $dat->itemType;?></td>
									<td><?= $dat->itemNotes;?></td>
								</tr>

								<?php endforeach;?>
								</tbody>
							</table>
						<div>
					</div>		
				</div>
			</div>
		</div>
	</div>

	<script src="http://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

	<script type="text/javascript" src="jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('.table').DataTable({
				"ordering": true
			});
        });
    </script>


<?php
    include 'footer.php';
?>

</body>							
				 		

</html>