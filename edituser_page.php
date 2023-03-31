<?php 
session_start();
 include 'connect.php';
 $targetDir = "img/avatars/";
 
 if (isset($_GET['update_id'])){
    try {
		
        $id = $_REQUEST['update_id'];
		//$sql = "SELECT * FROM user AS u  LEFT JOIN position AS p ON  u.role_id = p.role_id WHERE u.user_id = $user_id ";
        $select_stmt = $db->prepare('SELECT * FROM user  AS u  natural JOIN position  WHERE user_id = :id');
        $select_stmt->bindParam(":id", $id);
	/* 	echo $id;
		exit;  */ 
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
		//print_r ($row);
    } catch(PDOException $e) {
        $e->getMessage();
    }
}   
//echo $avatar; 


?>
<!DOCTYPE html>
<html lang="en">
<form action="edituser.php" method="post" enctype="multipart/form-data">
<?php include 'head.php'?> 
<body>
<?php include "sidebar.php"?>
		
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
											<input type="text" name="firstname" class="form-control form-control"  required  value="<?php echo $firstname; ?>">
										</div>
										<div class="mb-3">
											<label for="" class="control-label">Last Name</label>
											<input type="text" name="lastname" class="form-control form-control"  required value="<?php echo $lastname; ?>">
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
												<input type="email" class="form-control form-control" name="email" required  value="<?php echo $email; ?>">
												<small id="#msg"></small>
											</div>
											<!--  <div class="mb-3">
												<label class="control-label">Password</label>
												<input type="password" class="form-control form-control" name="password" value="">	
											</div>
											<div class="mb-3">
												<label class="label control-label">Confirm Password</label>
												<input type="password" class="form-control form-control" name="c_password" value="">	
											</div> -->
									
										<div class="mb-3">
											<div class="form-group">
												<label for="" class="control-label">Avatar</label>	
												<input type="hidden" id="" name="fileup" value="<?php echo $avatar; ?>">
												<input type="file" name="file" class="form-control streched-link" accept="image/gif, image/jpeg, image/png"  value="<?php echo $avatar;?>">
												<p class="small mb-0 mt-2"><b>Note:</b> Only JPG, JPEG, PNG & GIF files are allowed to upload</p> 
												<p>
													<img src="img/avatars/<?php echo $avatar; ?>" height="100" width="100" alt="">
												</p>
											</div>
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

    </body>
</html>
<?php include "footer.php"?>