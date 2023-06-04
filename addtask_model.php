<div class="modal fade bd-example-modal-lg" id="addModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> เพิ่มงาน </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="mb-3">
                            
                            <input type="hidden" name="pro_id" value =<?php echo $id ?> >
                            <span class="small mb-0 mt-2" style="color:red;">*</span> 

                            <label for="" class="control-label">ชื่องาน</label>
                            <input type="text" name="taskname" class="form-control">
                          
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="mb-3">
                        <span class="small mb-0 mt-2" style="color:red;">*</span> 
                            <label for="" class="control-label">วันที่สั่ง</label>
                            <input type="datetime-local" class="form-control " autocomplete="off" name="start_date" min="<?php echo $date ?>" value="<?php echo $date ?>">
                    
                        </div> 
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                        <span class="small mb-0 mt-2" style="color:red;">*</span> 

                            <label for="" class="control-label">วันที่เสร็จ</label>
                            <input type="datetime-local" class="form-control " autocomplete="off" name="end_date" value="" >
                        
                        </div>
                    </div>
                    <div class="col-md-12">						
                    <div class="mb-3">
                    <span class="small mb-0 mt-2" style="color:red;">*</span> 

                            <label for="" class="control-label">คนรับมอบหมายงาน</label>
                                <select name="user" id="type" class="form-select">
                                <?php
                                    $stmtuser = $db->query("SELECT *, concat(firstname,' ',lastname) as name From project_list natural join user where project_id = $id AND status_user = 1");
                                    $stmtuser->execute();
                                    $result = $stmtuser->fetchAll();
                                    foreach($result as $row) {
                                    ?>
                                    <option value="<?php echo $row['user_id'] ?>"><?php echo showshortname($row['shortname_id']).' '.$row['name'] ?></option>
                                    <?php } ?>
                                </select>  
                        </div>
                    </div>
                
                    <div class="col-md-12" >						
                        <div class="mb-3">
                                <div class="form-group">
                                    <label for="" class="control-label">ไฟล์เเนบ</label>	
                                    <div class="file-loading"> 
                                            <input id="input-b6b" name="files[]" type="file" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple>
                                    </div>
                                    <p class="small mb-0 mt-2"><b>รายละเอียด:</b>รองรับไฟล์งาน .pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx <b>ขนาดไฟล์ห้ามเกิน: 20 MB</b></p>  
                                </div>
                        </div>
                    </div>
                    <div class="justify-content-center">
                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="7" name="textarea"></textarea>
                        </div>
                        <div class="mb-3">
                        </div>
                        <hr>
                        <div class="col-lg-12 text-right justify-content-center d-flex">
                            <button class="btn btn-primary " name ="addtask_btn" id="addtask_btn1" onclick="add_task();" >เพิ่มงาน</button>
                            &nbsp;
                            <button class="btn btn-secondary" type="button"  data-bs-dismiss="modal" aria-label="Close">กลับ</button>
                        </div>
                    </div>
      </div>
      
    </div>
  </div>
</div>
