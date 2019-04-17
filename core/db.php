<?php
    $dsn = 'mysql:host='.DB_HOST.'; dbname='.DB_NAME.'';
    $username = 'root';
    $password = '';
    try {
        $conn = new PDO($dsn, $username,$password);
    }
    
    catch (PDOException $e){
        echo $e->getMessage();
            
    }
?>