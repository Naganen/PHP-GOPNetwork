<?php
    include('function.php');
    $username = $_POST['username'];  
    $password = $_POST['password'];  
    $remember = $_POST['remember'];  
      
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($con, $username);  
        $password = mysqli_real_escape_string($con, $password);  
    
        $sql = "SELECT * FROM users WHERE username = '$username'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){
            if (password_verify($password, $row['password'])) {
                if (!$remember) {
                    setcookie("login", $row['usertoken'], 0, "/");
                    Redirect("home.php");
                } elseif ($remember) {
                    setcookie("login", $row['usertoken'], time() + (86400 * 30), "/");
                    Redirect("home.php");
                }
            } else {
                Redirect("index.php?result=loginFailed");
            }
        }  
        else {  
            Redirect("index.php?result=loginFailed");
        }     

?>