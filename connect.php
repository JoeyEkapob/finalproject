<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "finalproject";

    $conn = mysqli_connect($host,$user,$password,$database) or die (mysqli_error($connect));
    //mysqli_set_charset($connect,"utf8");
?>