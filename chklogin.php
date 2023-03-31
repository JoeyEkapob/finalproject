<?php

session_start();
require_once 'connect.php';

if (isset($_POST['btnlogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
/*  print_r ($password);
exit;  */
        if (empty($email)) {
            $_SESSION['error'] = '<center>กรุณากรอกอีเมล</center>';
            header("location: sign-in.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = '<center>แบบอีเมลไม่ถูกต้อง</center>';
            header("location: sign-in.php");
        } else if (empty($password)) {
            $_SESSION['error'] = '<center>กรุณากรอกรหัสผ่าน</center>';
            header("location: sign-in.php");
        } else {
            try {
                $check_data = $db->prepare("SELECT * FROM user WHERE email = :uemail");
                $check_data->bindParam(":uemail", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                //print_r ($row);
                if ($check_data->rowCount() > 0) {
                if ($email == $row['email'] ){
                   if(password_verify($password ,$row['password'])) {
                        $_SESSION['user_login'] = $row['user_id'];
                        header("location: index.php");
                }  else {
                    $_SESSION['error'] = '<center>รหัสผ่านผิด</center>';
                    header("location: sign-in.php");
                }   
            } else{
                $_SESSION['error'] = '<center>อีเมลผิด</center>';
                header("location: sign-in.php");
            }  
        }  else{
            $_SESSION['error'] = "<center>ไม่มีข้อมูลในระบบ</center>";
            header("location: sign-in.php");
        }  
            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>
