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
		<a class="logout" href="<?php echo BASE_URL;?>faculty.php">Faculty</a>
		<a class="logout" href="<?php echo BASE_URL;?>available-equipment.php">Available Equipment</a>
	</div>

  <div class="p2-wrapper">
	<div class="sign-up-wrapper">
  

  <div class="container box">
   <h1 align="center">Inventory List</h1>
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
       <th width="20%">Equipment ID</th>
       <th width="20%">Type</th>
       <th width="30%">Notes</th>
       <th width="10%">Edit</th>
       <th width="10%">Delete</th>
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
     <label>Enter Equipment ID</label>
     <input type="text" name="itemID" id="itemID" class="form-control" placeholder= "Equipment ID" />
     <br />
     <label>Enter Equipment Type</label>
     <input type="text" name="itemType" id="itemType" class="form-control" placeholder= "Equipment Type" />
     <br />
     <label>Enter Equipment Note</label>
     <input type="text" name="itemNotes" id="itemNotes" class="form-control" placeholder= "Equipment Notes" />
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
  $('.modal-title').text("Add New Equipment");
  $('#action').val("Add");
  $('#operation').val("Add");
  $('#user_uploaded_image').html('');
 });
 
 var dataTable = $('#user_data').DataTable({
  "processing":true,
  "serverSide":true,
  "order":[],
  "ajax":{
   url:"efetch.php",
   type:"POST",
  },
  "columnDefs":[
   {
    "targets":[0, 4, 5],
    "orderable":false,
   },
  ],

 });

 $(document).on('submit', '#user_form', function(event){
  event.preventDefault();
  var itemID = $('#itemID').val();
  var itemType = $('#itemType').val();
  var itemNotes = $('#itemNotes').val();
  var extension = $('#barcode').val().split('.').pop().toLowerCase();
  if(extension != '')
  {
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    alert("Invalid Image File");
    $('#barcode').val('');
    return false;
   }
  } 
  if(itemID != '' && itemType != '' && itemNotes != '')
  {
   $.ajax({
    url:"einsert.php",
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
   url:"efetch_single.php",
   method:"POST",
   data:{user_id:user_id},
   dataType:"json",
   success:function(data)
   {
    $('#userModal').modal('show');
    $('#itemID').val(data.itemID);
    $('#itemType').val(data.itemType);
    $('#itemNotes').val(data.itemNotes);
    $('.modal-title').text("Edit Equipment");
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
    url:"edelete.php",
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