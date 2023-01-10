<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.2/examples/sign-in/signin.css" />
    <script type="text/javascript" async="" src="tricks.js"></script> 
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="form-signin w-100 m-auto">
<form  method="POST" action="chklogin.php" >
  <img src="./pic/LOGORMUTK.png">
    <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
    <div class="form-floating mb-1">
      <input type="text" class="form-control" name="email" placeholder="email" required>
      <label>email</label>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password" required >
      <label>Password</label>
    </div>
    <div class="d-flex justify-content-around align-items-center mb-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="" onclick="showpass()" />
            <label> เเสดงรหัสผ่าน </label>
        </div>
            <a href="#!">Forgot password?</a>
    </div>
    <button class="w-100 btn btn-outline-success" type="submit" name ="btnlogin">เข้าสู่ระบบ</button>
  </form>
  </div>

</body>
</html>