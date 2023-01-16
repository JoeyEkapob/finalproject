<?php
session_start();
 include 'connect.php';
 $targetDir = "img/avatars/";
 /* if(in_array($fileType, $allowTypes)) {
    unlink("img/avatars/".$row['avatar']);
   move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath);
} */
if (isset($_POST['btn_up'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
   /*  $password = $_POST['password'];
    $c_password = $_POST['c_password']; */
    $status = $_POST['type'];
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf'); 
    
/* echo $fileName;
exit; */
            $check_img = $db->prepare("SELECT avatar FROM user WHERE user_id = :id");
            $check_img->bindParam(":id", $id);
            $check_img->execute();
            $row = $check_img->fetch(PDO::FETCH_ASSOC);

            if (in_array($fileType, $allowTypes)) {
                unlink($targetDir.$row['avatar']);
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                } else {
                    $_SESSION['warning'] = "
                    ขออภัย มีข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ";
                    header("location: user_list.php");
                }
            } else {
                $_SESSION['warning'] = "
                ขออภัย อนุญาตให้อัปโหลดเฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น";
                header("location: user_list.php");
            }

    
  
            if (empty($firstname)) {
                $_SESSION['error'] = 'กรุณากรอกชื่อ';
                header("location: user_list.php");
            } else if (empty($lastname)) {
                $_SESSION['error'] = 'กรุณากรอกนามสกุล';
                header("location:user_list.php");
            } else if (empty($email)) {
                $_SESSION['error'] = 'กรุณากรอกอีเมล';
                header("location: user_list.php");
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
                header("location: user_list.php");
                
            }else if(empty($fileName)){
                $_SESSION['error'] = "กรุณาเเนบไฟล์รูปภาพ";
                header("location: user_list.php");  
                
            } else {
                try {
                    $check_email = $db->prepare("SELECT email FROM user WHERE email = :email");
                    $check_email->bindParam(":email", $email);
                    $check_email->execute();
                    $row = $check_email->fetch(PDO::FETCH_ASSOC);
                // print_r ($row);

                    if ($row['email'] == $email) {
                        $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว ";
                        header("location:user_list.php");
                    } else if (!isset($_SESSION['error'])) {
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $update_stmt = $db->prepare('UPDATE user SET firstname = :firstname_up ,lastname = :lastname ,email =:email, password = :password , role_id = :role_id ,avatar = :avatar WHERE user_id = :id');
                    $update_stmt->bindParam(':firstname_up', $firstname);
                    $update_stmt->bindParam(":lastname", $lastname);
                    $update_stmt->bindParam(":email", $email);
                    $update_stmt->bindParam(":password", $passwordHash);
                    $update_stmt->bindParam(":avatar", $fileName);
                    $update_stmt->bindParam(":role_id", $status);
                    $update_stmt->bindParam(':id', $id);
                    $update_stmt->execute();
                    $errorMsg = "เเก้ไขเรียบร้อยแล้ว";
                    header("location;user_list.php");
                } else {
                    $errorMsg = "มีบางอย่างผิดพลาด";
                    header("location; user_list.php");
                } 
           
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                }
        }




?>