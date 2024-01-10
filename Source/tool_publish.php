<?php
include('function.php');
if ($_COOKIE['login'] == null) {
    Redirect("index.php");
}


if ($_POST['img']) {
    $post = htmlspecialchars($_POST['img']) . "<br><br>" . htmlspecialchars($_POST['post']);
} else {
    $post = htmlspecialchars($_POST['post']);
}
$related = $_POST['related'];
if ($related == null) {
    $related = 0;
}
$post = bbc2html($post);
$publisher = $_COOKIE['login'];

$post = stripcslashes($post);
$publisher = stripcslashes($publisher);
$post = mysqli_real_escape_string($con, $post);
$publisher = mysqli_real_escape_string($con, $publisher);
$hashtags = CheckHashtag($post);

if ($post != null && CheckUser($publisher, $con)['usertoken'] == $publisher && strlen($post) < 256) {
    $sql = "INSERT INTO `content`(`post`, `publisher`, `related`,`likedusers`, `hashtag`) VALUES ('$post', '$publisher', $related, '', '$hashtags')";
    $result = mysqli_query($con, $sql);
}

if ($related != 0) {
    Redirect("post.php?post=".$related);
} else {
    Redirect("home.php");
}



?>