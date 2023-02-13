<form action="edituser.php" method="post" enctype="multipart/form-data">
<div class="modal fade" id="viewusermodal<?php echo $row['user_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> รายละเอียด <?php echo ucwords($row['name']) ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <div class="modal-body">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                  <div class="col-md-12">
                      <div class="text-center">
                          <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $row['avatar']?>" alt="Avatar" width="200"  height="200">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="" class="control-label">ชื่อ : </label>
                        <?php echo $row['name'] ?>
                      </div>
                      <div class="mb-3">
                        <label for="" class="control-label">อีเมล</label>
                        <?php echo $row['email'] ?>
                      </div>
                      <div class="mb-3">
                        <label for="" class="control-label">ตำเเหน่ง</label>
                        <?php echo $row['position_name'] ?>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       <!--  <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

