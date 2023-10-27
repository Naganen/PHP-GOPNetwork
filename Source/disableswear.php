<?php
    include('function.php');
    $userid = $_COOKIE['login'];
    
    
    if (CheckUser($userid,$con)['censorswear']) {
        $sql = "UPDATE `users` SET censorswear = 0 WHERE usertoken = '$userid'";
        mysqli_query($con, $sql);
    } else {
        $sql = "UPDATE `users` SET censorswear = 1 WHERE usertoken = '$userid'";
        mysqli_query($con, $sql);
    }
    Redirect("settings.php");
?>