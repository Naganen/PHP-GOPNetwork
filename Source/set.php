<?php
    include('function.php');
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
        Redirect("settings.php?result=passWrong");
    } elseif ($newpass != $newpassr) {
        Redirect("settings.php?result=passNotMatch");
    } elseif (strlen($newpass) > 15) {
        Redirect("settings.php?result=passLong");
    } elseif (strlen($newpass) < 5) {
        Redirect("settings.php?result=passShort");
    } else {
        $sql = "UPDATE `users` SET password = '$newpass' WHERE usertoken = '$userid'";
        mysqli_query($con, $sql);
        Redirect("settings.php?result=changeSuccess");
    }
?>