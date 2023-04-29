<div class="modal fade bd-example-modal-lg" id="adddepartment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> เพิ่มชื่อฝ่าย </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      

				
            <div class="modal-body">
                <div class="card">		
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="control-label">ชื่อฝ่าย</label>
                                        <input type="text" name="namedepartmant" class="form-control form-control" >
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-12 text-right justify-content-center d-flex">
                                    <button class="btn btn-primary"  onclick="adddepartment()">เพิ่มฝ่าย</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">กลับ</button>
                                      
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        
    
        </div>	
    </div>
  </div>



<div class="modal fade bd-example-modal-lg" id="addjobtype" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> เพิ่มเประเภทงาน </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      

				
            <div class="modal-body">
                <div class="card">		
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="control-label">ชื่อประเภทงาน</label>
                                        <input type="text" name="namejob" id="namejob" class="form-control form-control" >
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-12 text-right justify-content-center d-flex">
                                <button class="btn btn-primary"  onclick="addjob()">เพิ่มประเภท</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">กลับ</button>
                                    
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        
    
        </div>	
    </div>
  </div>

  <div class="modal fade bd-example-modal-lg" id="addposition" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> เพิ่มเประเภทงาน </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      

				
            <div class="modal-body">
                <div class="card">		
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="control-label">ชื่อตำเเหน่ง</label>
                                        <input type="text" name="nameposition" class="form-control form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="control-label">ระดับ</label>
                                            <select select  name="level"  id="level" class="form-select"  >
                                            <?php
                                                  $stmt = $db->query("SELECT DISTINCT level FROM position WHERE position_status = 1");
                                                  $numrow = $stmt->rowCount();
                                                  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                  foreach($results as $row) {
                                              ?>
                                                  <option value="<?= $row['level']; ?>"><?= $row['level']; ?></option>
                                                  
                                              <?php } ?>
                                              <option value="<?= $numrow +1 ?>"><?= $numrow +1 ?></option>
                                            </select>  
                                           
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-12 text-right justify-content-center d-flex">
                                <button class="btn btn-primary"  onclick="addposition()">เพิ่มตำเเหน่ง</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">กลับ</button>
                                    
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        
    
        </div>	
    </div>
  </div>