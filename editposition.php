<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['update_id'])){
        $role_id = $_REQUEST['update_id'];
        $select_stmt = $db->prepare('SELECT * FROM position  WHERE role_id = :id');
        $select_stmt->bindParam(":id", $role_id);

        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        $levelposition =$row['level'];
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
<input type="hidden" id="role_id" name="role_id" value="">
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
											<label for="" class="control-label">ชื่อตำเเหน่ง</label>
											
											<input type="text" name="nameposition" class="form-control form-control"  required  value="<?php echo $position_name; ?>">
										</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">ระดับ</label>
                                                <select select  name="level"  id="level" class="form-select"  >
                                                <option value="<?=   $levelposition  ?>"><?=   $levelposition   ?></option>
                                                <?php
                                                  $stmt = $db->query("SELECT level
                                                  FROM position
                                                  WHERE position_status = 1
                                                  GROUP BY level
                                                  HAVING level = MAX(level)");
                                                  $stmt->execute();
                                                  while($results = $stmt->fetch(PDO::FETCH_ASSOC)){;
                                                    $maxlevel  = $results['level']?>
                                                    
                                                  <option value="<?= $results['level']; ?>"><?= $results['level']; ?></option>
                                      
                                              <?php } ?>
                                          <option value="<?= $maxlevel ++ ?>"><?= $maxlevel++ ?></option> 
                                                 </select>
                                        </div>
                                    </div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="btn_up"  onclick="editposition('<?php echo $role_id ?>')" >เเก้ไข</button>
											<a class="btn btn-secondary" type="button" href="position_list.php" >กลับ</a>
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

function editposition(role_id){
    $('#proc').val('editposition');
    $('#role_id').val(role_id);
    console.log(role_id)
}

</script>
<?php include "footer.php"?>