<?php
// sessionu başlatıyorum burada
session_start();
 


 
// configirasyon sayfasını içeriye aktardığım yer
require_once "config.php";
 
 
// form onayundan sonra olacaklar
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 
     $adi = trim($_POST["kitapadi"]);

     $id= $_SESSION["id"];

        // sql sorgum 
    $sql =$mysqli->prepare("UPDATE users SET username= $adi WHERE id= $id");
        
    
    $sql->execute();
            
  
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GİRİŞ YAP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 25%; padding: 20px; }
        .divs{display: flex; justify-content: center ; align-items: center;}
    </style>
</head>
<body>
    <div class="container-fluid divs">
    <div class="wrapper">

    <div style="margin: 100px;"></div>
        <h2>oluştur</h2>
    

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>adı degis</label>
                <input type="text" name="kitapadi" class="form-control">
                <span class="invalid-feedback"></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="degistir">
            </div>
            <div class="form-group">
            <a href="profile.php"> geri dön </a>
            </div>
            
        </form>
    </div>
    </div>
</body>
</html>