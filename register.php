<?php
// configirasyon sayfasını içeriye aktardığım yer
require_once "config.php";
 
// değişkenleri tanımladığım yer
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // kullanıcı adını aldığımız yer
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // selecti hazırla
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
      
            $stmt->bind_param("s", $param_username);
            
   
            $param_username = trim($_POST["username"]);
            
     
            if($stmt->execute()){
             
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "Bu kullanıcı adı daha önceden alınmış.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Bir şeyler yanlış gitti tekrar deneyin";
            }

            // Close statement
            $stmt->close();
        }
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "Lütfen bir şifre giriniz.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "şifreniz 6 karakterden fazla olmalıdır.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Lütfrn şiftrnizi onaylayın.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "şifre uyumsuz.";
        }
    }
    

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){

            $stmt->bind_param("ss", $param_username, $param_password);
            
  
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            

            if($stmt->execute()){
     
                header("location: login.php");
            } else{
                echo "Bir şeyler yanlış gitti tekrar deneyin";
            }

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
    <title>KAYIT OL</title>
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
        <h2>Kayıt olun</h2>
        <p>Lütfen formu tam doldurun</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Kullanıcı adı</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>şifre</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Şifreyi onayla</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="KYIT OL">
              
            </div>
            <p>Zaten hesabın var mı? <a href="login.php">Giriş yap</a>.</p>
        </form>
    </div>    
    </div>
</body>
</html>