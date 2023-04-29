<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['update_id'])){
        $department_id1 = $_REQUEST['update_id'];
        $select_stmt = $db->prepare('SELECT * FROM department  WHERE department_id = :id');
        $select_stmt->bindParam(":id", $department_id1);

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
<input type="hidden" id="department_id" name="department_id" value="">
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขชื่อฝ่ายงาน</h1>
				</div>
           
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ชื่อฝ่ายงาน</label>
											
											<input type="text" name="namedepartmant" class="form-control form-control"  required  value="<?php echo $department_name; ?>">
										</div>
                                    </div>
                               
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="btn_up"  onclick="editdepartmant('<?php echo $department_id1 ?>')" >เเก้ไข</button>
											<a class="btn btn-secondary" type="button" href="departmant_list.php" >กลับ</a>
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

function editdepartmant(department_id1){
    $('#proc').val('editdepartmant');
    $('#department_id').val(department_id1);
    console.log(department_id1)
}

</script>
<?php include "footer.php"?>