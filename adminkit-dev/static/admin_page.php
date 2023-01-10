<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['admin_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:login.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include 'menubar.php'?>
<body>
        <?php 
            if (isset($_SESSION['admin_login'])) {
                $admin_id = $_SESSION['admin_login'];
            // echo $admin_id ;
                $stmt = $db->query("SELECT * FROM user WHERE user_id = $admin_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
       <h3 class="mt-4">Welcome Admin, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h3> 
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>