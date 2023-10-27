<?php
    $servername = "localhost";
    $username = "dbname";
    $password = "dbpass";
    $dbname = "db";
    $con = mysqli_connect($servername, $username, $password, $dbname);
    $css = 'style.css?v=1.1';
    
    function Redirect($url)
    {
    if (!headers_sent())
        {
            header('Location: ' . $url, true, 302);
        }
        exit();
    }

    function CheckUser($token, $con) {
        $chkusr_sql = "SELECT * FROM `users` WHERE usertoken = '$token'";  
        $chkusr_result = mysqli_query($con, $chkusr_sql);
        return mysqli_fetch_array($chkusr_result, MYSQLI_ASSOC);
    }

    function CheckPublisher($post, $con) {
        $chkpblshr_sql = "SELECT * FROM `users` WHERE usertoken = '{$post['publisher']}'";  
        $chkpblshr_result = mysqli_query($con, $chkpblshr_sql);
        $publisher = mysqli_fetch_array($chkpblshr_result, MYSQLI_ASSOC);
        return $publisher['username'];
    }

    function CheckLikes($postid, $con) {
        $chklikes_sql = "SELECT * FROM `content` WHERE id = $postid";
        $chklikes_result = mysqli_query($con, $chklikes_sql);
        $likes = mysqli_fetch_array($chklikes_result, MYSQLI_ASSOC);
        return $likes['likes'];
    }

    function CheckLikers($postid, $con) {
        $chklikes_sql = "SELECT * FROM `content` WHERE id = $postid";
        $chklikes_result = mysqli_query($con, $chklikes_sql);
        $likes = mysqli_fetch_array($chklikes_result, MYSQLI_ASSOC);
        return $likes['likedusers'];
    }

    function IsModerator($userid, $con) {
        $ismod_sql = "SELECT * FROM `users` WHERE usertoken = '$userid'";  
        $ismod_result = mysqli_query($con, $ismod_sql);
        $ismod = mysqli_fetch_array($ismod_result, MYSQLI_ASSOC);
        return $ismod['moderator'];
    }

    function CensorSwear($input) {
        $swearfile = fopen("swears.txt", "r") or die("Unable to open file!");
        $swearstr = fread($swearfile,filesize("swears.txt"));
        $swears = array_map('trim', explode(",",$swearstr));
        fclose($swearfile);

        $post = explode(" ", $input);
        $postcensored_arr = $post;
        
        for ($i = 0; $i < count($post); $i++) {
            if (in_array(mb_strtolower($post[$i]), $swears)) {
                $postcensored_arr[$i] = '***';
            }
        }
        return implode(" ", $postcensored_arr);
    }

    function ShowHashtag($input) {

        $post = array_map('trim', explode(" ", $input));
        $posthashed = $post;
        
        for ($i = 0; $i < count($post); $i++) {
            if (substr($post[$i], 0, 1) == "#") {
                $tag = ltrim($post[$i], "#");
                $posthashed[$i] = "<a href='hashtag.php?hashtag=$tag'>$post[$i]</a>";
            }
        }
        return implode(" ", $posthashed);
    }

    function CheckHashtag($input) {
        $post = array_map('trim', explode(" ", $input));
        $hashes = $post;

        for ($i = 0; $i < count($post); $i++) {
            if (substr($post[$i], 0, 1) == "#") {
                $tag = ltrim($post[$i], "#");
                $hashes[$i] = "$tag";
            } else {
                $hashes[$i] = null;
            }
        }
        $hashes = array_filter($hashes);
        array_push($hashes, ',');
        return implode(",", $hashes);
    }

?>