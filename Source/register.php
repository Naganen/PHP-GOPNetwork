<!DOCTYPE html>
<html lang="tr">
<head>
    <?php include('function.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css ?>">
    <link rel="shortcut icon" href="favicon.ico" />
    <title>GOPNetwork Sosyal Paylaşım Sitesi</title>
</head>

<body>
    
        <div class='homeInfo'>
            <h1 style="color: #E95793 !important;">GOPNetwork'e</h1><h1> Hoşgeldin!</h1>
            <p>Düşüncelerinizi özgürce paylaşın! <br>İşte düşüncelerinizi ifade etmek için bir platform.</p>
            <p>Hemen aramıza katılın!</p>
        </div>
        <div class='login'>
            <?php
                if ($_GET['result'] == 'userExist') {
                    echo "<p style='color: red; margin-top: 0;'>Böyle bir kullanıcı bulunmakta!</p>";
                } elseif ($_GET['result'] == 'passNotMatch') {
                    echo "<p style='color: red; margin-top: 0;'>Şifreler birbiri ile uyuşmuyor!</p>";
                } elseif ($_GET['result'] == !null && $_GET['result'] != 'userExist') {
                    echo "<p style='font-size: 14px; color: red; margin-top: 0;'>Kullanıcı adının ve şifrenin uzunluğu 5 ile 15 karakter arasında olmalı.</p>";
                } else {
                    echo "<p style=' margin-top: 0;'>GOPNetwork'e Kayıt Ol!</p>";
                }
            
            ?>
            <center><form action='reg.php' method='post' >
                <input type='text' name='username' id='username' name='username' placeholder='Kullanıcı Adı'><br>
                <input type='password' name='password' id='password' name='password' placeholder='Şifre'><br>
                <input type='password' name='passwordr' id='passwordr' name='passwordr' placeholder='Şifre Tekrar'><br>
                <a href='policy.php' rel='noopener noreferrer'>Kullanıcı Sözleşmesi</a><br>
                <br>
                <button type='submit' id='submit'>Kayıt Ol</button><br><br>
                <a href='index.php' rel='noopener noreferrer'>Hesabın Varsa Buraya Tıklayarak Giriş Yap</a><br>
            </form></center>
        </div>
    
</body>
</html>