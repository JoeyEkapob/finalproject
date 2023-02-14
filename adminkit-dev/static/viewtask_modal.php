<div class="modal fade" id="viewtaskmodal<?php echo $row2['task_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> รายละเอียด <?php  ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <div class="modal-body">
        <div class="col-12  d-flex">
                         <div class="card flex-fill">  
                             <div class="card-header">
                                 <div class="row">
                                    <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">ชื่องาน</b></dt>
                                                    <dd><?php echo $row2['name_tasklist'] ?></dd>

                                                    <dt><b class="border-bottom border-primary">คำอธิบาย</b></dt>
                                                    <dd><?php echo $row2['description_task']  ?></dd>

                                                 <dt><b class="border-bottom border-primary mb-3">ความคืบหน้า</b></dt>
                                                    <dd>
                                                        <div class="mb-3">
                                                        </div>
                                                            <div class="progress" style="height: 20px;width:250px;" >
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated-sm" role="progressbar" style="width: 10%" width=""  >0</div>
                                                            </div>
                                                       
                                                    </dd> 


                                                </dl>
                                                <dl>

                                                    

                                                    <dt><b class="border-bottom border-primary">ผู้สร้างงาน</b></dt>
                                                    <dd> 
                                                         <div class="d-flex align-items-center mt-1">
                                                            <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $manager['avatar']?>" alt="Avatar" width="35"  height="35">
                                                            <b><?php echo $manager['name'] ?> </b>
                                                        </div>
                                                    </dd>

                                                </dl> 
                                        </div>

                                            <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันที่เริ่มเเละเวลาเริ่ม</b></dt>
                                                    <dd><?php echo $row2['start_date'].''.$row2['start_time']  ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันสิ้นสุด</b></dt>
                                                    <dd><?php echo $row2['end_date'].''.$row2['end_time']  ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                    <dd>
                                                    <?php  
                                                if($row2['status_task'] =='1'){
                                                echo "<span class='badge bg-secondary'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='2'){
                                                echo "<span class='badge bg-primary'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='3'){
                                                echo "<span class='badge bg-success'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='4'){
                                                echo "<span class='badge bg-warning'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='5'){
                                                echo "<span class='badge bg-danger'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='6'){
                                                echo "<span class='badge bg-danger'>".$stat1[$row2['status_task']]."</span>";
                                            } ?>
                                                    </dd>
                                                </dl>
                                                <dl>
                                                    
                                                    <dt><b class="border-bottom border-primary">สมาชิก</b></dt>
                                                    <dd>

                                                    <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $row2['avatar']?>" alt="Avatar" width="35"  height="35">
                                                    <b><?php  echo $row2['firstname']." ".$row2['lastname'] ?></b>
                                            
                                                    </dd>
                                                </dl> 
                                            </div>
                                            <div class="col-md-12">
                                            <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>
                                            <div class="d-flex align-items-center mt-1">
                                             <b></b>
                                        </div>
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

