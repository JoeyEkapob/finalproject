<?php 
session_start();
 include 'connect.php';
 $targetDir = "img/avatars/";
 
 if (isset($_GET['update_id'])){
        $id = $_REQUEST['update_id'];
        $select_stmt = $db->prepare('SELECT * FROM user  AS u  natural JOIN position  WHERE user_id = :id');
        $select_stmt->bindParam(":id", $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
		//echo $tel;
 
}   
//echo $avatar; 


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
		<input type= hidden id="proc" name="proc" value="">
		<input type= hidden id="userid" name="userid" value="">
		
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขสมาชิก</h1>
				</div>
				
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
									<div class="text-center">
                        			  	<img class="rounded-circle rounded me-1 mb-3" src="img/avatars/<?php echo $avatar ?>" id ="img" alt="avatar" width="200"  height="200">
                      				</div>
									<div class="col-md-2">
										
									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="" class="control-label">รูปภาพ</label>	
											<input type="hidden" id="" name="fileup" value="<?php echo $avatar; ?>">
											<input type="file" name="file" class="form-control streched-link " accept="image/jpeg,image/png,image/jpg"  value="<?php echo $avatar;?>" onchange="Preview(this)">
											<p class="small mb-0 mt-2"><b>Note:</b>อนุญาตให้อัปโหลดเฉพาะไฟล์ JPG, JPEG, PNG </p> 
										</div>
									</div>
									<div class="col-md-2">
								
									</div>
									<!-- <div class="col-md-12">
										<div class="col-md-6">
											<div class="mb-3">
												<div class="form-group">
													<label for="" class="control-label">รูปภาพ</label>	
													<input type="hidden" id="" name="fileup" value="<?php echo $avatar; ?>">
													<input type="file" name="file" class="form-control streched-link " accept="image/gif, image/jpeg, image/png"  value="<?php echo $avatar;?>">
													<p class="small mb-0 mt-2"><b>Note:</b>อนุญาตให้อัปโหลดเฉพาะไฟล์ JPG, JPEG, PNG </p> 
												</div>
											</div>
										</div>
									</div> -->
									<div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ชื่อ</label>
											<input type="hidden" id="custId" name="id" value="<?php echo $id; ?>">
											<input type="text" name="firstname" class="form-control form-control"  required  value="<?php echo $firstname; ?>">
										</div>
										<div class="mb-3">
												<label class="control-label">อีเมล</label>
												<input type="email" class="form-control form-control" name="email" required  value="<?php echo $email; ?>">
												<small id="#msg"></small>
										</div>
										
										<div class="mb-3">
											<label for="" class="control-label">ตำเเหน่ง</label>
												<select name="role" id="role" class="form-select" value="">
													<option value="<?php  echo $row['role_id']; ?>" ><?php  echo $position_name; ?></option>
													<?php
													$stmt = $db->query("SELECT * FROM position");
													$stmt->execute();
													$result = $stmt->fetchAll();
													foreach($result as $row) {
													?>
												 <option value="<?= $row['role_id'];?>"><?= $row['position_name'];?></option>
                									<?php }?>
												</select>
										</div>
										<?php if($status_user == 1){ ?>
										<div class="form-check form-switch ">
											<input class="form-check-input" type="checkbox" role="switch" id="switch" name="switch"  checked>
											<label class="form-check-label" for="flexSwitchCheckChecked">สถานะการใช้งาน</label>
										</div>
										<?php }else{ ?>
										<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" role="switch" id="switch" name="switch"  >
											<label class="form-check-label" for="flexSwitchCheckChecked">สถานะการใช้งาน</label>
										</div>
										<?php } ?>			
									</div>	
									<div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">นามสกุล</label>
											<input type="text" name="lastname" class="form-control form-control"  required value="<?php echo $lastname; ?>">
										</div>
										<div class="mb-3">
											<label for="control-label">เบอร์โทรศัพท์</label>
											<input  class="form-control" type="tel" id="phone" name="phone" placeholder="กรอกหมายเลขโทรศัพท์ของคุณ" value="<?php echo $tel; ?>">
										</div>

										
										<div class="mb-3">
												<label for="" class="control-label">ไลน์โทเค็น</label>
												<input type="text" name="tokenline" class="form-control" placeholder="กรอกไลน์โทเค็นของคุณ" value = "<?php echo $line_token ?>">
												<p class="small mb-0 mt-2"><b>Note:</b>หากต้องการเเจ้งได้รับการเเจ้งตื่อนผ่านไลน์อนุญาตโปรดกรอกไลน์โทเค็นของคุณ</p> 
											</div> 	
											<!--  <div class="mb-3">
												<label class="control-label">Password</label>
												<input type="password" class="form-control form-control" name="password" value="">	
											</div>
											<div class="mb-3">
												<label class="label control-label">Confirm Password</label>
												<input type="password" class="form-control form-control" name="c_password" value="">	
											</div> -->
									
										<!-- <div class="mb-3">
											<div class="form-group">
												<label for="" class="control-label">รูปภาพ</label>	
												<input type="hidden" id="" name="fileup" value="<?php echo $avatar; ?>">
												<input type="file" name="file" class="form-control streched-link" accept="image/gif, image/jpeg, image/png"  value="<?php echo $avatar;?>">
												<p class="small mb-0 mt-2"><b>Note:</b> Only JPG, JPEG, PNG & GIF files are allowed to upload</p> 
											</div>
										</div>  -->
										</div>
										<div class="mb-4">
										</div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="btn_up"  onclick="edituser('<?php echo $id ?>')" >เเก้ไข</button>
											<a class="btn btn-secondary" type="button" href="user_list.php" >กลับ</a>
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
	function edituser(id){
		$('#proc').val('edituser');
		 $('#userid').val(id);
		//console.log(id) 
	}function Preview(ele) {
        $('#img').attr('src', ele.value);
                if (ele.files && ele.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }
                reader.readAsDataURL(ele.files[0]);
            }
        }
</script>
<?php include "footer.php"?>