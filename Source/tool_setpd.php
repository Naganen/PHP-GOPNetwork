<?php
include('function.php');
if ($_COOKIE['login'] == null) {
    Redirect("index.php");
}
$userid = $_COOKIE['login'];
$desc = htmlspecialchars($_POST['desc']);

$desc = stripcslashes($desc);
$desc = mysqli_real_escape_string($con, $desc);

$sql = "UPDATE `users` SET userdesc = '$desc' WHERE usertoken = '$userid'";
mysqli_query($con, $sql);
echo "<script>alert('Değişiklikler uygulandı!')</script>";
Redirect("user.php?u=" . CheckUser($_COOKIE['login'], $con)['username']);
?>