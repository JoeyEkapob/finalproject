<?php 

    session_start();
    require_once 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration System PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <h3 class="mt-4">สมัครสมาชิก</h3>
        <hr>
        <form action="adduser.php" method="post">
            <div class="mb-3">
                <label for="firstname" class="form-label">First name</label>
                <input type="text" class="form-control" name="firstname" aria-describedby="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last name</label>
                <input type="text" class="form-control" name="lastname" aria-describedby="lastname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email">
            </div>
            <div class="mb-3">
				<label for="" class="control-label">User Role</label>
                <select name="type" id="type" class="form-control">
                    <option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>เจ้าหน้าที่</option>
                    <option value="4" <?php echo isset($status) && $status == 4 ? 'selected' : '' ?>>หัวสาขา</option>
                    <option value="4" <?php echo isset($status) && $status == 4 ? 'selected' : '' ?>>หัวข้อหน้าหน่วย</option>
                    <option value="4" <?php echo isset($status) && $status == 4 ? 'selected' : '' ?>>ผู้ชวยรองรองคณบดีฝ่ายวิชาการ</option>
                    <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>รองคณบดีฝ่ายวิชาการ</option>
                    <option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>คณบดี</option>
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Admin</option>
                </select>
			</div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="c_password">
            </div>
            <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
        </form>
        <hr>
        
    </div>
    
</body>
</html>