<?php
    ob_start();
    include "emailbody.php";

    $recipient = 'awanimichael@gmail.com';
    $subject = 'Equipments Current Loaned Out';

    $message = ob_get_flush();

    // To send HTML mail, the content-type header must be set
    $headers = "MIME-Version: 1.0". "\r\n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1" . "\r\n";

    //Additional headers
    $headers .= "From: rotimiawani@gmail.com" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "X-Priority: 1" . "\r\n";
    // $headers .= 'Cc: another@gmail.com' . "\r\n";

    //Mail it
    mail('awanimichael@gmail.com', $subject, $message, $headers);
   
?> 