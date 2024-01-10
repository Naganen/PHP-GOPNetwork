<?php
include('function.php');
if ($_COOKIE['login'] == null) {
    Redirect("index.php");
}
$userid = CheckUser($_COOKIE["login"], $con)['id'];
$post = $_GET["postid"];

$userid = mysqli_real_escape_string($con, $userid);
$post = mysqli_real_escape_string($con, $post);

$sql = "SELECT * FROM content WHERE id = $post";
$query = mysqli_query($con, $sql);
$result = mysqli_fetch_array($query);

$seenusers = array_filter(explode(",", $result["seenusers"]));
$likecount = count($seenusers);

//var_dump($userid);

if (!in_array($userid, $seenusers)) {
    if (mysqli_query($con, "UPDATE content SET seenusers = CONCAT(seenusers, '$userid,') WHERE id = $post")) {
        echo "true";
    }
}
?>