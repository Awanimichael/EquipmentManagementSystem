
<?php
    // This file stores php classes
    
    include 'config.php';
    include 'classes/PHPMailer.php';
    include 'classes/SMTP.php';
    include 'classes/Exception.php';
    
    date_default_timezone_set('America/Chicago');

    //autoload method
    spl_autoload_register(function($class){
        require_once "classes/{$class}.php";
    });

    // Instantiante Users class. now we can use this class anywhere.
    $userObj    = new Users;
    $verifyObj  = new Verify;
    $itemObj    = new Items;

    //session
    session_start();
?>