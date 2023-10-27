<!DOCTYPE html>
<html lang="tr">
<head>
    <?php include('function.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="<?php echo $css ?>">
    <link rel="shortcut icon" href="favicon.ico" />
    <title>GOPNetwork Sosyal Paylaşım Sitesi</title>
</head>
<body class="homeBody">
    <div class="container">
        <div class="sidePanel">
            <h1 class="logo">GOPNetwork</h1>
                <?php 
                $userid = $_COOKIE['login'];
                echo "<h2>Hoşgeldin ";
                echo CheckUser($userid, $con)['username'];
                echo "</h2>";
                ?>
                <div class="panelMenu">
                    <a href="home.php" rel="noopener noreferrer"><i class="far fa-compass"></i> Keşfet</a>
                    <a href="settings.php" rel="noopener noreferrer"><i class="fas fa-wrench"></i> Ayarlar</a>
                    <a href="logout.php" rel="noopener noreferrer"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
                </div>
        </div>

        <div class="bottomPanel">
                <div class="botPanelMenu">
                    <a href="settings.php" rel="noopener noreferrer"><i class="fas fa-wrench"></i></a>
                    <a href="home.php" rel="noopener noreferrer"><i class="far fa-compass"></i></a>
                    <a href="logout.php" rel="noopener noreferrer"><i class="fas fa-sign-out-alt"></i></a>
                </div>
        </div>
                <h1 class='mobileLogo'>GOPNetwork</h1>
        <div class="main">
            <br><h1>Şifre Değiştir</h1>
            <?php
                if ($_GET['result'] == 'passWrong') {
                    echo "<p style='color: yellow;'>Şifreni yanlış girdin!</p>";
                } elseif ($_GET['result'] == 'passNotMatch') {
                    echo "<p style='color: yellow;'>Şifreler birbiri ile uyuşmuyor!</p>";
                } elseif ($_GET['result'] == 'passLong') {
                    echo "<p style='color: yellow;'>Şifren çok uzun!</p>";
                } elseif ($_GET['result'] == 'passShort') {
                    echo "<p style='color: yellow;'>Şifren çok kısa!</p>";
                } elseif ($_GET['result'] == 'changeSuccess') {
                    echo "<p style='color: green;'>Şifren başarıyla değiştirildi!</p>";
                } else {
                    echo "<p>Buradan hesabının şifresini değiştirebilirsin!</p>";
                }
            ?>
            <br>
            <form action='set.php' method='post' >
                <input type='password' name='curPassword' id='curPassword' name='curPassword' placeholder='Eski Şifren'><br>
                <input type='password' name='newPassword' id='newPassword' name='newPassword' placeholder='Yeni Şifren'><br>
                <input type='password' name='newPasswordR' id='newPasswordR' name='newPasswordR' placeholder='Yeni Şifreni Tekrar Et'><br>
                <button style="width: 200px; !important" type='submit' id='submit'>Şifremi Değiştir</button>
            </form>
            <br><h1>Kötü Söz Filtresi</h1>
            <p style="max-width: 80% !important;">Bu seçenek aktif iken sitedeki kötü sözler *** olarak sansürlenecektir.</p>
            <a class="sortCurrent" href="disableswear.php">
                <?php
                    if (CheckUser($userid, $con)['censorswear']) {
                        echo "Filtreyi Kapat";
                    } else {
                        echo "Filtreyi Aç";
                    }
                ?>
            </a>
        </div>
    </div>
</body>
</html>