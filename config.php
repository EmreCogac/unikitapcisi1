<?php
/* database tanımlamalarını yaptığım yer*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'unikitapcisi');
 
/* mysqli ile bağladığım yer */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);



// bağlantıyı kontrol ettiğim yer
if($mysqli === false){
    die("ERROR: BAĞLANTI SAĞLANAMADI. " . $mysqli->connect_error);
}
?>