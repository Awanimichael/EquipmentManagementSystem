<?php
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
		$user = $userObj->userData($user_id);
    $verifyObj->authOnly();
?>

<!DOCTYPE html>
<html lang="en">
 <head>


  <title>Add, Edit and delete Page</title>

   <!-- Load jquery library-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!-- Load bootstrap stylesheet library-->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <!-- Load jquery datatables javascript library-->
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <!-- Load datatables bootstrap javascript library-->
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <!-- Load datatables bootstrap stylesheet library-->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <!-- Load bootstrap javascript library-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


  <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body
    {
      margin:0;
      padding:0;
    }
    .box
    {
      width:1270px;
      /* padding:20px; */
      /* background-color:#fff; */
      background:rgba(255,255,255, 0.9);
      /* background: rgba(163,193,167,0.8); */
      border:1px solid #ccc;
      border-radius:5px;
      margin-top:25px;
      padding-bottom:100px
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
        <a class="logout" href="<?php echo BASE_URL;?>report.php">Generate report</a>
        <a class="logout" href="<?php echo BASE_URL;?>phpqrcode/qrgen.php">Generate QRCode</a>
        <a class="logout" href="<?php echo BASE_URL;?>equipment.php">Inventory</a>
        <a class="logout" href="<?php echo BASE_URL;?>available-equipment.php">Available Equipment</a>

        <div class="search-container">
            <form action="faculty-details.php" method="post">
                <input type="text" name="searchkey" placeholder="Find a Faculty.."/> 
                <button type="submit" name ="Search"><i class="fa fa-search"></i></button>
            </form>
	    </div>

    </div>

    <div class="p2-wrapper">
    <div class="sign-up-wrapper">
  

    <div class="container box">
    <h1 align="center">Faculty List</h1>
    <br />
    <div class="table-responsive">
        <br />
        <div align="right">
        <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Add</button>
        </div>
        <br /><br />
        <table id="user_data" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="10%">Qrcode</th>
                    <th width="10%">Faculty ID</th>
                    <th width="25%">Faculty Name</th>
                    <th width="25%">Faculty Department</th>
                    <th width="10%">Faculty phone</th>
                    <th width="10%">Faculty Email</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
        </table>
        
    </div>
    </div>
    </div>
    </div>

    <?php
        include 'footer.php';
    ?>

 </body>
</html>

<div id="userModal" class="modal fade">
 <div class="modal-dialog">
  <form method="post" id="user_form" enctype="multipart/form-data">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">Add New Equipment</h4>
    </div>
    <div class="modal-body">
     <label>Enter Faculty ID</label>
     <input type="text" name="facID" id="facID" class="form-control" placeholder= "Faculty ID" />
     <br />
     <label>Enter Faculty Firstname Lastname</label>
     <input type="text" name="facName" id="facName" class="form-control" placeholder= "Faculty Name" />
     <br />
     <label>Enter Faculty Department</label>
     <input type="text" name="department" id="department" class="form-control" placeholder= "Faculty Department" />
     <br />
     <label>Enter Faculty Phone</label>
     <input type="text" name="phone" id="phone" class="form-control" placeholder= "Format XXXXXXXXXX" />
     <br />
     <label>Enter Faculty Email</label>
     <input type="text" name="email" id="email" class="form-control" placeholder= "Faculty Email" />
     <br />
     <label>Select Qr code</label>
     <input type="file" name="barcode"  id="barcode" accept= "image/*" />
     <span id="user_uploaded_image"></span>
    </div>
    <div class="modal-footer">
     <input type="hidden" name="user_id" id="user_id" />
     <input type="hidden" name="operation" id="operation" />
     <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
   </div>
  </form>
 </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
 $('#add_button').click(function(){
  $('#user_form')[0].reset();
  $('.modal-title').text("Add New Faculty");
  $('#action').val("Add");
  $('#operation').val("Add");
  $('#user_uploaded_image').html('');
 });
 
 var dataTable = $('#user_data').DataTable({
  "processing":true,
  "serverSide":true,
  "order":[],
  "ajax":{
   url:"facfetch.php",
   type:"POST",
  },
  "columnDefs":[
   {
    "targets":[0, 6, 7],
    "orderable":false,
   },
  ],

 });

 $(document).on('submit', '#user_form', function(event){
  event.preventDefault();
  var facID      = $('#facID').val();
  var facName    = $('#facName').val();
  var department = $('#department').val();
  var phone      = $('#phone').val();
  var email      = $('#email').val();
  var extension  = $('#barcode').val().split('.').pop().toLowerCase();
  if(extension != '')
  {
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    alert("Invalid Image File");
    $('#barcode').val('');
    return false;
   }
  } 
  if(facID != '' && facName != '' && department != '' && phone != '' && email != '')
  {
   $.ajax({
    url:"facinsert.php",
    method:'POST',
    data:new FormData(this),
    contentType:false,
    processData:false,
    success:function(data)
    {
     alert(data);
     $('#user_form')[0].reset();
     $('#userModal').modal('hide');
     dataTable.ajax.reload();
    }
   });
  }
  else
  {
   alert("All Fields are Required");
  }
 });
 
 $(document).on('click', '.update', function(){
  var user_id = $(this).attr("id");
  $.ajax({
   url:"facfetch_single.php",
   method:"POST",
   data:{user_id:user_id},
   dataType:"json",
   success:function(data)
   {
    $('#userModal').modal('show');
    $('#facID').val(data.facID);
    $('#facName').val(data.facName);
    $('#department').val(data.department);
    $('#phone').val(data.phone);
    $('#email').val(data.email);
    $('.modal-title').text("Edit Faculty");
    $('#user_id').val(user_id);
    $('#user_uploaded_image').html(data.barcode);
    $('#action').val("Edit");
    $('#operation').val("Edit");
   }
  })
 });
 
 $(document).on('click', '.delete', function(){
  var user_id = $(this).attr("id");
  if(confirm("Are you sure you want to delete this?"))
  {
   $.ajax({
    url:"facdelete.php",
    method:"POST",
    data:{user_id:user_id},
    success:function(data)
    {
     alert(data);
     dataTable.ajax.reload();
    }
   });
  }
  else
  {
   return false; 
  }
 });
 
 
});
</script>