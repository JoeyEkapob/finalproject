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
											<label for="" class="control-label">First Name</label>
											<input type="text" name="firstname" class="form-control form-control" >
										</div>
										<div class="mb-3">
											<label for="" class="control-label">Last Name</label>
											<input type="text" name="lastname" class="form-control form-control" >
										</div>
										<div class="mb-3">
											<label for="" class="control-label" >User Role</label>
												<select name="type" id="type" class="form-control" >
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
												<label class="control-label">Email</label>
												<input type="email" class="form-control form-control" name="email" >
												<small id="#msg"></small>
											</div>
											<div class="mb-3">
												<label class="control-label">Password</label>
												<input type="password" class="form-control form-control" name="password">	
											</div>
											<div class="mb-3">
												<label class="label control-label">Confirm Password</label>
												<input type="password" class="form-control form-control" name="c_password">	
											</div>
									</div>
										<div class="mb-3">
											<div class="form-group">
												<label for="" class="control-label">Avatar</label>	
												<input type="file" name="file" class="form-control streched-link" accept="image/gif, image/jpeg, image/png">
												<p class="small mb-0 mt-2"><b>Note:</b> Only JPG, JPEG, PNG & GIF files are allowed to upload</p> 
											</div>
										</div>
										<div class="mb-4">
										
										</div>
										<hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">

											<button type="button" class="btn btn-primary" name="signup">Save</button>

											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					
			</main>
        
		
        </div>
    </div>
  </div>
</div>