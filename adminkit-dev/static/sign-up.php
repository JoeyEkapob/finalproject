
<?php 
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?> 
<body>
<?php include "sidebar.php"?>
<form action="adduser.php" method="post" enctype="multipart/form-data">
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
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
			
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">Add user</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">First Name</label>
											<input type="text" name="firstname" class="form-control form-control" >
										</div>
										<div class="mb-3">
											<label for="" class="control-label">Last Name</label>
											<input type="text" name="lastname" class="form-control form-control" >
										</div>
										<div class="mb-3">
											<label for="" class="control-label">User Role</label>
												<select name="type" id="type" class="form-control">
													<option value="" >เลือกตำแหน่ง</option>
													<?php
													$stmt = $db->query("SELECT * FROM position");
													$stmt->execute();
													$result = $stmt->fetchAll();
													foreach($result as $row) {
													?>
												 <option value="<?= $row['role_id'];?>">-<?= $row['position_name'];?></option>
                									<?php } ?>
												</select>
										</div> 		
																
									</div>	
									<div class="col-md-6">
											<div class="mb-3">
												<label class="control-label">Email</label>
												<input type="email" class="form-control form-control" name="email" >
												<small id="#msg"></small>
											</div>
											<div class="mb-3">
												<label class="control-label">Password</label>
												<input type="password" class="form-control form-control" name="password">	
											</div>
											<div class="mb-3">
												<label class="label control-label">Confirm Password</label>
												<input type="password" class="form-control form-control" name="c_password">	
											</div>
									</div>
										<div class="mb-3">
											<div class="form-group">
												<label for="" class="control-label">Avatar</label>	
												<input type="file" name="file" class="form-control streched-link" accept="image/gif, image/jpeg, image/png">
												<p class="small mb-0 mt-2"><b>Note:</b> Only JPG, JPEG, PNG & GIF files are allowed to upload</p> 
											</div>
										</div>
										<div class="mb-4">
										
										</div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">

											<button class="btn btn-primary" name="signup">Save</button>

											<button class="btn btn-secondary" type="button" >Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>			
			</main>
</from> 

	
</body>

</html>
<?php include "footer.php"?>