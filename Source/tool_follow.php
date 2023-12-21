<?php
include('function.php');
if ($_COOKIE['login'] == null) {
    Redirect("index.php");
}
$user = mysqli_real_escape_string($con, stripcslashes($_COOKIE['login']));
$userid = CheckUser($user, $con)['id'];
$who = mysqli_real_escape_string($con, stripcslashes(CheckUser($_GET['who'], $con)['id']));
$postid = $_GET['post'];
$following = explode(",", CheckUser($user, $con)['following']);
$done = false;

if (!in_array($who, $following)) {
    $addfllw_sql = "UPDATE users SET following = CONCAT(following, '$who', ',') WHERE usertoken = '$user'";
    $fllw_sql = "UPDATE users SET followers = CONCAT(followers, '$userid', ',') WHERE id = '$who'";
    if (mysqli_query($con, $addfllw_sql)) {
        mysqli_query($con, $fllw_sql);
        $done = true;
    }
} else {
    $addfllw_sql2 = "UPDATE users SET following = REPLACE(following, '$who,', '') WHERE usertoken = '$user'";
    $fllw_sql2 = "UPDATE users SET followers = REPLACE(followers, '$userid,', '') WHERE id = '$who'";
    if (mysqli_query($con, $addfllw_sql2)) {
        mysqli_query($con, $fllw_sql2);
        $done = true;
    }
}

if ($done) {
    if ($_GET['from'] != null) {
        if ($_GET['hashtag'] != null) {
            Redirect($_GET['from'] . '?hashtag=' . $_GET['hashtag'] . "#{$postid}");
        } elseif ($_GET['who'] != null && $_GET['from'] == 'user.php') {
            Redirect($_GET['from'] . "?u=" . CheckUser($_GET['who'], $con)['username']);
        } else {
            Redirect($_GET['from'] . "#{$postid}");
        }
    } elseif ($_GET['sort'] != null) {
        Redirect("home.php?sort=" . $_GET['sort'] . "#{$postid}");
    } else {
        Redirect("home.php#{$postid}");
    }
} else {
    header("Refresh:0");
}
?>