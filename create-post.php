<?php
// sessionu başlatıyorum burada
session_start();
 


 
// configirasyon sayfasını içeriye aktardığım yer
require_once "config.php";
 
 
// form onayundan sonra olacaklar
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 
     $kitapadi = trim($_POST["kitapadi"]);
     $fiyati = trim($_POST["fiyati"]);
     $bilgi = trim($_POST["bilgi"]);

    


    
    // bilgileri sorgıladığım yer

        // sql sorgum 
        $stmt =$mysqli->prepare("INSERT INTO `books`(`id`, `bookname`, `bookprice`, `bookinfo`) VALUES (?,?,?,?)");
        
    
            $stmt -> bind_param ("ssss",$id1,$kitapadi1,$fiyat1,$bilgi1);
            
        

        
                    
                            // şifre doğrulama
                          
                            
                            // verileri aktarıyorum sessiona
                            $id= $_SESSION["id"];
                            $id1 = $id;
                            $kitapadi1 =$kitapadi;
                            $fiyat1 = $fiyati;
                            $bilgi1 = $bilgi;
            
                       
    $stmt->execute();
    $stmt->close();    
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
                <label>kitap adı</label>
                <input type="text" name="kitapadi" class="form-control">
                <span class="invalid-feedback"></span>
            </div>    
            <div class="form-group">
                <label>kitap fiyatı</label>
                <input type="text" name="fiyati" class="form-control">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>kitap özellikleri</label>
                <input type="text" name="bilgi" class="form-control">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="EKLE">
            </div>
            <div class="form-group">
            <a href="profile.php"> geri dön </a>
            </div>
            
        </form>
    </div>
    </div>
</body>
</html>