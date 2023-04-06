<?php
    $dsn = "mysql:host=203.159.92.57;dbname=finalproject";
    $username = "raywel";
    $password = "GN7M6x!z";

    try{
        $db = new PDO($dsn,$username,$password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>