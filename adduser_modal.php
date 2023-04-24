<div class="modal fade bd-example-modal-lg" id="adduserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> เพิ่มสมาชิก </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        			<div class="modal-body">
						<div class="card">		
							<div class="card-body">
								<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="" class="control-label">ชื่อจริง</label>
												<input type="text" name="firstname" class="form-control " placeholder="กรอกชื่อของคุณ" >
											</div>
											<div class="mb-3">
												<label class="control-label">อีเมล</label>
												<input type="email" class="form-control " name="email" placeholder="กรอกอีเมลของคุณ">
												<small id="#msg"></small>
											</div>
											
											<div class="mb-3">
												<label class="control-label">รหัสผ่าน</label>
												<input type="password" class="form-control " name="password">
											</div>		
											<div class="mb-3">
												<label for="" class="control-label" >ตำเเหน่ง</label>
													<select name="role" id="role" class="form-select" >
														<?php
														$stmt = $db->query("SELECT * FROM position");
														$stmt->execute();
														$result = $stmt->fetchAll();
														foreach($result as $row) {
														?>
													<option value="<?= $row['role_id'];?>"><?= $row['position_name'];?></option>
														<?php } ?>
													</select>
											</div> 					
										</div>	
										<div class="col-md-6">
											<div class="mb-3">
												<label for="" class="control-label">นามสกุล</label>
												<input type="text" name="lastname" class="form-control" placeholder="กรอกนามสกุลของคุณ">
											</div>
											<!-- <div class="mb-3">
												<label for="control-label">Phone</label>
												<input  class="form-control" type="tel" id="phone" name="phone" placeholder="กรอกหมายเลขโทรศัพท์ของคุณ">
											</div>		
												 <div class="mb-3">
													<label class="control-label">Password</label>
													<input type="password" class="form-control form-control" name="password">	
												</div> -->
											<div class="mb-3">
												<label for="control-label">เบอร์โทรศัพท์</label>
												<input  class="form-control" type="tel" id="phone" name="phone" placeholder="กรอกหมายเลขโทรศัพท์ของคุณ">
											</div>
											<div class="mb-3">
												<label class="label control-label">ยืนยันรหัสผ่าน</label>
												<input type="password" class="form-control" name="c_password">	
											</div> 
											<div class="mb-3">
												<label for="control-label">เลขบัตรประชาชน</label>
												<input  class="form-control" type="tel" id="idcard" name="idcard" placeholder="กรอกหมายเลขบัตรประชาชนของคุณ">
											</div>
											

										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" role="switch" id="switch" name="switch"  checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">สถานะการใช้งาน</label>
												</div>	
											</div>	
											<div class="mb-3">
												<label for="" class="control-label">ไลน์โทเค็น</label>
												<input type="text" name="tokenline" class="form-control" placeholder="กรอกไลน์โทเค็นของคุณ">
												<p class="small mb-0 mt-2"><b>รายละเอียด :</b>หากต้องการเเจ้งได้รับการเเจ้งตื่อนผ่านไลน์อนุญาตโปรดกรอกไลน์โทเค็นของคุณ</p> 
												<p class="small mb-0 mt-2"><b>วิธีเอาโทเค็นไลน์ :</b><a href="procedure.php" target="_blank">คลิกที่นี่</a></p> 
											</div>
											
											<div class="user-image mb-3 text-center">
												<img class="rounded-circle rounded me-2 mb-2" id="img"  src="img/avatars/09.jpg" width="150"  height="150">
											</div>
										</div>
										
											<div class="mb-3">
												<div class="form-group">
													<label for="" class="control-label">รูปภาพ</label>	
													<input type="file" name="file" class="form-control streched-link" accept="image/jpeg,image/png,image/jpg" onchange="Preview(this)">
													<p class="small mb-0 mt-2"><b>รายละเอียด :</b>อนุญาตให้อัปโหลดเฉพาะไฟล์ JPG, JPEG, PNG </p> 
												</div>
											</div>
											<div class="mb-4">
											
											</div>
											<hr>
											<div class="col-lg-12 text-right justify-content-center d-flex">
												<button class="btn btn-primary" name="signup" onclick="adduser()">บันทึก</button>
												<button class="btn btn-secondary" type="button"  data-bs-dismiss="modal" aria-label="Close">กลับ</button>
											</div>
							</div>
						</div>
					</div>
				</div>
        
		
		</div>	 
	</div>
</div>