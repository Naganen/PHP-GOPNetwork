<?php
    include('function.php');
    $post = $_POST['post'];  
    $publisher = $_COOKIE['login'];
      
        $post = stripcslashes($post);  
        $publisher = stripcslashes($publisher);  
        $post = mysqli_real_escape_string($con, $post);  
        $publisher = mysqli_real_escape_string($con, $publisher);  
        $hashtags = CheckHashtag($post);
      
        if ($post != null && CheckUser($publisher, $con)['usertoken'] == $publisher && strlen($post) < 256) {
            $sql = "INSERT INTO `content`(`post`, `publisher`,`likedusers`, `hashtag`) VALUES ('$post', '$publisher', '', '$hashtags')";
            $result = mysqli_query($con, $sql);  
        }
        Redirect("home.php");
?>