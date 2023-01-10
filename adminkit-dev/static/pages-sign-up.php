
<?php 
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:pages-sign-in.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?> 
<body>
<?php include "sidebar.php"?>
<form action="adduser.php" method="post">
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
					<div class="text-center mt-4">
							<h1 class="h2">Add user</h1>
							
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<form>
										<div class="row">
											<div class="col-md-6 border-right">
												<div class="form-group">
													<label for="" class="control-label">First Name</label>
													<input type="text" name="firstname" class="form-control form-control-sm" required value="">
												</div>
												<div class="form-group">
													<label for="" class="control-label">Last Name</label>
													<input type="text" name="lastname" class="form-control form-control-sm" required value="">
												</div>
												
												<div class="mb-12">
													<label for="" class="control-label">User Role</label>
														<select name="type" id="type" class="form-control">
															<option value="5" >เจ้าหน้าที่</option>
															<option value="4" >หัวสาขา</option>
															<option value="4" >หัวหน้าหน่วย</option>
															<option value="4" >ผู้ชวยรองรองคณบดีฝ่ร</option>
															<option value="2" >คณบดี</option>ายวิชาการ</option>
															<option value="3" >รองคณบดีฝ่ายวิชากา
															<option value="1" >Admin</option>
														</select>
												</div> 							
	
												<div class="mb-3">	
													<div class="form-group">
														<label for="" class="control-label">Avatar</label>	
														<input class="form-control border border-primary" type="file" id="formFile" accept="image/jpeg, image/png, image/jpg"> 
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Email</label>
													<input type="email" class="form-control form-control-sm" name="email" required value="">
													<small id="#msg"></small>
												</div>
												<div class="form-group">
													<label class="control-label">Password</label>
													<input type="password" class="form-control form-control-sm" name="password">
													
												</div>
												<div class="form-group">
													<label class="label control-label">Confirm Password</label>
													<input type="password" class="form-control form-control-sm" name="cpass">
													<small id="pass_match" data-status=''></small>
												</div>
											</div>
										</div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary">Save</button>
											<button class="btn btn-secondary" type="button" >Cancel</button>
										</div>
									</form>
								</div>
							</div>
						</div>

			</div>
		</div>
	</main>
</from>

	<script src="js/app.js"></script>

</body>

</html>