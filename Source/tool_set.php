<?php
    include('function.php');
    if ($_COOKIE['login'] == null) {
        Redirect("index.php");
    }
    $userid = $_COOKIE['login'];
    $oldpass = $_POST['curPassword'];  
    $newpass = $_POST['newPassword'];  
    $newpassr = $_POST['newPasswordR']; 
      
    $oldpass = stripcslashes($oldpass);  
    $newpass = stripcslashes($newpass);  
    $newpassr = stripcslashes($newpassr);  
    $oldpass = mysqli_real_escape_string($con, $oldpass);  
    $newpass = mysqli_real_escape_string($con, $newpass);  
    $newpassr = mysqli_real_escape_string($con, $newpassr);  
    
    if (CheckUser($userid,$con)['password'] != $oldpass) {
        echo "<script>alert('Eski şifren yanlış!')</script>";
    } elseif ($newpass != $newpassr) {
        echo "<script>alert('Şifreler uyuşmuyor!')</script>";
    } elseif (strlen($newpass) > 25) {
        echo "<script>alert('Yeni şifren çok uzun!')</script>";
    } elseif (strlen($newpass) < 5) {
        echo "<script>alert('Yeni şifren çok kısa!')</script>";
    } else {
        $sql = "UPDATE `users` SET password = '$newpass' WHERE usertoken = '$userid'";
        mysqli_query($con, $sql);
        echo "<script>alert('Değişiklikler uygulandı!')</script>";
    }
    Redirect("user.php?u=". CheckUser($_COOKIE['login'], $con)['username']);

?>