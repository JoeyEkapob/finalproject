
<?php 
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }

    if(isset($_POST['addjob'])){
        $namejob = $_POST['namejob'];
        $status = 1;
        if (empty($namejob)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อประเภทงาน';
           // header("location: addjobtype.php");

        }else if (!isset($_SESSION['error'])) {
            $stmtjob = $db->prepare("INSERT INTO job_type(name_jobtype,status) 
                                VALUES(:namejob, :status)");
            $stmtjob->bindParam(":namejob", $namejob);
            $stmtjob->bindParam(":status", $status);
            $stmtjob->execute();
            $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! ";
            header("location: jobtype_list.php.php");
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            header("location: jobtype_list.php.php");
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?> 
<body>
<?php include "sidebar.php"?>
<form action="" method="post" enctype="multipart/form-data">	
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
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เพิ่มประเภทงาน</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ชื่อประเภทงาน</label>
											<input type="text" name="namejob" class="form-control form-control" >
										</div>
                                    </div>
										
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">

											<button class="btn btn-primary" name="addjob">Save</button>

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