<?php
$servername = "localhost";
$username = "gopweett_naganen";
$password = "11894730294Ay#";
$dbname = "gopweett_db";
$con = mysqli_connect($servername, $username, $password, $dbname);

function Redirect($url)
{
    echo "<script type='text/javascript'>window.top.location='" . $url . "';</script>";
    exit;
}

function CheckUser($token, $con)
{
    $chkusr_sql = "SELECT * FROM `users` WHERE usertoken = '$token'";
    $chkusr_result = mysqli_query($con, $chkusr_sql);
    return mysqli_fetch_array($chkusr_result, MYSQLI_ASSOC);
}

function CheckUserID($id, $con)
{
    $chkusr_sql = "SELECT * FROM `users` WHERE id = '$id'";
    $chkusr_result = mysqli_query($con, $chkusr_sql);
    return mysqli_fetch_array($chkusr_result, MYSQLI_ASSOC);
}

function CheckUsername($username, $con)
{
    $chkusr_sql = "SELECT * FROM `users` WHERE username = '$username'";
    $chkusr_result = mysqli_query($con, $chkusr_sql);
    return mysqli_fetch_array($chkusr_result, MYSQLI_ASSOC);
}

function CheckPublisher($post, $con)
{
    $chkpblshr_sql = "SELECT * FROM `users` WHERE usertoken = '{$post['publisher']}'";
    $chkpblshr_result = mysqli_query($con, $chkpblshr_sql);
    $publisher = mysqli_fetch_array($chkpblshr_result, MYSQLI_ASSOC);
    return $publisher['username'];
}

function CheckLikes($postid, $con)
{
    $chklikes_sql = "SELECT * FROM `content` WHERE id = $postid";
    $chklikes_result = mysqli_query($con, $chklikes_sql);
    $likes = mysqli_fetch_array($chklikes_result, MYSQLI_ASSOC);
    return $likes['likes'];
}

function CheckLikers($postid, $con)
{
    $chklikes_sql = "SELECT * FROM `content` WHERE id = $postid";
    $chklikes_result = mysqli_query($con, $chklikes_sql);
    $likes = mysqli_fetch_array($chklikes_result, MYSQLI_ASSOC);
    return $likes['likedusers'];
}

function CheckSeen($postid, $con)
{
    $chkseen_sql = "SELECT * FROM `content` WHERE id = $postid";
    $chkseen_result = mysqli_query($con, $chkseen_sql);
    $seen = mysqli_fetch_array($chkseen_result, MYSQLI_ASSOC);
    return $seen['seenusers'];
}

function IsModerator($userid, $con)
{
    $ismod_sql = "SELECT * FROM `users` WHERE usertoken = '$userid'";
    $ismod_result = mysqli_query($con, $ismod_sql);
    $ismod = mysqli_fetch_array($ismod_result, MYSQLI_ASSOC);
    return $ismod['moderator'];
}

function CensorSwear($input)
{
    $swearfile = fopen("swears.txt", "r") or die("Unable to open file!");
    $swearstr = fread($swearfile, filesize("swears.txt"));
    $swears = array_map('trim', explode(",", $swearstr));
    fclose($swearfile);

    $post = explode(" ", $input);
    $postcensored_arr = $post;

    for ($i = 0; $i < count($post); $i++) {
        if (in_array(mb_strtolower($post[$i]), $swears)) {
            $postcensored_arr[$i] = '***';
        }
    }
    return implode(" ", $postcensored_arr);
}

function ShowHashtag($input)
{

    $post = array_map('trim', explode(" ", $input));
    $posthashed = $post;

    for ($i = 0; $i < count($post); $i++) {
        if (substr($post[$i], 0, 1) == "#") {
            $tag = ltrim($post[$i], "#");
            $posthashed[$i] = "<a href='hashtag.php?hashtag=$tag'>$post[$i]</a>";
        }
    }
    return implode(" ", $posthashed);
}

function CheckHashtag($input)
{
    $post = array_map('trim', explode(" ", $input));
    $hashes = $post;

    for ($i = 0; $i < count($post); $i++) {
        if (substr($post[$i], 0, 1) == "#") {
            $tag = ltrim($post[$i], "#");
            $hashes[$i] = "$tag";
        } else {
            $hashes[$i] = null;
        }
    }
    $hashes = array_filter($hashes);
    array_push($hashes, ',');
    return implode(",", $hashes);
}

function bbc2html($content)
{
    $search = array(
        '/(\[img\])(.*?)(\[\/img\])/'
    );

    $replace = array(
        '<img onerror="this.onerror=null; this.src=\'pp.jpg\';" class="rounded" src="$2" width="100%"/>'
    );

    return preg_replace($search, $replace, $content);
}

