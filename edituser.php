<?php 
session_start();
 include 'connect.php';
 $targetDir = "img/avatars/";
 if(!isset($_SESSION['user_login'])){
	$_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
   header('location:sign-in.php');
}
if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
  } else {
    $previousPage = "#";
  }
 if (isset($_GET['user_id'])){
        $id = $_REQUEST['user_id'];
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
		<a href="<?php echo $previousPage; ?>" class="back-button">&lt;</a> 
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขสมาชิก</h1>
				</div>
				
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
									<div class="text-center">
										<?php if($avatar != ""){?>
											<img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $row['avatar']?>"  id="img"  alt="Avatar" width="200"  height="200">
										<?php }else{ ?>
											<img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg"  id="img"   alt="Avatar" width="200"  height="200">
										<?php } ?>
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
									<div class="col-md-2">
										<div class="mb-3">
											<label for="" class="control-label" >คำนำหน้า</label>
												<select name="shortname" id="shortname" class="form-select"  >
													<option value="<?php echo $shortname_id ?>"><?php echo showshortname($shortname_id) ?></option>
													<option value="1">นาย</option>
													<option value="9">นาง</option>
													<option value="2">นางสาว</option>
													<option value="3">ดร.</option>
													<option value="4">ผศ</option>
													<option value="5">รศ</option>
													<option value="6">ศ</option>
													<option value="7">ผศ.ดร</option>
													<option value="8">ศ.ดร</option>
													<option value="10">อาจารย์</option>
													<option value="11">Mr</option>
													<option value="12">Ms</option>
												</select>
										</div>
									</div>
									<div class="col-md-5">
										<div class="mb-3">
											<label for="" class="control-label">ชื่อ</label>
											<input type="hidden" id="custId" name="id" value="<?php echo $id; ?>">
											<input type="text" name="firstname" class="form-control form-control"  required  value="<?php echo $firstname; ?>">
										</div>
									</div>
									<div class="col-md-5">
										<div class="mb-3">
											<label for="" class="control-label">นามสกุล</label>
											<input type="text" name="lastname" class="form-control form-control"  required value="<?php echo $lastname; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
												<label class="control-label">อีเมล</label>
												<input type="email" class="form-control form-control" name="email" required  value="<?php echo $email; ?>">
												<small id="#msg"></small>
										</div>
										
										<div class="mb-3">
											<label for="control-label">เลขบัตรประชาชน</label>
											<input  class="form-control" type="tel" id="idcard" name="idcard" value="<?php echo $idcard; ?> "placeholder="กรอกหมายเลขบัตรประชาชนของคุณ">
										</div>

										
									</div>	
									<div class="col-md-6">
										
										
										<div class="mb-3">
											<label for="control-label">เบอร์โทรศัพท์</label>
											<input  class="form-control" type="tel" id="phone" name="phone" placeholder="กรอกหมายเลขโทรศัพท์ของคุณ" value="<?php echo $tel; ?>">
										</div>

										<div class="mb-3">
											<label for="" class="control-label">ไลน์โทเค็น</label>
											<input type="text" name="tokenline" class="form-control" placeholder="กรอกไลน์โทเค็นของคุณ" value ="<?php echo $line_token ?>">
											<p class="small mb-0 mt-2"><b>Note:</b>หากต้องการเเจ้งได้รับการเเจ้งตื่อนผ่านไลน์อนุญาตโปรดกรอกไลน์โทเค็นของคุณ</p> 
											<p class="small mb-0 mt-2"><b>วิธีเอาโทเค็นไลน์ :</b><a href="procedure.php" target="_blank">คลิกที่นี่</a></p> 
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
											<a class="btn btn-secondary" type="button" href="index.php" >กลับ</a>
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
	}
	function Preview(ele) {
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