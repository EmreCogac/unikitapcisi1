<?php

session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$param= $_SESSION["username"];
$sql = "SELECT * FROM user where username='$param'";
require_once "config.php";
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
  <div class="container">
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

<div style="margin: 10%;"></div>
    <h1 class="my-5">selam, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
    <h1>Kitaplarım</h1>
    <?php
    
    $id_param = $_SESSION["id"];


    $sqlBooks1 = "SELECT * FROM books WHERE id=$id_param";

    $cikti = $mysqli->query($sqlBooks1);

   
    ?>
<div style="margin: 5%;"></div>
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
                               
                                    echo '<p class="text-wraped text-center">değişme isteğinde bulun</p>';
                              
                            }
                            else{
                                echo '<p class="text-wraped text-center">'.$satir["bookprice"].' TL</p>';
                            } 
                            echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>";
                            echo "<div class='form-group'>";
                            echo "<input type='submit' class='btn btn-primary' name='button' value='sil'>";
                            echo "</div>";
                             if(array_key_exists('button',$_POST)){
                              require_once "config.php";
                              $sql = "DELETE FROM `books` WHERE bookid=".$satir["bookid"];
                              if($mysqli->query($sql))
                                {echo $mysqli->affected_rows."kitap silindi";
                                header("location: profile.php");}
                                else
                                 echo"bir şeyler yanlış gitti";
                             }
                            echo '</div>';
                            echo "</form>";
                        }
                    }
                    ?>
                    
                

            </div>
        </div>
    </div>
    <div style="margin: 5%;"></div>
    <p>
       
        <a href="logout.php" class="btn btn-danger ml-3">Hesabınızdan çıkış yapın</a>
        <a href="create-post.php" class="btn btn-danger ml-3">pst oluştur</a>
        <a href="rename.php" class="btn btn-danger ml-3">ad degistir</a>
    </p>
</body>
</html>