<?php
include('function.php');
if ($_COOKIE['login'] == null) {
    Redirect("index.php");
}
$userid = $_COOKIE['login'];
$avatar = $_POST['avatar'];

$avatar = stripcslashes($avatar);
$avatar = mysqli_real_escape_string($con, $avatar);

$sql = "UPDATE `users` SET profilepic = '$avatar' WHERE usertoken = '$userid'";
mysqli_query($con, $sql);
echo "<script>alert('Değişiklikler uygulandı!')</script>";
Redirect("user.php?u=" . CheckUser($_COOKIE['login'], $con)['username']);
?>