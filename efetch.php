<?php
include 'core/init.php';
require 'core/db.php';
require 'efunction.php';

$query = '';
$output = array();
$query .= "SELECT * FROM inventory ";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE itemID LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR itemType LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY itemID DESC ';
}
if($_POST["length"] != -1)
{
 $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $conn->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
 $bcImgFilename = '';
 if($row["bcImgFilename"] != '')
 {
  $bcImgFilename = '<img src="'.$row["bcImgFilename"].'" class="img-thumbnail" width="50" height="35" />';
 }
 else
 {
  $bcImgFilename = '';
 }
 $sub_array = array();
 $sub_array[] = $bcImgFilename;
 $sub_array[] = $row["itemID"];
 $sub_array[] = $row["itemType"];
 $sub_array[] = $row["itemNotes"];
 $sub_array[] = '<button type="button" name="update" id="'.$row["itemID"].'" class="btn btn-warning btn-xs update">Update</button>';
 $sub_array[] = '<button type="button" name="delete" id="'.$row["itemID"].'" class="btn btn-danger btn-xs delete">Delete</button>';
 $data[] = $sub_array;
}

$output = array(
 "draw"             => intval($_POST["draw"]),
 "recordsTotal"     =>  $filtered_rows,
 "recordsFiltered"  => get_total_all_records(),
 "data"             => $data
);
echo json_encode($output);
?>