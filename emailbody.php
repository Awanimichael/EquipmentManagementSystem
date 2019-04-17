<html>
    <head>
        <style>

        #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
        }

        </style>
    </head>
</html>

<?php
include 'core/init.php';
include 'core/db.php';

// query to find all records that are currently out from iteminout Table.
// $query = "SELECT * FROM `test2` WHERE status= 'OUT' and (equipmentID, staff) NOT IN (SELECT equipmentID, staff FROM test2 where status = 'IN') and DATE(NOW()) - DATE(date) >= 7";
$query = "SELECT DTStamp, fname, phone, equipmentID, equipmentType from (SELECT fname, phone, equipmentID, equipmentType, Max(DTStamp)as DTStamp, status, count(equipmentID) as F FROM `test2` Group By equipmentID) as T where (T.F % 2 <> 0 and DATE(NOW()) - DATE(T.DTStamp) > 6)";
$statement = $conn->prepare($query);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$filtered_rows = $statement->rowCount();

if ($filtered_rows) {
?>
<p>Here are the list of equipments that has been out for more than 7 days:</p>
    <table id="customers">
        <tr >
            <th> Date</th>
            <th>Faculty Name</th>
            <th>Faculty Phone</th>
            <th>EquipmentID</th>
            <th>EquipmentType</th>
        </tr>
    <?php
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <tr>
            <td><?php echo $row['DTStamp']; ?> </td>
            <td><?php echo $row['fname']; ?> </td>
            <td><?php echo $row['phone']; ?> </td>
            <td><?php echo $row['equipmentID']; ?> </td>
            <td><?php echo $row['equipmentType']; ?> </td>
        </tr>
    <?php
    }
    ?>     
    </table>
<?php
}
else {
    echo " There are no Equipment out for more than one week";
}
?>
