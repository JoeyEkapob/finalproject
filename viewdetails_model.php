<div class="modal fade" id="viewdetailsmodal<?php echo $row['details_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <dt><b class="border-bottom border-primary"> ชื่องาน </b> <?php echo showstatustime($row['status_timetask']) ?></b></dt>
                                                    <dd><?php echo $row['name_tasklist'] ?></dd>

                                                    <dt><b class="border-bottom border-primary">คำอธิบาย</b></dt>
                                                    <dd><?php echo $row['comment']  ?></dd>

                                                 <dt><b class="border-bottom border-primary mb-3">ความคืบหน้า</b></dt>
                                                    <dd>
                                                        <div class="mb-3">     
                                                        </div>
                                                            <div class="progress" style="height: 20px;width:250px;" >
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo $row['progress_task'] ?>%"><?php echo $row['progress_task'] ?></div>
                                                            </div>
                                                       
                                                    </dd> 


                                                </dl>
                                                <dl>
                                                        <dt>
                                                            <b class="border-bottom border-primary">ผู้สร้างงาน</b>
                                                        </dt>
                                                        <dd> 
                                                            <div class="d-flex align-items-center mt-1">
                                                            <?php if($row['avatar'] !=""){?>
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $manager['avatar']?>" alt="Avatar" width="35"  height="35">
                                                                <b><?php echo $manager['name'] ?> </b>
                                                            <?php }else{ ?>
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                                                                <b><?php echo $manager['name'] ?> </b>
                                                            <?php } ?>
                                                                
                                                            </div>  
                                                        </dd>
                                                </dl> 
                                        </div>

                                            <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันที่สิ้นสุดงาน</b></dt>
                                                    <dd><?php echo thai_date_and_time($row['end_date_task'])  ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">เวลาที่ส่งงานมา</b></dt>
                                                    <dd><?php echo thai_date_and_time($row['date_detalis']) ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                    <dd>
                                                    <?php  
                                               showstattask($row['status_task']); 
                                               ?>
                                                    </dd>
                                                </dl>
                                                <dl>
                                                    
                                                    <dt><b class="border-bottom border-primary">ผู้ส่งงาน</b></dt>
                                                    <dd>
                                                    <?php if($row['avatar'] !=""){?>
                                                        <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $row['avatar']?>" alt="Avatar" width="35"  height="35">
                                                        <b><?php  echo $row['firstname']." ".$row['lastname'] ?></b>
                                                    <?php }else{ ?>
                                                        <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                                                        <b><?php  echo $row['firstname']." ".$row['lastname'] ?></b>
                                                    <?php } ?>
                                                   
                                            
                                                    </dd>
                                                </dl> 
                                            </div>
                                            
                                            <div class="col-md-12">
                                            <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>
                                            <?php 
                                               $details_id=$row['details_id'];
                                                    $sql_filedetails = "SELECT * FROM details NATURAL JOIN file_item_details WHERE details_id = $details_id";
                                                    $qryfiledetails = $db->query($sql_filedetails);
                                                    $qryfiledetails->execute();
                                                       while ($row2 = $qryfiledetails->fetch(PDO::FETCH_ASSOC)) {   ?>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                     <!-- <a href="proc.php?proc=download&file_item_details=<?php echo $row2['file_details_id']?>"><?php echo $row2['filename_details']?></a>  -->
                                                    <a href="img/file/file_details/<?php echo $row2['newname_filedetails']; ?>" download="<?php echo $row2['filename_details']?>"><?php echo $row2['filename_details']?></a> 
                                                        
                                                        </div>
                                                    </div>  
                                            <?php   }    ?> 
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div> 			
                   
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">กลับ</button>
       <!--  <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

