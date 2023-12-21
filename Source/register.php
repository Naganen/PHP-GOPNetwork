<!DOCTYPE html>
<html lang="tr">

<head>
    <?php include('function.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://bootswatch.com/5/journal/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <title>Gopweet Sosyal Paylaşım Sitesi</title>
</head>

<body data-bs-theme="dark" class="overflow-x-hidden"
    style="background: linear-gradient(90deg, #451952 0%, #E95793 100%);">
    <div class="row align-top g-2 p-3 justify-content-center align-items-center" style="min-height: 100vh;">

        <div data-bs-theme='light'
            class='col-3 p-5 card text-center justify-content-center align-items-center d-none d-md-block'
            style='height: 400px;'>
            <h1 style="color: #E95793 !important;">Gopweet'e</h1>
            <h1> Hoşgeldin!</h1>
            <br>
            <p>Düşüncelerinizi özgürce paylaşın! <br><br>İşte düşüncelerinizi ifade etmek için bir platform.</p>
            <p>Hemen aramıza katılın!</p>
        </div>
        <div class='col col-md-3 p-5 card text-center justify-content-center align-items-center' style='height: 400px;'>
            <?php
            if ($_GET['result'] == 'userExist') {
                echo "<p style='color: red; margin-top: 0;'>Böyle bir kullanıcı bulunmakta!</p>";
            } elseif ($_GET['result'] == 'passNotMatch') {
                echo "<p style='color: red; margin-top: 0;'>Şifreler birbiri ile uyuşmuyor!</p>";
            } elseif ($_GET['result'] == !null && $_GET['result'] == 'specialChar') {
                echo "<p style='font-size: 14px; color: red; margin-top: 0;'>Kullanıcı adın özel karakterler içeremez.</p>";
            } elseif ($_GET['result'] == !null && $_GET['result'] != 'userExist') {
                echo "<p style='font-size: 14px; color: red; margin-top: 0;'>Kullanıcı adının ve şifrenin uzunluğu 5 ile 15 karakter arasında olmalı.</p>";
            } else {
                echo "<p style=' margin-top: 0;'>GOPNetwork'e Kayıt Ol!</p>";
            }

            ?>
            <center>
                <form action='tool_reg.php' method='post'>
                    <input class='form-control' type='text' name='username' id='username' name='username' placeholder='Kullanıcı Adı'><br>
                    <input class='form-control' type='password' name='password' id='password' name='password' placeholder='Şifre'><br>
                    <input class='form-control' type='password' name='passwordr' id='passwordr' name='passwordr'
                        placeholder='Şifre Tekrar'><br>
                    <a href='policy.php' rel='noopener noreferrer'>Kullanıcı Sözleşmesi</a><br>
                    <button style='background-color: #E95793; border: none;' class='btn btn-light m-3' type='submit' id='submit'>Kayıt Ol</button><br>
                    <a href='index.php' rel='noopener noreferrer'>Hesabın Varsa Buraya Tıklayarak Giriş Yap</a><br>
                </form>
            </center>
        </div>
    </div>

</body>

</html>