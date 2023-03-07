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
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo $row2['progress_task'] ?>%" ><?php echo $row2['progress_task'] ?></div>
                                                            </div>
                                                       
                                                    </dd> 


                                                </dl>
                                                <dl>
                                                        <dt>
                                                            <b class="border-bottom border-primary">ผู้สร้างงาน</b>
                                                        </dt>
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
                                                    <dd><?php echo ThDate($row2['start_date']).'<br>'.$row2['start_time']  ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันสิ้นสุดเเละเวลาสิ้นสุด</b></dt>
                                                    <dd><?php echo ThDate($row2['end_date']).'<br>'.$row2['end_time']  ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                    <dd>
                                                    <?php  
                                               showstattask($row2['status_task']); 
                                               ?>
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
                                            <?php 
                                                $task_id=$row2['task_id'];
                                                    $sql = "SELECT * FROM project NATURAL JOIN file_item_task WHERE task_id = $task_id";
                                                    $qry = $db->query($sql);
                                                    $qry->execute();
                                                    while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)) {  ?>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <a href="proc.php?proc=download&file_item_task=<?php echo $row2['file_item_task']?>"><?php echo $row2['filename_task']?></a> 
                                                    
                                                    </div>
                                                </div>
                                            <?php } ?>
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

