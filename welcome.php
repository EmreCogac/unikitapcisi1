<?php

session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";
$param= $_SESSION["username"];
$sql = "SELECT * FROM user where username='$param'";

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Unikitapçısı</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="./welcome.php">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./profile.php">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://memreaktas.blogspot.com/">Geliştirici</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
    
    $sqlBooks1 = 'SELECT* FROM users JOIN books USING(id)';

    $cikti = $mysqli->query($sqlBooks1);

   
    ?>
<div style="margin: 10%;"></div>
    <div class="divs">
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
               
                    
                    
                    
                    <?php
                    if ($cikti -> num_rows > 0)
                    {
                        while($satir = $cikti-> fetch_assoc())
                        {
                            echo ' <div class="col-md-3" style="margin-top: 2rem;">';
                            echo '<h2 class="text-wraped text-center">'.$satir["bookname"].'</h2>';
                            echo '<img class="img-fluid" src="" alt="kitapresmi" />';
                            if($satir["bookprice"]== NULL)
                            {
                                if($satir["exchange"] == 1)
                                {
                                    echo '<p class="text-wraped text-center">değişme isteğinde bulun</p>';
                                }else{
                                    echo '<p class="text-wraped text-center">Hediye isteğinde bulun</p>';
                                }
                            }
                            else{
                                echo '<p class="text-wraped text-center">'.$satir["bookprice"].' TL</p>';
                            } 
                          
                            echo '</div>';
                        }
                    }
                    ?>
                

            </div>
        </div>
    </div>
</body>
</html>