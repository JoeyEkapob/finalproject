<?php 

    session_start();
    require_once 'connect.php';

    if (isset($_POST['signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $status = $_POST['type'];
        $file = $_POST['file'];

        if (empty($firstname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: adduser_page.php");
         } else if (empty($lastname)) {
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            header("location: adduser_page.php");
        } else if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: adduser_page.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: adduser_page.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: adduser_page.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: adduser_page.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: adduser_page.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: adduser_page.php"); 
        } else {
            try {
                $check_email = $db->prepare("SELECT email FROM user WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
                //print_r ($status);
                if ($row['email'] == $email) {
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='login.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: adduser_page.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare("INSERT INTO user(firstname, lastname, email, password, status) 
                                            VALUES(:firstname, :lastname, :email, :password, :status)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":status", $status);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='login.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: adduser_page.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: adduser_page.php");
                } 
 
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    


?>