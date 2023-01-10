<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?>

<body>
<form  method="POST" action="chklogin.php" >
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
									<img src="./pic/LOGORMUTK.png" alt="Charles Hall" class="img-fluid rounded-circle" width="132" height="132" />
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
									</div>
									<form>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
										
										</div>
										<div>
											<label class="form-check">
											<input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
											<span class="form-check-label">
											Remember me next time
											</span>
										</label>
										</div>
										<div class="text-center mt-3">
											 <button type="submit" name ="btnlogin" class="btn btn-lg btn-primary">Sign in</button> 
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="js/app.js"></script>

</body>

</html>