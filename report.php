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
	
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css"/>
	
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<style>
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
		<a class="logout" href="<?php echo BASE_URL;?>phpqrcode/qrgen.php">Generate QRCode</a>
		<a class="logout" href="<?php echo BASE_URL;?>faculty.php">Faculty</a>
		<a class="logout" href="<?php echo BASE_URL;?>equipment.php"> Inventory</a>
		<a class="logout" href="<?php echo BASE_URL;?>available-equipment.php">Available Equipment</a>
		
	</div>

	<div class="p2-wrapper">
	<!-- <div class="sign-up-wrapper"> -->
		<div class="report-container" style="width:100%;">

		<!-- <div class="sign-up-inner"> -->
			<div id="report-left" style="padding-bottom: 100px; background:rgba(255,255,255, 0.9); float:left; width:70%;" >

				<div id="container" style="padding-left:10px; padding-top:10px width:80% margin-top:20px">
					<div class= "row">
						<div class="col-md-8">
							<table class="table table-bordered table-hover" style="width:100%">
								<thead>
									<tr>
										<th> Date</th>
										<th> ID</th>
										<th> FacultyName</th>
										<th> Department</th>
										<th> Phone</th>
										<th> Equipment ID</th>
										<th> Equipment Type</th>
										<th> CTE Staff</th>
										<th> Status</th>
										
									</tr>
								</thead>
								<tbody> 
									<?php
									require 'core/db.php';
									
									$sql = 'SELECT DTStamp, userID, userName, userDept, userPhone, itemID, itemType, cteStaff, chkinout FROM iteminout';
									$stmt = $conn->prepare($sql);
									$stmt->execute();
									$data =$stmt->fetchAll(PDO::FETCH_OBJ);

									foreach ($data as $dat):?>
									<tr>
										<td><?= $dat->DTStamp;?></td>
										<td><?= $dat->userID;?></td>
										<td><?= $dat->userName;?></td>
										<td><?= $dat->userDept;?></td>
										<td><?= $dat->userPhone;?></td>
										<td><?= $dat->itemID;?></td>
										<td><?= $dat->itemType;?></td>
										<td><?= $dat->cteStaff;?></td>
										<td><?= $dat->chkinout;?></td>
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
			});
        });
	</script>
	
	<!-- divs that holds the charts-->
	<!-- <div style="width:100%;" > -->
	<div id="report-right" style="padding-bottom: 100px; float:right; width:30%;" >	
		<h3 style="color:grey;text-align:center;"><b> Chart Visualization</b></h3>
		<div id="piechart" style = "margin: 0px 1px; width:100%; height:300px;"> </div>
		<div id="barchart" style = "margin: 0px 1px; width:100%; height:400px;"> </div>
		<div id="piechart2" style = "margin: 0px 1px; width:100%; height:300px;"> </div>

	</div>

	<!-- Google chart library link -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" >
		google.charts.load('current',{'packages':['corechart']}); //loads the latest version of the corecharts API.
		google.charts.setOnLoadCallback(drawChart); // Set a callback to run when the google visualization API is loaded.
	
		function drawChart(){
			// Define the chart to be drawn
			var data = google.visualization.arrayToDataTable([
				['Department' , 'Frequency'],
				<?php
				require 'core/db.php';
				$sql = 'SELECT userDept, count(*) as frequency FROM iteminout GROUP BY userDept';
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$data =$stmt->fetchAll(PDO::FETCH_OBJ);

				foreach ($data as $dat):
					echo "['".$dat->userDept."', ".$dat->frequency."],";
				endforeach;
				?>
			]);
			
			var data2 = google.visualization.arrayToDataTable([
				['Equipment', 'Usage'],
				<?php
				require 'core/db.php';
				$sql2 = 'SELECT itemType, ROUND(count(*) * 100 / (select count(*) from `iteminout`), 0) AS percentage from `iteminout` group by itemType';
				$stmt2 = $conn->prepare($sql2);
				$stmt2->execute();
				$data2 =$stmt2->fetchAll(PDO::FETCH_OBJ);

				foreach ($data2 as $dat2):
					echo "['".$dat2->itemType."', ".$dat2->percentage."],";
				endforeach;
				?>
			
			]);

			var data3 = google.visualization.arrayToDataTable([
				['Faculty', 'Frequency'],
				<?php
				require 'core/db.php';
				$sql3 = 'SELECT userName, count(*) as frequency FROM iteminout WHERE chkInout = "OUT" GROUP BY userName';
				$stmt3 = $conn->prepare($sql3);
				$stmt3->execute();
				$data3 =$stmt3->fetchAll(PDO::FETCH_OBJ);

				foreach ($data3 as $dat3):
					echo "['".$dat3->itemType."', ".$dat3->percentage."],";
				endforeach;
				?>
			
			]);

			// Set chart options
			var options = {
				title: 'Percentage by Department Serviced',
				is3D: true
			
			};

			var options2 = {
				title: 'Equipment Type by Number of times Used',
				hAxis: {
					 title: 'Usage (in percentage) %',
					 viewWindow: {
        				min: 0,
        				max: 100
   					 },
					 ticks: [0, 25, 50, 75, 100] // display labels every 25
        		},
        		vAxis: {
					  title: 'Equipment',
					//   gridlines: { count: 4 }
        		}
			};

			var options3 = {
				title: 'Staff Usage',
				is3D: true
			};
		

			// Instantiate and draw the chart
			var chart = new google.visualization.PieChart(document.getElementById('piechart'));
			chart.draw(data,options);
			
			var chart2 = new google.visualization.BarChart(document.getElementById('barchart'));
			chart2.draw(data2,options2);

			var chart3 = new google.visualization.PieChart(document.getElementById('piechart2'));
			chart3.draw(data3,options3);
			
		}
	</script>

<?php
    include 'footer.php';
?>

</body>			 		
</html>