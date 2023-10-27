<?php
    include('function.php');
    $postid = $_GET['id'];
    $userid = $_COOKIE['login'];
    $user = CheckUser($userid, $con)['id'];
    $likers = explode(",",CheckLikers($postid, $con));


    if (!in_array($user, $likers)) {
        $addliked_sql = "UPDATE content SET likedusers = CONCAT(likedusers, '$user', ',') WHERE id = '$postid'";
        mysqli_query($con, $addliked_sql);
        $likepost_sql = "UPDATE content SET likes = likes + 1 WHERE id = $postid";
        mysqli_query($con, $likepost_sql); 
    }else {
        $addliked_sql = "UPDATE content SET likedusers = REPLACE(likedusers, '$user,', '') WHERE id = '$postid'";
        mysqli_query($con, $addliked_sql);
        $likepost_sql = "UPDATE content SET likes = likes - 1 WHERE id = $postid";
        mysqli_query($con, $likepost_sql); 
    }
    if ($_GET['from'] != null) {
        if ($_GET['hashtag'] != null) {
            Redirect($_GET['from'].'&hashtag='.$_GET['hashtag']."#{$postid}");
        } else {
            Redirect($_GET['from']."#{$postid}");
        }
    } elseif ($_GET['sort'] != null) {
        Redirect("home.php?sort=".$_GET['sort']."#{$postid}");
    } else {
        Redirect("home.php#{$postid}");
    }
?>