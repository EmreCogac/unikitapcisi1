<?php
// logu tutulmuş veri başaltıldı
session_start();
 

$_SESSION = array();
 
// session silindi
session_destroy();
 
// login sayfasına yollandı
header("location: login.php");
exit;
?>