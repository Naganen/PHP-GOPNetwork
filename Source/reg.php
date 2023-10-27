<?php
    include('function.php');
    $username = $_POST['username'];  
    $password = $_POST['password']; 
    $passwordr = $_POST['passwordr']; 
    $usertoken = password_hash(rand(), PASSWORD_DEFAULT);
      
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $passwordr = stripcslashes($passwordr);  
        $username = mysqli_real_escape_string($con, $username);  
        $password = mysqli_real_escape_string($con, $password);  
        $passwordr = mysqli_real_escape_string($con, $passwordr);  

        $sql1 = "SELECT username FROM `users` WHERE username = ('$username')";
        $result1 = mysqli_query($con, $sql1); 
        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
      
        if ($row1['username'] == null) {
            if ($password != $passwordr) {
                Redirect("register.php?result=passNotMatch");
            } elseif (strlen($username) > 15 || strlen($username) < 5 || strlen($password) > 15 || strlen($password) < 5) {
                Redirect("register.php?result=creditendalLenght");
            } else {
                $passhash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users`(`username`, `password`, `usertoken`) VALUES ('$username', '$passhash', '$usertoken')";
                mysqli_query($con, $sql);  
                Redirect("index.php?result=registerSuccess");
            }
        } else {
            Redirect("register.php?result=userExist");
        }
?>