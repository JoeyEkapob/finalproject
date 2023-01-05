<?php

session_start();
require_once 'connect.php';

if (isset($_POST['btnlogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

/* print_r ($password);
exit; */
   
        if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: login.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: login.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: login.php");
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
                         if ($row['status'] == '1') {
                        $_SESSION['admin_login'] = $row['user_id'];
                        header("location: admin_page.php");
                    }/* else{
                    $_SESSION['user_page'] = $row['user_id'];
                    header("location: user_page.php");
                   }  */
                }/*  else {
                    $_SESSION['error'] = 'รหัสผ่านผิด';
                    header("location: login.php");
                }   */
            }/* else{
                $_SESSION['error'] = 'อีเมลผิด';
                header("location: login.php");
            }  */
        } /* else{
            $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
            header("location: login.php");
        }  */
            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>
