<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['update_id'])){
        $id_jobtype = $_REQUEST['update_id'];
        $select_stmt = $db->prepare('SELECT * FROM job_type  WHERE id_jobtype = :id');
        $select_stmt->bindParam(":id", $id_jobtype);

        $select_stmt->execute();
        $roweditjob = $select_stmt->fetch(PDO::FETCH_ASSOC);
      

}   

?>
<!DOCTYPE html>
<html lang="en">
<form action="proc.php" method="post" enctype="multipart/form-data">
<?php include 'head.php'?> 
<body>
<?php include "sidebar.php"?>
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
<input type="hidden" id="proc" name="proc" value="">
<input type="hidden" id="id_jobtype" name="id_jobtype" value="">
<input type="hidden" id="userid" name="userid" value="">
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขชื่อประเภทงาน</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
                                    
											<label for="" class="control-label">ชื่อประเภทงาน</label>
											
											<input type="text" name="namejob" class="form-control form-control"  required  value="<?php echo  $roweditjob['name_jobtype'] ?>">
										</div>
                                    </div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="btn_up"  onclick="editjob('<?php echo  $roweditjob['id_jobtype'] ?>','<?php echo $roweditjob['user_id']  ?>')" >เเก้ไข</button>
											<a class="btn btn-secondary" type="button" href="jobtype_list.php" >กลับ</a>
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
<script>

function editjob(id_jobtype,user_id){
    $('#proc').val('editjob');
    $('#id_jobtype').val(id_jobtype);
    $('#userid').val(user_id);
}

</script>
<?php include "footer.php"?>