<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['update_id'])){
        $id_jobtype = $_REQUEST['update_id'];
        $select_stmt = $db->prepare('SELECT * FROM job_type  WHERE id_jobtype = :id');
        $select_stmt->bindParam(":id", $id_jobtype);

        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

}   

?>
<!DOCTYPE html>
<html lang="en">
<form action="proc.php" method="post" enctype="multipart/form-data">
<?php include 'head.php'?> 
<body>
<?php include "sidebar.php"?>
<?php include "funtion.php"?>
<input type="hidden" id="proc" name="proc" value="">
<input type="hidden" id="id_jobtype" name="id_jobtype" value="">
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
											
											<input type="text" name="namejob" class="form-control form-control"  required  value="<?php echo $name_jobtype; ?>">
										</div>
                                    </div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="btn_up"  onclick="editjob('<?php echo $id_jobtype ?>')" >เเก้ไข</button>
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

function editjob(id_jobtype){
    $('#proc').val('editjob');
    $('#id_jobtype').val(id_jobtype);
}

</script>
<?php include "footer.php"?>