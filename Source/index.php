<!DOCTYPE html>
<html lang="tr">

<head>
    <?php include('function.php'); ?>
    <meta name="title" content="Gopweet Sosyal Paylaşım Sitesi">
    <meta name="description"
        content="Düşüncelerinizi özgürce paylaşın! İşte düşüncelerinizi ifade etmek için bir platform. Hemen aramıza katılın!">
    <meta name="keywords"
        content="gop, social, network, gopweet, facebook, twitter, gaziosmanpaşa, togü, gop üniversitesi, gaziosmanpaşa üniversitesi, gop.edu.tr">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Turkish">
    <meta name="author" content="Naganen">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2a63621396.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/5/journal/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon.ico" />
    <title>Gopweet Sosyal Paylaşım Sitesi</title>
</head>
<body data-bs-theme="dark" class="overflow-x-hidden" style="background: linear-gradient(90deg, #451952 0%, #E95793 100%);">
    <div class="row align-top g-2 p-3 justify-content-center align-items-center" style="min-height: 100vh;">
        <?php
        $userid = $_COOKIE['login'];
        if ($userid == null) {
            echo "
                <div data-bs-theme='light' class='col-3 p-5 card text-center justify-content-center align-items-center d-none d-md-block' style='height: 400px;'>
                <h1 style='color: #E95793 !important;'>Gopweet'e</h1><h1> Hoşgeldin!</h1><br>
                    <p>Düşüncelerinizi özgürce paylaşın! <br><br>İşte düşüncelerinizi ifade etmek için bir platform.</p>
                    <p>Hemen aramıza katılın!</p>
                </div>
                <div class='col col-md-3 p-5 card text-center justify-content-center align-items-center' style='height: 400px;'>";
            if ($_GET['result'] == 'registerSuccess') {
                echo "<p style='color: green;'>Başarıyla kayıt oldun!</p>";
            } elseif ($_GET['result'] == 'loginFailed') {
                echo "<p style='color: red;'>Kullanıcı adı ve ya şifre yanlış!</p>";
            } elseif ($_GET['result'] == 'logout') {
                echo "<p style='color: green;'>Başarıyla çıkış yaptın!</p>";
            } else {
                echo "<p>Bir Gopweet Hesabın Varsa Giriş Yap</p>";
            }
            echo "<center><form action='tool_auth.php' method='post' >
                    <input class='form-control' type='text' name='username' id='username' placeholder='Kullanıcı Adı'><br>
                    <input class='form-control' type='password' name='password' id='password' placeholder='Şifre'><br>
                    <div class='input-group'>
                        <div class='input-group-text'>
                            <input class='form-check-input mt-0' type='checkbox' name='remember' id='remember'>
                        </div>
                        <label class='form-control' for='remember'>Beni Hatırla</label>
                    </div><br>
                    <a class='text-decoration-none' href='register.php' rel='noopener noreferrer'>Hesabın Yoksa Buraya Tıklayarak Kayıt Ol</a><br>
                    <br>
                    <button style='background-color: #E95793; border: none;' class='btn btn-light' type='submit' id='submit'>Giriş Yap</button>
                </form></center>
                </div>
                ";
        } else {
            Redirect("./home.php");
        }
        ?>



</body>

</html>