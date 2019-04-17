<?php
    include "qrlib.php";
    QRcode::png($_POST['text'], false, 'h', 6, 2, true, 0x000000, 0xFFFFFF); // creates code image and outputs it in the browser 
?>

