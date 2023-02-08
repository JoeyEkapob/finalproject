<div class="modal fade bd-example-modal-lg" id="addModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> ADD TASK </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <input type="hidden" name="pro_id" value =<?php echo $id ?> >
                            <label for="" class="control-label">ชื่องาน</label>
                            <input type="text" name="taskname" class="form-control form-control"   >
                        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่สั่ง</label>
                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="" >
                        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่เสร็จ</label>
                            <input type="date" class="form-control form-control" autocomplete="off" name="end_date" value="" >
                        
                        </div>
                    </div>
                    <div class="col-md-12">						
                    <div class="mb-3">
                            <label for="" class="control-label">สมาชิกทีม</label>
                                <select name="user" id="type" class="form-control">
                                <?php
                                    $stmtuser = $db->query("SELECT *, concat(firstname,' ',lastname) as name From project_list natural join user where project_id = $id");
                                    $stmtuser->execute();
                                    $result = $stmtuser->fetchAll();
                                    foreach($result as $row) {
                                    ?>
                                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['name'] ?></option>
                                    <?php } ?>
                                </select>  
                        </div>
                    </div>
                
                    <div class="col-md-12" >						
                        <div class="mb-3">
                                <div class="form-group">
                                    <label for="" class="control-label">ไฟล์เเนบ</label>	
                                    <input type="file" name="file" class="form-control streched-link" accept="">
                                    <p class="small mb-0 mt-2"><b>Note:</b></p> 
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
                            <button class="btn btn-primary " name ="addtask_btn">ADD</button>
                            <button class="btn btn-secondary" type="button" aria-label="Close">Cancel</button>
                        </div>
                    </div>
      </div>
      
    </div>
  </div>
</div>
