<?php
        include("function.php");
        setcookie("login", null, 0, "/");
        Redirect("index.php?result=logout");
?>