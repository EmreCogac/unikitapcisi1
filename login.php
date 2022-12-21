<?php
// sessionu başlatıyorum burada
session_start();
 
// eğer kullanıcı zaten giriş yaptıysa onu ana sayfaya yollayan kısım
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// configirasyon sayfasını içeriye aktardığım yer
require_once "config.php";
 
// değişkenleri tanımladığım yer
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// form onayundan sonra olacaklar
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // eğer boş ise
    if(empty(trim($_POST["username"]))){
        $username_err = "KULLANICI ADI BOŞ BIRAKILAMAZ.";
    } else{
        $username = trim($_POST["username"]);
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "ŞİFRE ADI BOŞ BIRAKILAMAZ.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // bilgileri sorgıladığım yer
    if(empty($username_err) && empty($password_err)){
        // sql sorgum 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // bing param ile parametreledim 
            $stmt->bind_param("s", $param_username);
            
            // parametre atadım
            $param_username = $username;
            
            // storeun sonun geldim
            if($stmt->execute()){
                // Store sonuçları
                $stmt->store_result();
                
                // şifre kontrolü
                if($stmt->num_rows == 1){                    
                    // Bind sonuçları
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){ // burada fetchledim
                        if(password_verify($password, $hashed_password)){
                            // şifre doğrulama
                            session_start();
                            
                            // verileri aktarıyorum sessiona
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // ana sayfaya yönlendiriyorum
                            header("location: welcome.php");
                        } else{
                            // erorr
                            $login_err = "Kullanıcı adı veya şifre yanlış.";
                        }
                    }
                } else{

                    $login_err = "Kullanıcı adı veya şifre yanlış.";
                }
            } else{
                echo "Bir şeyler yanlış gitti tekrar deneyin";
            }

            // bağlantıyı kapat
            $stmt->close();
        }
    }
    
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
        <h2>giriş</h2>
    

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Kullanıcı adı</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Şifre</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Giriş">
            </div>
            <p>kayıtlı değil misiniz? <a href="register.php">kaydolun </a>.</p>
        </form>
    </div>
    </div>
</body>
</html>