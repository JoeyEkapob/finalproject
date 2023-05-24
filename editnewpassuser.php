<?php 
session_start();
require_once 'connect.php';
if(!isset($_SESSION['user_login'])){
    $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
   header('location:sign-in.php');
}
if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
  } else {
    $previousPage = "#";
  }
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?>
<form action="proc.php" method="POST">
	<input type="hidden" id="proc" name="proc" value="">

<body>
<?php include "sidebar.php"?>

	<main class="content">
    <a href="<?php echo $previousPage; ?>" class="back-button">&lt;</a> 
		<div class="container d-flex flex-column">
			<div class="row vh-30">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-80">
                    
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">เเก้ไขรหัสผ่าน</h1>

						</div>

                                <div class="card">
                                    <div class="card-body">
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
                                            <div class="m-sm-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">อีเมล</label>
                                                        <input class="form-control form-control-lg" type="email" name="email" placeholder="กรุณากรอกอีเมล" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">กรุณารหัสผ่าน</label>
                                                        <div class="input-group" >
                                                                <input type="password" class="form-control" name="password"  id="password1"  placeholder="กรุณากรอกรหัส password">
                                                            <div class="input-group-text">
                                                                <input type="checkbox" id="show-password1">
                                                            </div>
                                                        </div>
                                                        <!-- <input class="form-control form-control-lg" type="password" name="password"  id="password" placeholder="Enter password" />
                                                        <button type="button" id="togglePassword">Show/Hide Password</button> -->
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">กรุณารหัสผ่าน</label>
                                                        <div class="input-group" >
                                                                <input type="password" class="form-control" name="password_c"  id="password2"  placeholder="กรุณากรอกรหัส password">
                                                            <div class="input-group-text">
                                                                <input type="checkbox" id="show-password2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="text-center mt-3">
                                                    <button  class="btn btn-lg btn-primary newpass" onclick="newpass()">เเก้ไข</button>

                                                    <!-- <button type="submit" class="btn btn-lg btn-primary">Sign up</button> -->
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
    </boby>

</html>
<script>
    
	function newpass(){
		$('#proc').val('editpassuser');
	}

    $(document).ready(function() {
  $('#show-password1').click(function() {
    var password = $('#password1');
    var type = password.attr('type') === 'password' ? 'text' : 'password';
    password.attr('type', type);
  });
  $('#show-password2').click(function() {
    var password = $('#password2');
    var type = password.attr('type') === 'password' ? 'text' : 'password';
    password.attr('type', type);
  });
});
</script>
<?php include "footer.php"?>