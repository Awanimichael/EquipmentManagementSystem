<link rel="stylesheet" href="assets/css/form.css">

<?php
include 'facultyd.php'
?>

<div class="body content">
    <div class="welcome">
        <span class="user"> <?
            if (!$stmt->rowCount() == 0){
                while ($row = $stmt->fetch()){
                    // echo "$row[department]";
                    echo "<img src='$row[bcImgFilename]'>";?></span><br />
                    <span class="user"> <? echo "$row[facName]";
                 }
            }
            else {
                echo 'Searched Faculty Not Registered<br />';
            }
            ?></span>

        <div id="registered">
            <!--Display all Registered Faculty information-->
            <?php
            require 'core/db.php';
            $sql= 'SELECT facName, department, bcImgFilename FROM faculty ';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data =$stmt->fetchAll(PDO::FETCH_OBJ);
            ?>
            <span style="color:#19547c; font-size:25px;"> All registered Facluty</span>
            <?php
            foreach ($data as $dat):
                echo "<div class='userlist'><span>$dat->facName</span><br />";
                echo "<span>$dat->department</span>"; 
                echo "<img src='$dat->bcImgFilename'></div>"; 
            endforeach;?>
        </div> 
        
    </div>
</div>



