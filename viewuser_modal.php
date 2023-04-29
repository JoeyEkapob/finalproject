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
                                        <?php if($row['avatar'] != ""){?>
                                            <img class="rounded-circle rounded me-5 mb-2" src="img/avatars/<?php echo $row['avatar']?>" alt="Avatar" width="200"  height="200">
                                        <?php }else{ ?>
                                            <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="200"  height="200">
                                        <?php } ?>
                                      </div>
                                  </div>
                                  <div class="col-md-1">
                                  </div> 
                                  <div class="col-md-6">
                                          <div class="mb-3">
                                            <label for="" class="control-label"><b>ชื่อ : </b></label>
                                            <?php echo $row['name'] ?>
                                          </div>
                                          <div class="mb-3">
                                            <label for="" class="control-label"><b>อีเมล :</b></label>
                                            <?php echo $row['email'] ?>
                                          </div>
                                          <div class="mb-3">
                                            <label for="" class="control-label"><b>ตำเเหน่ง :</b></label>
                                            <?php echo $row['position_name'] ?>
                                          </div>
                                          <div class="mb-3">
                                          <label for="" class="control-label"><b>ฝ่าย :</b></label>
                                          <?php echo $row['idcard'] ?>
                                      </div>
                                        </div> 
                                        
                                  <div class="col-md-5">
                                      <div class="mb-3">
                                        <label for="" class="control-label"><b>สถานะ :</b></label>
                                        <?php   if($row['status_user'] == 1){
                                                  echo "เปิดใช้งาน";
                                                }else{
                                                echo "ปิดใช้งาน";
                                                } ?>
                                      </div>
                                      <div class="mb-3">
                                        <label for="" class="control-label"><b>เบอร์ :</b></label>
                                        <?php echo $row['tel'] ?>
                                      </div>
                                      <div class="mb-3">
                                        <label for="" class="control-label"><b>เลขบัตรประชาชน :</b></label>
                                        <?php echo $row['idcard'] ?>
                                      </div>
                                     
                                  </div> 
                                  <hr>
                                  <div class="col-md-12">
                                  


                                  <?php   $sql2 = $db->query("SELECT manager_id FROM project WHERE manager_id =  $user_id"); 
                                          $nummannagerpro = $sql2->rowCount(); 
                                          $sql3 = $db->query("SELECT user_id FROM project_list where user_id = $user_id");
                                          $numuserpro = $sql3->rowCount(); 
                                          $sql4 = $db->query("SELECT user_id FROM task_list where user_id = $user_id ");
                                          $numusertask = $sql4->rowCount(); 
                                          $sql5 = $db->query("SELECT * FROM task_list  where user_id = $user_id  AND status_task != 5 AND progress_task != 100");
                                          $numtaskonp = $sql5->rowCount(); 
                                          $sql6 = $db->query("SELECT * FROM task_list  where user_id = $user_id  AND status_timetask = 2 AND status_task != 5 AND progress_task != 100");
                                          $numtimede = $sql6->rowCount() ; 
                                          ?>
                                         <div class="containeruser">
                                            <div class="item">หัวข้องานที่สร้าง</div>
                                            <div class="item">หัวข้องานที่ถูกสั่ง</div>
                                            <div class="item">งานทังหมด</div>
                                            <div class="item">งานที่ยังไม่เสร็จ</div>
                                            <div class="item">งานที่ล่าช้า</div>
                                          </div>
                                          <div class="containeruser">
                                            <div class="item"><?php echo  $nummannagerpro ?></div>
                                            <div class="item"><?php echo  $numuserpro ?></div>
                                            <div class="item"><?php echo  $numusertask ?></div>
                                            <div class="item"><?php echo  $numtaskonp   ?></div>
                                            <div class="item"><?php echo $numtimede ?></div>
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

