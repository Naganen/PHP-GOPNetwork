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
            <form action='publish.php' method='post' class='publish'>
                <textarea type='text' placeholder='Düşüncelerini aktar...' id='post' name='post' maxlength='250'></textarea><br>
                <button type='submit' id='submit'>Paylaş</button>
            </form>
            <?php
                $sort = $_GET['sort'];
                echo "<table style='margin-bottom: 10px;'><tr>";
                if ($sort == 'old') {
                    echo "<th class='sort'><a href='home.php'>En Yeni</a></th>
                          <th class='sortCurrent'><a href='home.php?sort=old'>En Eski</a></th>
                          <th class='sort'><a href='home.php?sort=best'>En Beğenilen</a></th>";
                    $sortby = 'id ASC';
                } elseif ($sort == 'best') {
                    echo "<th class='sort'><a href='home.php'>En Yeni</a></th>
                          <th class='sort'><a href='home.php?sort=old'>En Eski</a></th>
                          <th class='sortCurrent'><a href='home.php?sort=best'>En Beğenilen</a></th>";
                    $sortby = 'likes DESC';
                } else {
                    echo "<th class='sortCurrent'><a href='home.php'>En Yeni</a></th>
                          <th class='sort'><a href='home.php?sort=old'>En Eski</a></th>
                          <th class='sort'><a href='home.php?sort=best'>En Beğenilen</a></th>";
                    $sortby = 'id DESC';
                }
                echo "<tr></table>";
                $getposts = "SELECT * FROM `content` ORDER BY $sortby";
                $posts = mysqli_query($con, $getposts);
                while($post = mysqli_fetch_array($posts, MYSQLI_ASSOC)) {
                    echo "<div class='post' id='{$post['id']}'>".
                    "<p class='publisher'>@"; 
                    echo (CheckUser($userid, $con)['censorswear']) ? CensorSwear(CheckPublisher($post, $con)) : CheckPublisher($post, $con);
                    echo "</p>";
                    echo (CheckUser($userid, $con)['censorswear']) ? ShowHashtag(CensorSwear($post['post'])) : ShowHashtag($post['post']);
                    echo "<br><br>".
                    "<table style='width: 100%;'><tr>".
                    "<th><p class='postInfo'>";
                    $likers = explode(",",CheckLikers($post['id'], $con));
                    if (in_array(CheckUser($userid, $con)['id'], $likers)) {
                        echo "<a style='color: #E95793;' href='like.php?id={$post['id']}&sort={$_GET['sort']}'><i class='fas fa-heart'></i> ". CheckLikes($post['id'], $con). "</a>".
                        "</p></th>";
                    } else {
                        echo "<a href='like.php?id={$post['id']}&sort={$_GET['sort']}'><i class='fas fa-heart'></i> ". CheckLikes($post['id'], $con). "</a>".
                        "</p></th>";
                    }
                    if (IsModerator($userid, $con) or CheckUser($userid, $con)['usertoken'] == $post['publisher']) {
                        echo "<th><p class='deletePost'><a href='delete.php?id={$post['id']}'><i class='fas fa-trash'></i></a></p></th>";
                    }
                    echo "</tr></table></div>";
                }
            ?>
        </div>
    </div>
</body>
</html>