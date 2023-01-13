<?php 
session_start();
 include 'connect.php';
 
 if (isset($_REQUEST['update_id'])){
    try {
		
        $id = $_REQUEST['update_id'];
		//$sql = "SELECT * FROM user AS u  LEFT JOIN position AS p ON  u.role_id = p.role_id WHERE u.user_id = $user_id ";
        $select_stmt = $db->prepare('SELECT * FROM user  AS u  LEFT JOIN position AS p ON  u.role_id = p.role_id  WHERE user_id = :id');
        $select_stmt->bindParam(":id", $id);
	/* 	echo $id;
		exit;  */ 
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch(PDOException $e) {
        $e->getMessage();
    }
}   
if (isset($_POST['btn_up'])) {
		$targetDir = "img/avatars/";
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $status = $_POST['type'];
		/* $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf'); */
/* echo $fileName;
exit; */
         if (empty($firstname)) {
			$errorMsg = "กรุณากรอกชื่อ";
        } else if (empty($lastname)) {
			$errorMsg = "กรุณากรอกนามสกุล";
        } else if (empty($email)) {
			$errorMsg = "กรุณากรอกอีเมล";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errorMsg = "รูปแบบอีเมลไม่ถูกต้อง";
         } else if (!isset($password)) {
			$errorMsg = "กรุณากรอกรหัสผ่าน";
			if(strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5){
				$errorMsg = "รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร";
				if (empty($c_password)) {
					$errorMsg = "กรุณายืนยันรหัสผ่าน";
					if ($password != $c_password) {
						$errorMsg = "รหัสผ่านไม่ตรงกัน";
				}
			}
        }
            }/* else if(empty($fileName)){
            $_SESSION['error'] = "กรุณาเเนบไฟล์รูปภาพ";
            header("location: user_list.php");  
         }  */else {
            try {
                $check_email = $db->prepare("SELECT email,avatar FROM user WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
                //print_r ($row);
               
                if ($row['email'] == $email) {
					$errorMsg = "มีอีเมลนี้อยู่ในระบบแล้ว";
                    header("location: user_list.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
			$update_stmt = $db->prepare('UPDATE user SET firstname = :firstname_up ,lastname = :lastname ,email =:email, password = :password , role_id = :role_id  WHERE user_id = :id');
			$update_stmt->bindParam(':firstname_up', $firstname);
			$update_stmt->bindParam(":lastname", $lastname);
			$update_stmt->bindParam(":email", $email);
			$update_stmt->bindParam(":password", $passwordHash);
			$update_stmt->bindParam(":role_id", $status);
			$update_stmt->bindParam(':id', $id);
			$update_stmt->execute();
			$errorMsg = "สมัครสมาชิกเรียบร้อยแล้ว";
			header("location: user_list.php");
		} else {
			$errorMsg = "มีบางอย่างผิดพลาด";
			header("location: user_list.php");
		} 

	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
}



?>
<!DOCTYPE html>
<html lang="en">
<form action="edituser.php" method="post" enctype="multipart/form-data">
<?php include 'head.php'?> 
<body>

<?php 
            if(isset($errorMsg)) {
        ?>
            <div class="alert alert-danger">
                <strong><?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>

        <?php 
            if(isset($updateMsg)) {
        ?>
            <div class="alert alert-success">
                <strong><?php echo $updateMsg; ?></strong>
            </div>
        <?php } ?>
		
<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">edit user</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">First Name</label>
											<input type="hidden" id="custId" name="id" value="<?php echo $id; ?>">
											<input type="text" name="firstname" class="form-control form-control"   value="<?php echo $firstname; ?>">
										</div>
										<div class="mb-3">
											<label for="" class="control-label">Last Name</label>
											<input type="text" name="lastname" class="form-control form-control"  value="<?php echo $lastname; ?>">
										</div>
										
										<div class="mb-3">
											<label for="" class="control-label">User Role</label>
												<select name="type" id="type" class="form-control" value="">
													<option value="<?php  echo $row['role_id']; ?>" ><?php  echo $position_name; ?></option>
													<?php
													$stmt = $db->query("SELECT * FROM position");
													$stmt->execute();
													$result = $stmt->fetchAll();
													foreach($result as $row) {
													?>
												 <option value="<?= $row['role_id'];?>"><?= $row['position_name'];?></option>
                									<?php } ?>
												</select>
												</select>
										</div> 								
									</div>	
									<div class="col-md-6">
											<div class="mb-3">
												<label class="control-label">Email</label>
												<input type="email" class="form-control form-control" name="email" value="<?php echo $email; ?>">
												<small id="#msg"></small>
											</div>
											 <div class="mb-3">
												<label class="control-label">Password</label>
												<input type="password" class="form-control form-control" name="password" value="<?php  ?>">	
											</div>
											<div class="mb-3">
												<label class="label control-label">Confirm Password</label>
												<input type="password" class="form-control form-control" name="c_password" value="<?php  ?>">	
											</div>
									</div>
										<div class="mb-3">
											<div class="form-group">
												<label for="" class="control-label">Avatar</label>	
												<input type="file" name="file" class="form-control streched-link" accept="image/gif, image/jpeg, image/png" value="<?php echo $avatar; ?>">
												<p class="small mb-0 mt-2"><b>Note:</b> Only JPG, JPEG, PNG & GIF files are allowed to upload</p> 
												<p>
													<img src="img/avatars/<?php echo $avatar; ?>" height="100" width="100" alt="">
												</p>
											</div>
										</div> 
										<div class="mb-4">
										
										</div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">

											<button class="btn btn-primary" name="btn_up"  value="update" >edit</button>

											<a class="btn btn-secondary" type="button" href="user_list.php" >Cancel</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>			
			</main>
	</form>
<script src="js/app.js"></script>
    </body>
</html>