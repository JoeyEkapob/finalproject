<?php
session_start();
require 'connect.php';

$username = $_GET['username'];
$password = $_GET['password'];



    $query = "SELECT * FROM login WHERE username = '$username' AND password= '$password'";
    $result = mysqli_query($conn,$query);

   if(mysqli_num_rows($result)>0){

       
   }

?>