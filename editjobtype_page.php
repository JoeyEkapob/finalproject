<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['update_id'])){
    try {
		
        $id = $_REQUEST['update_id'];
        
		//$sql = "SELECT * FROM user AS u  LEFT JOIN position AS p ON  u.role_id = p.role_id WHERE u.user_id = $user_id ";
        $select_stmt = $db->prepare('SELECT * FROM job_type  WHERE id_jobtype = :id');
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

if(isset($_POST['btn_up'])){

    $namejob = $_POST['namejob'];
    $status = 1;

    if (empty($namejob)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อประเภทงาน';
       // header("location: addjobtype.php");

    }else if (!isset($_SESSION['error'])) {
        $update_stmtjob = $db->prepare('UPDATE job_type SET name_jobtype = :namejob WHERE id_jobtype = :id');
        $update_stmtjob->bindParam(':namejob', $namejob);
        $update_stmtjob->bindParam(':id', $id);
        $update_stmtjob->execute();
        $_SESSION['success'] = "เเก้ไขเรียบร้อย! ";
        header("location: jobtype_list.php");
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: jobtype_list.php");
    } 
}




//echo $avatar; 


?>
<!DOCTYPE html>
<html lang="en">
<form action="" method="post" enctype="multipart/form-data">
<?php include 'head.php'?> 
<body>
		
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
											<input type="text" name="namejob" class="form-control form-control"  required  value="<?php echo $name_jobtype; ?>">
										</div>
                                    </div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="btn_up"  value="update" >edit</button>
											<a class="btn btn-secondary" type="button" href="jobtype_list.php" >Cancel</a>
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