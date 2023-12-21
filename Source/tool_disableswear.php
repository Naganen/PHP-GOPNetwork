<?php
include('function.php');
$userid = $_COOKIE['login'];
if ($userid == null) {
    Redirect("index.php");
}


if (CheckUser($userid, $con)['censorswear']) {
    $sql = "UPDATE `users` SET censorswear = 0 WHERE usertoken = '$userid'";
    mysqli_query($con, $sql);
    if (!CheckUser($userid, $con)['censorswear']) {
        Redirect("user.php?u=" . CheckUser($userid, $con)['username']);
    } else {
        Redirect("tool_disableswear.php");
    }
} else {
    $sql = "UPDATE `users` SET censorswear = 1 WHERE usertoken = '$userid'";
    mysqli_query($con, $sql);
    if (CheckUser($userid, $con)['censorswear']) {
        Redirect("user.php?u=" . CheckUser($userid, $con)['username']);
    } else {
        Redirect("tool_disableswear.php");
    }
}
?>