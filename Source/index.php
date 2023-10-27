<!DOCTYPE html>
<html lang="tr">
<head>
    <?php include('function.php'); ?>
    <meta name="title" content="GOPNetwork Sosyal Paylaşım Sitesi">
    <meta name="description" content="Düşüncelerinizi özgürce paylaşın! İşte düşüncelerinizi ifade etmek için bir platform. Hemen aramıza katılın!">
    <meta name="keywords" content="gop, social, network, gopnetwork, facebook, twitter, gaziosmanpaşa, togü, gop üniversitesi, gaziosmanpaşa üniversitesi, gop.edu.tr">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Turkish">
    <meta name="author" content="Naganen">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css ?>">
    <link rel="shortcut icon" href="favicon.ico" />
    <title>GOPNetwork Sosyal Paylaşım Sitesi</title>
</head>

<body>
    
    <?php 
        $userid = $_COOKIE['login'];
        if ($userid == null) {
                echo "
                <div class='homeInfo'>
                <h1 style='color: #E95793 !important;'>GOPNetwork'e</h1><h1> Hoşgeldin!</h1>
                    <p>Düşüncelerinizi özgürce paylaşın! <br>İşte düşüncelerinizi ifade etmek için bir platform.</p>
                    <p>Hemen aramıza katılın!</p>
                </div>
                <div class='login'>";
                if ($_GET['result'] == 'registerSuccess') {
                echo "<p style='color: green;'>Başarıyla kayıt oldun!</p>";
                } elseif ($_GET['result'] == 'loginFailed') { 
                echo "<p style='color: red;'>Kullanıcı adı ve ya şifre yanlış!</p>";
                } elseif ($_GET['result'] == 'logout') { 
                    echo "<p style='color: green;'>Başarıyla çıkış yaptın!</p>";
                } else {
                echo "<p>Bir GOPNetwork Hesabın Varsa Giriş Yap</p>";
                }
                echo "<center><form action='auth.php' method='post' >
                    <input type='text' name='username' id='username' placeholder='Kullanıcı Adı'><br>
                    <input type='password' name='password' id='password' placeholder='Şifre'><br>
                    <input style='width: 15px; height: 15px; margin: 0; padding: 0;' type='checkbox' name='remember' id='remember'>
                    <label style='margin: 0; padding: 0;' for='remember'>Beni Hatırla</label><br><br>
                    <a href='register.php' rel='noopener noreferrer'>Hesabın Yoksa Buraya Tıklayarak Kayıt Ol</a><br>
                    <br>
                    <button type='submit' id='submit'>Giriş Yap</button>
                </form></center>
                </div>
                ";
        } else {
        Redirect("home.php"); 
        }
    ?>
    


</body>
</html>