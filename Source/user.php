<!DOCTYPE html>
<html lang="tr">

<head>
    <?php
    include('function.php');

    $userid = $_COOKIE['login'];
    $logined = CheckUser($_COOKIE['login'], $con);

    if ($userid == null) {
        Redirect("index.php");
    }

    $postcount = 10;

    if ($_GET['p'] != null) {
        $postcount = $_GET['p'] * 10;
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2a63621396.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    -->
    <link rel="stylesheet" href="https://bootswatch.com/5/journal/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon.ico" />
    <title>Gopweet Sosyal Paylaşım Sitesi</title>
</head>

<body data-bs-theme="dark" class="overflow-x-hidden" id="body">
    <style>
        .btn-danger {
            background-color: #E95793 !important;
        }
    </style>
    <script>
        document.getElementById("body").style.display = "none";

        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("body").style.display = "block";
        });
    </script>
    <div class="d-flex border-top border-secondary fixed-bottom bg-dark d-md-none p-3 pb-4" id="bottomMenu">
        <button class="btn flex-fill" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                onerror='this.onerror=null; this.src="pp.jpg";' class="rounded-circle" width="26px"
                src="<?php echo $logined['profilepic']; ?>" />
        </button>
        <ul class="dropdown-menu dropdown-menu-end col-2">
            <li><a class='dropdown-item' href="@<?php echo $logined['username']; ?>"><i class="fas fa-user"></i>
                    Profiline Git</a></li>
            <li><a class='dropdown-item' href='tool_logout.php'><i class="fas fa-sign-out-alt"></i> Çıkış
                    Yap</a></li>
        </ul>
        <a class="flex-fill btn btn-dark" href="following.php" rel="noopener noreferrer"><i
                class="fa-solid fa-user-group"></i></a>
        <a class="flex-fill btn" href="home.php" rel="noopener noreferrer"><i class="fa-solid fa-house"></i></a>
        <a class="flex-fill btn btn-dark disabled" href="home.php" rel="noopener noreferrer"><i
                class="fa-solid fa-magnifying-glass"></i></a>
        <a class="flex-fill btn btn-dark disabled" href="home.php" rel="noopener noreferrer"><i
                class="fa-solid fa-message"></i></a>

    </div>


    <div class="modal fade" id="settings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ayarlar</h1>
                </div>
                <div class="modal-body">
                    <h4>Profil Resmini Değiştir</h4>
                    <p>Buradan profil resmini değiştirebilirsin!</p>
                    <form action='tool_setpp.php' method='post'>
                        <input class="form-control" type='text' name='avatar' id='avatar' name='avatar'
                            placeholder='Resim ve ya Fotoğraf Linki' value='<?php echo $logined['profilepic'] ?>'><br>
                        <button class="btn btn-light" style="width: 200px; !important" type='submit'
                            id='submit'>Değiştir</button>
                    </form>
                    <br>
                    <h4>Profil Açıklamanı Değiştir</h4>
                    <p>Buradan profil açıklamanı değiştirebilirsin!</p>
                    <form action='tool_setpd.php' method='post'>
                        <textarea class="form-control" type='text' name='desc' id='desc' name='desc'
                            placeholder='Profil Açıklamanı Gir'
                            rows="4"><?php echo $logined['userdesc'] ?></textarea><br>
                        <button class="btn btn-light" style="width: 200px; !important" type='submit'
                            id='submit'>Değiştir</button>
                    </form>
                    <br>
                    <h4>Şifre Değiştir</h4>
                    <p>Buradan hesabının şifresini değiştirebilirsin!</p>
                    <form action='tool_set.php' method='post'>
                        <input class="form-control" type='password' name='curPassword' id='curPassword'
                            name='curPassword' placeholder='Eski Şifren'><br>
                        <input class="form-control" type='password' name='newPassword' id='newPassword'
                            name='newPassword' placeholder='Yeni Şifren'><br>
                        <input class="form-control" type='password' name='newPasswordR' id='newPasswordR'
                            name='newPasswordR' placeholder='Yeni Şifreni Tekrar Et'><br>
                        <button class="btn btn-light" style="width: 200px; !important" type='submit'
                            id='submit'>Değiştir</button>
                    </form>
                    <br>
                    <h4>Kötü Söz Filtresi</h4>
                    <p">Bu seçenek aktif iken sitedeki kötü sözler *** olarak
                        sansürlenecektir.</p>
                        <a class="btn btn-light" href="tool_disableswear.php">
                            <?php
                            if (CheckUser($userid, $con)['censorswear']) {
                                echo "Filtreyi Kapat";
                            } else {
                                echo "Filtreyi Aç";
                            }
                            ?>
                        </a>
                        <br>
                        <button type="button" class="btn btn-light float-end" data-bs-dismiss="modal">Kapat</button>
                </div>

            </div>
        </div>
    </div>


    <div class="row align-top g-2 p-3" style="min-height: 100vh;">
        <div class="col text-start justify-content-start align-items-start d-none d-md-block">
            <div class="position-fixed top-0 start-0 mt-3 ms-3 d-grid col-2">
                <h1 class="logo">Gopweet</h1>
                <a class="text-decoration-none btn btn-dark text-start" style="font-size: 18px;" href="home.php"
                    rel="noopener noreferrer"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
                <a class="text-decoration-none btn btn-dark text-start" style="font-size: 18px;" href="following.php"
                    rel="noopener noreferrer"><i class="fa-solid fa-user-group"></i> Takip
                    Edilenler</a>
                <a class="text-decoration-none btn btn-dark text-start disabled" style="font-size: 18px;"
                    href="home.php" rel="noopener noreferrer"><i class="fa-solid fa-magnifying-glass"></i> Ara</a>
                <a class="text-decoration-none btn btn-dark text-start disabled" style="font-size: 18px;"
                    href="home.php" rel="noopener noreferrer"><i class="fa-solid fa-message"></i> Mesajlar</a>
            </div>
            <button class="btn btn-dark position-fixed start-0 bottom-0 mb-3 ms-3 col-2 text-start"
                style="font-size: 22px;" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                    onerror='this.onerror=null; this.src="pp.jpg";' class="rounded-circle" width="32px"
                    src="<?php echo $logined['profilepic']; ?>" /> <span style="font-size: 20px; height: 32px;">
                    <?php echo "@" . $logined['username']; ?>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end col-2">
                <li><a class='dropdown-item' href="@<?php echo $logined['username']; ?>"><i class="fas fa-user"></i>
                        Profiline Git</a></li>
                <li><a class='dropdown-item' href='tool_logout.php'><i class="fas fa-sign-out-alt"></i> Çıkış
                        Yap</a></li>
            </ul>
        </div>
        <div class="col col-md-4 text-center justify-content-center align-items-center pb-5"
            style="padding-bottom: 100px;">
            <h1 class="d-block d-md-none">Gopweet</h1>
            <?php
            $profile = $_GET['u'];
            $publisher = CheckUsername($profile, $con)['usertoken'];
            $pcount_sql = "SELECT COUNT(*) FROM `content` WHERE publisher = '$publisher'";
            $pcount = mysqli_fetch_assoc(mysqli_query($con, $pcount_sql));
            $plikes_sql = "SELECT SUM(likes) FROM `content` WHERE publisher = '$publisher'";
            $plikes = mysqli_fetch_assoc(mysqli_query($con, $plikes_sql));
            $pfollowers = CheckFollowers($publisher);
            if ($pfollowers < 1000000) {
                $pfollowers = number_format($pfollowers);
            } else if ($pfollowers < 1000000000) {
                $pfollowers = number_format($pfollowers / 1000000, 2) . 'M';
            } else {
                $pfollowers = number_format($pfollowers / 1000000000, 2) . 'B';
            }

            if ($plikes['SUM(likes)'] < 1000000) {
                $plikes['SUM(likes)'] = number_format($plikes['SUM(likes)']);
            } else if ($plikes['SUM(likes)'] < 1000000000) {
                $plikes['SUM(likes)'] = number_format($plikes['SUM(likes)'] / 1000000, 2) . 'M';
            } else {
                $plikes['SUM(likes)'] = number_format($plikes['SUM(likes)'] / 1000000000, 2) . 'B';
            }

            if ($pcount['COUNT(*)'] < 1000000) {
                $pcount['COUNT(*)'] = number_format($pcount['COUNT(*)']);
            } else if ($pcount['COUNT(*)'] < 1000000000) {
                $pcount['COUNT(*)'] = number_format($pcount['COUNT(*)'] / 1000000, 2) . 'M';
            } else {
                $pcount['COUNT(*)'] = number_format($pcount['COUNT(*)'] / 1000000000, 2) . 'B';
            }

            if ($publisher == $_COOKIE['login']) {
                echo "<a title='Ayarlar' data-bs-toggle='modal' data-bs-target='#settings' class='btn btn-dark float-end'><i
                    class='fa-solid fa-gear'></i></a><br><br>";
            }
            if (CheckUser($publisher, $con)['profilepic'] != null) {
                echo "<img onerror='this.onerror=null; this.src=\"pp.jpg\";' tite='Kullanıcının Profil Resmi' class='rounded-circle m-3' width='128px' height='128px' src='" . CheckUser($publisher, $con)['profilepic'] . "'/>";
            }
            echo "<h2>@$profile";
            if (CheckUser($publisher, $con)['confirmed'] == 1) {
                echo " <i title='Doğrulanmış Hesap' style='color: #E95793; font-size: 19px;' class='fa-regular fa-circle-check'></i>";
            }
            echo "</h2><p>" . CheckUser($publisher, $con)['userdesc'] . "</p>";
            echo "<p class='d-flex justify-content-around'> <span><i class='fa-solid fa-message'></i> " . $pcount['COUNT(*)'] . " Gönderi</span>";
            echo "<span><i class='fa-solid fa-user-group'></i> " . $pfollowers . " Takipçi</span>" .
                "</p>";

            if ($publisher != $userid) {
                if (CheckFollowing($userid, $publisher)) {
                    echo "<a class='btn btn-dark w-50' href='tool_follow.php?who={$publisher}&from=@$profile'>Takipten Çık</a>";
                } else {
                    echo "<a style='background-color: #E95793;' class='btn btn-dark w-50' href='tool_follow.php?who={$publisher}&from=@$profile'>Takip Et</a>";
                }
            }
            ?>
            <br>

            <button class="btn btn-dark dropdown-toggle float-end" type="button" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fa-solid fa-arrow-down-wide-short"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php
                $sort = $_GET['sort'];
                if ($sort == 'old') {
                    echo "<li><a class='dropdown-item' href='@$profile'>En Yeni</a></li>
                            <a class='dropdown-item text-dark bg-light' href='@$profile?sort=old'>En Eski</a></li>
                            <a class='dropdown-item' href='@$profile?sort=best'>En Beğenilen</a></li>";
                    $sortby = 'id ASC';
                } elseif ($sort == 'best') {
                    echo "<li><a class='dropdown-item' href='@$profile'>En Yeni</a></li>
                            <a class='dropdown-item' href='@$profile?sort=old'>En Eski</a></li>
                            <a class='dropdown-item text-dark bg-light' href='@$profile?sort=best'>En Beğenilen</a></li>";
                    $sortby = 'likes DESC';
                } else {
                    echo "<li><a class='dropdown-item text-dark bg-light' href='@$profile'>En Yeni</a></li>
                            <a class='dropdown-item' href='@$profile?sort=old'>En Eski</a></li>
                            <a class='dropdown-item' href='@$profile?sort=best'>En Beğenilen</a></li>";
                    $sortby = 'id DESC';
                }
                ?>
            </ul>
            <br>
            <?php


            echo "<div id='postArea'>";
            $getposts = "SELECT * FROM `content` WHERE publisher = '$publisher' ORDER BY $sortby";
            $posts = mysqli_query($con, $getposts);
            while ($post = mysqli_fetch_array($posts, MYSQLI_ASSOC)) {
                PostHTML($post, $logined, $userid);
            }
            echo "</div>";
            ?>

            <br>
            <br>
        </div>
        <div class="col text-end justify-content-end align-items-end d-none d-md-block">
        </div>
    </div>
    <script src="scripts.js?v=4_2"></script>
</body>

</html>