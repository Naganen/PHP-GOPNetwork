<?php
    include('function.php');
    if ($_COOKIE['login'] == null) {
        Redirect("index.php");
    }
    $deleteid = $_GET['id'];
      
        $deleteid = stripcslashes($deleteid);  
        $deleteid = mysqli_real_escape_string($con, $deleteid);  

        $sql1 = "SELECT * FROM `content` WHERE id = ('$deleteid')";
        $result1 = mysqli_query($con, $sql1); 
        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

        $userid = $_COOKIE['login'];

        if (IsModerator($userid, $con) or CheckUser($userid, $con)['usertoken'] == $row1['publisher']) {
            $sql3 = "DELETE FROM `content` WHERE id = $deleteid";
            mysqli_query($con, $sql3);  
            Redirect("home.php");
        } else {
            Redirect("home.php");
        }
?>