function GetAd()
{
    global $con;
    $getad_sql = "SELECT * FROM `ads` ORDER BY RAND() LIMIT 1";
    $getad_result = mysqli_query($con, $getad_sql);
    $ad_fetch = mysqli_fetch_array($getad_result, MYSQLI_ASSOC);
    $ad = $ad_fetch;
    return $ad;
}

function CheckFollowing($user, $who)
{
    global $con;
    $whoid = CheckUser($who, $con)['id'];
    $followers = explode(",", CheckUser($user, $con)['following']);
    return in_array($whoid, $followers);
}

function CheckFollowers($user)
{
    global $con;
    return count(array_filter(explode(",", CheckUser($user, $con)['followers'])));
}

function PurpTick($user)
{
    global $con;
    return CheckUser($user, $con)['confirmed'];
}

function PostHTML($post, $logined, $userid)
{
    global $con;
    $likers = array_filter(explode(",", $post["likedusers"]));
    $likecount = count($likers);

    $censor = $logined['censorswear'];


    if ($post['related'] == 0) {
        echo "<div class='card mt-3 p-3'><p class='text-start'>" .
            "<a class='btn btn-dark' href='@" . CheckUser($post['publisher'], $con)['username'] . "'>" .
            "<img onerror='this.onerror=null; this.src=\"pp.jpg\";' tite='Kullanıcının Profil Resmi' class='rounded-circle' width='32px' height='32px' src='" . CheckUser($post['publisher'], $con)['profilepic'] . "'/>" .
            "<span class='m-3'>";
        echo ($censor) ? "@" . CensorSwear(htmlspecialchars(CheckPublisher($post, $con))) : "<span class='m-3'>@" . htmlspecialchars(CheckPublisher($post, $con));
        if (PurpTick($post['publisher'])) {
            echo " <i title='Doğrulanmış Hesap' style='color: #E95793; font-size: 11px;' class='fa-regular fa-circle-check'></i>";
        }
        echo "</span></a>";

        if ($post['publisher'] != $userid) {
            if (CheckFollowing($userid, $post['publisher'])) {
                echo "<a class='btn btn-dark float-end' href='tool_follow.php?who={$post['publisher']}&from=home.php&post={$post['id']}&sort={$_GET['sort']}'><i class='fa-solid fa-xmark'></i></a>";
            } else {
                echo "<a style='background-color: #E95793;' class='btn btn-dark float-end' href='tool_follow.php?who={$post['publisher']}&from=home.php&post={$post['id']}&sort={$_GET['sort']}'><i class='fa-solid fa-plus'></i></a>";
            }
        }

        echo "</p><p class='ms-4 me-4 text-start'>";
        echo ($censor) ? ShowHashtag(CensorSwear($post['post'])) : ShowHashtag($post['post']);
        echo "</p><br><br>" .
            "<p class='text-start m-0'>";

        echo "<a onclick='LikeButton(\"{$userid}\",{$post['id']})' class='btn ";

        if (in_array(CheckUser($userid, $con)['id'], $likers)) {
            echo "btn-danger'";
        } else {
            echo "btn-dark'";
        }
        echo "id='likebutton-{$post['id']}'><i class='fa-solid fa-heart text-light'></i>
        <span id='likecount-{$post['id']}'>{$likecount}</span></a>";

        echo "<a title='Yorumlar' href='post.php?post={$post['id']}' class='btn btn-dark'><i class='fa-solid fa-comment-dots'></i></a>";
        //echo "<span title='Görüntüleme Sayısı' class='btn'><i class='fa-solid fa-eye'></i> " . $seenusers . "</span>";
        if (IsModerator($userid, $con) or $logined['usertoken'] == $post['publisher']) {
            echo "<a title='Gönderiyi Sil' class='text-decoration-none btn btn-dark float-end' href='tool_delete.php?id={$post['id']}'><i class='fas fa-trash'></i></a>";
        }
        echo "</p></div>";
    } else {
        $related = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `content` WHERE id = {$post['related']}"), MYSQLI_ASSOC);

        // RelatedPost

        echo "<div class='card mt-3 p-3' id='{$post['id']}' data-id='{$post['id']}'>";
        if ($related != null) {
            echo "<div class='card mb-3 p-3 bg-dark' style='cursor: pointer;' onclick='location.href=\"post.php?post={$related['id']}\"'>";
            echo "<p class='text-start'>";
            echo "<a class='btn btn-dark' href='@" . CheckUser($related['publisher'], $con)['username'] . "'>";
            if (CheckUser($related['publisher'], $con)['profilepic'] != null) {
                echo "<img onerror='this.onerror=null; this.src=\"pp.jpg\";' tite='Kullanıcının Profil Resmi' class='rounded-circle' width='32px' height='32px' src='" . CheckUser($related['publisher'], $con)['profilepic'] . "'/>";
            }
            echo ($censor) ? "<span class='m-3'>@" . CensorSwear(htmlspecialchars(CheckPublisher($related, $con))) : "<span class='m-3'>@" . htmlspecialchars(CheckPublisher($related, $con));
            if (CheckUser($related['publisher'], $con)['confirmed'] == 1) {
                echo " <i title='Doğrulanmış Hesap' style='color: #E95793; font-size: 11px;' class='fa-regular fa-circle-check'></i>";
            }
            echo "</span></a>";

            if ($related['publisher'] != $userid) {
                if (CheckFollowing($userid, $related['publisher'])) {
                    echo "<a class='btn btn-dark float-end' href='tool_follow.php?who={$related['publisher']}&from=home.php&post={$related['id']}&sort={$_GET['sort']}'><i class='fa-solid fa-xmark'></i></a>";
                } else {
                    echo "<a style='background-color: #E95793;' class='btn btn-dark float-end' href='tool_follow.php?who={$related['publisher']}&from=home.php&post={$related['id']}&sort={$_GET['sort']}'><i class='fa-solid fa-plus'></i></a>";
                }
            }

            echo "</p><p class='ms-4 me-4 text-start'>";
            echo ($censor) ? ShowHashtag(CensorSwear($related['post'])) : ShowHashtag($related['post']);
            echo "</p></div>";
        } else {
            echo "<div class='card mb-3 p-3 bg-dark'";
            echo "<p class='text-start'>Gönderi Bulunamadı";
            echo "</p></div>";
        }

        // CommentPost


        echo "<p class='text-start'>";
        echo "<a class='btn btn-dark' href='@" . CheckUser($post['publisher'], $con)['username'] . "'>";
        if (CheckUser($post['publisher'], $con)['profilepic'] != null) {
            echo "<img onerror='this.onerror=null; this.src=\"pp.jpg\";' tite='Kullanıcının Profil Resmi' class='rounded-circle' width='32px' height='32px' src='" . CheckUser($post['publisher'], $con)['profilepic'] . "'/>";
        }
        echo ($censor) ? "<span class='m-3'>@" . CensorSwear(htmlspecialchars(CheckPublisher($post, $con))) : "<span class='m-3'>@" . htmlspecialchars(CheckPublisher($post, $con));
        if (CheckUser($post['publisher'], $con)['confirmed'] == 1) {
            echo " <i title='Doğrulanmış Hesap' style='color: #E95793; font-size: 11px;' class='fa-regular fa-circle-check'></i>";
        }
        echo "</span></a>";

        if ($post['publisher'] != $userid) {
            if (CheckFollowing($userid, $post['publisher'])) {
                echo "<a class='btn btn-dark float-end' href='tool_follow.php?who={$post['publisher']}&from=home.php&post={$post['id']}&sort={$_GET['sort']}'><i class='fa-solid fa-xmark'></i></a>";
            } else {
                echo "<a style='background-color: #E95793;' class='btn btn-dark float-end' href='tool_follow.php?who={$post['publisher']}&from=home.php&post={$post['id']}&sort={$_GET['sort']}'><i class='fa-solid fa-plus'></i></a>";
            }
        }

        echo "</p><p class='ms-4 me-4 text-start'>";
        echo ($censor) ? ShowHashtag(CensorSwear($post['post'])) : ShowHashtag($post['post']);

        echo "</p><br><br>" .
            "<p class='text-start m-0'>";

        echo "<a onclick='LikeButton(\"{$userid}\",{$post['id']})' class='btn ";

        if (in_array(CheckUser($userid, $con)['id'], $likers)) {
            echo "btn-danger'";
        } else {
            echo "btn-dark'";
        }
        echo "id='likebutton-{$post['id']}'><i class='fa-solid fa-heart text-light'></i>
            <span id='likecount-{$post['id']}'>{$likecount}</span></a>";

        echo "<a title='Yorumlar' href='post.php?post={$post['id']}' class='btn btn-dark'><i class='fa-solid fa-comment-dots'></i></a>";
        //echo "<span title='Görüntüleme Sayısı' class='btn'><i class='fa-solid fa-eye'></i> " . $seenusers . "</span>";

        if (IsModerator($userid, $con) or $logined['usertoken'] == $post['publisher']) {
            echo "<a title='Gönderiyi Sil' class='text-decoration-none btn btn-dark float-end' href='tool_delete.php?id={$post['id']}'><i class='fas fa-trash'></i></a>";
        }
        echo "</p></div>";
    }
}

?>