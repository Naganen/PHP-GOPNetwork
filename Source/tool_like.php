<?php
include('function.php');
if ($_COOKIE['login'] == null) {
    Redirect("index.php");
}
$userid = CheckUser($_GET["userid"], $con)['id'];
$post = $_GET["postid"];

$userid = mysqli_real_escape_string($con, $userid);
$post = mysqli_real_escape_string($con, $post);

$sql = "SELECT * FROM content WHERE id = $post";
$query = mysqli_query($con, $sql);
$result = mysqli_fetch_array($query);

$likedusers = array_filter(explode(",", $result["likedusers"]));
$likecount = count($likedusers);

//var_dump($userid);

if (in_array($userid, $likedusers)) {
    if (mysqli_query($con, "UPDATE content SET likedusers = REPLACE(likedusers, '$userid,', '') WHERE id = $post")) {
        echo "false";
    }
} else {
    if (mysqli_query($con, "UPDATE content SET likedusers = CONCAT(likedusers, '$userid,') WHERE id = $post")) {
        echo "true";
    }
}
?>