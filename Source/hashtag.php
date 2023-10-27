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
        <div style="margin-top: 15px;" class="main">
            <?php
                $hashtag = $_GET['hashtag'];
                echo "<p>#$hashtag Etiketine Sahip Gönderiler</p>";
                $sort = $_GET['sort'];
                echo "<table style='margin-bottom: 10px;'><tr>";
                if ($sort == 'old') {
                    echo "<th class='sort'><a href='hashtag.php?hashtag=$hashtag'>En Yeni</a></th>
                          <th class='sortCurrent'><a href='hashtag.php?sort=old&hashtag=$hashtag'>En Eski</a></th>
                          <th class='sort'><a href='hashtag.php?sort=best&hashtag=$hashtag'>En Beğenilen</a></th>";
                    $sortby = 'id ASC';
                } elseif ($sort == 'best') {
                    echo "<th class='sort'><a href='hashtag.php?hashtag=$hashtag'>En Yeni</a></th>
                          <th class='sort'><a href='hashtag.php?sort=old&hashtag=$hashtag'>En Eski</a></th>
                          <th class='sortCurrent'><a href='hashtag.php?sort=best&hashtag=$hashtag'>En Beğenilen</a></th>";
                    $sortby = 'likes DESC';
                } else {
                    echo "<th class='sortCurrent'><a href='hashtag.php?hashtag=$hashtag'>En Yeni</a></th>
                          <th class='sort'><a href='hashtag.php?sort=old&hashtag=$hashtag'>En Eski</a></th>
                          <th class='sort'><a href='hashtag.php?sort=best&hashtag=$hashtag'>En Beğenilen</a></th>";
                    $sortby = 'id DESC';
                }
                echo "<tr></table>";
                $getposts = "SELECT * FROM `content` WHERE hashtag LIKE '%$hashtag,%' ORDER BY $sortby";
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
                        echo "<a style='color: #E95793;' href='like.php?id={$post['id']}&from=hashtag.php?{$_SERVER['QUERY_STRING']}'><i class='fas fa-heart'></i> ". CheckLikes($post['id'], $con). "</a>".
                        "</p></th>";
                    } else {
                        echo "<a href='like.php?id={$post['id']}&from=hashtag.php?{$_SERVER['QUERY_STRING']}'><i class='fas fa-heart'></i> ". CheckLikes($post['id'], $con). "</a>".
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