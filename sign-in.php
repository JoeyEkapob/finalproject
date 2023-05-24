<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?>

<body>
	<style>
			.main{
		width: 360px;
		margin: 2rem auto;
		height: 560px;
		border-radius: 50px;
		box-shadow: 3px 3px 10px rgba(0,0,0,0.2);
		position: relative;
		}

		.logo{
			position: absolute;
			z-index: 1;
			top: -170px;
			left: 50%;
			transform: translate(-50%);

		}
		@keyframes shake{
			0%,100%{translate:0;}
			25%{translate:8px 0;}
			75%{translate:-8px 0;}
		}

		

	

	</style>
	
<section>
  <!-- Background image -->
  <div class="p-5 bg-image" style="background-color:#1fabc6; height: 250px;  opacity: 0.6; "></div>
  <!-- Background image -->

  <div class="container">

  <div class="card sm-8 md-6 lg-4 mx-auto shadow-5-strong" 
  style="
        margin-top: -50px;
        background: hsla(0, 0%, 100%, 0.8);
        backdrop-filter: blur(30px);
        box-shadow: 3px 3px 10px rgba(0,0,0,0.4);

        ">
    <div class="card-body py-5 px-md-5">
    
    <div>
    <img src="./pic/Logo_RMUTK.png" class="img-fluid logo">
    </div>
      <div class="row d-flex justify-content-center">
        <div class="col-lg-6">
          <h3 class="fw-bold  my-5 text-center">ระบบสารสนเทศเพื่อการติดตามงาน</h3>

          <form  method="POST" action="proc.php" >
		  <input type="hidden" id="proc" name="proc" value="">
						<div class="text-center">
				
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
            <div class="form-outline mb-3">
            <label class="form-label">อีเมลผู้ใช้งาน</label>
			<input class="form-control form-control-lg" type="email" name="email" placeholder="กรอกอีเมลผู้ใช้งาน" >
            </div>

            <div class="form-outline mb-3">
				<label class="form-label">รหัสผู้ใช้งาน</label>
				<input class="form-control form-control-lg" type="password" name="password" placeholder="กรอกรหัสผู้ใช้งาน" >
            </div>
          

            <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-primary btn-block mb-4 mt-3" onclick="singin()"> เข้าสู่ระบบ </button>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div><!-- end container -->
</section>

</body>

</html>
<script>
	function singin(){
		$('#proc').val('login');
	}
</script>
<?php include "footer.php"?>
<!-- <form  method="POST" action="proc.php" >
	<input type="hidden" id="proc" name="proc" value="">
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
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" >
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" >
										
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
											 <button type="submit" name ="btnlogin" class="btn btn-lg btn-primary" onclick="singin()">Sign in</button> 
										</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>
</form>

	
</body>