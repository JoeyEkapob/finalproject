<?php
    $dsn = "mysql:host=localhost;dbname=finalproject";
    $username = "root";
    $password = "";

    try{
        $obj = new PDO($dsn,$username,$password);
        //echo "เชื่อมต่อสมบูรณ์";
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>