
<?php 
    session_start();
    require_once 'connect.php';
    //$user_id = $_SESSION['user_login'];
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
  
      
       
?> 
<!DOCTYPE html>
<html lang="en">
        <?php include "head.php"?>
    <body>
        <?php include "sidebar.php"?>
        <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <form action="addproject.php" method="post" class="form-horizontal" enctype="multipart/form-data">
          
     
                <main class="content"> 
                <div class="container-fluid p-0">
					<h1 class="h3 mb-3">หัวข้องาน</h1>
				</div>
                    <div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">หัวข้องาน</label>
											<input type="text" name="proname" class="form-control"  >
										</div>
                                    </div>
                                 
                                    <div class="col-md-6">
                                    <div class="mb-3">
											<label for="" class="control-label" >ประเภทงาน</label>
												<select name="job" id="type" class="form-control"  >
													<?php
													$stmt = $db->query("SELECT * FROM job_type WHERE status = 1");
													$stmt->execute();
													$result = $stmt->fetchAll();
													foreach($result as $row) {
													?>
												 <option value="<?= $row['id_jobtype'];?>"><?= $row['name_jobtype'];?></option>
                									<?php } ?>
												</select>
										</div> 		
                                    </div>
                                 
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่สั่ง</label>
                                            <input type="date" class="form-control " autocomplete="off" name="start_date" value=""  >
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่เสร็จ</label>
                                            <input type="date" class="form-control " autocomplete="off" name="end_date" value=""  >
										</div>
                                    </div>						
									
                                    
                                    <div class="col-md-6">
										<div class="mb-4">
											<label for="" class="control-label">สมาชิกทีมโครงการ</label>
                                            <input type="text" class="form-control" name="users_id[]"  id="user_id" data-access_multi_select="true" placeholder="&amp;">
                                            
                                               
										</div>
                                    </div>

                                    <div class="col-md-6">   
                                    <div class="mb-4">
											<label for="" class="control-labe">สถานะงาน</label>
												 <select  name="status2" class="form-control"  >
                                                 
              	                                    <option value="1">งานปกติ</option>
                                                    <option value="2">งานด่วน</option>
                                                    <option value="3">งานด่วนมาก</option>
                								
												</select>  
                                           <?php// print_r ($result); ?>
										</div>
                                        </div>




                                    <div class="mb-3">
											<div class="form-group">
												<label for="" class="control-label">ไฟล์เเนบ</label>	
												<input type="file" name="file" class="form-control streched-link" accept="">
												<p class="small mb-0 mt-2"><b>Note:</b></p> 
											</div>
                                    </div>
                                   

                                    
                                    <div class="justify-content-center">
                                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name ="description" rows="7"></textarea>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
                                        
											<button class="btn btn-primary"  id="display_selected" name="addpro">ADD</button>
											<button class="btn btn-secondary" type="button" >Cancel</button>
										</div>
                                       

                                    </div>
                                </div> 	
							</div>
                        </div> 		 		
					</div>
            </main>  
        </form>
    </body>
</html>
<?php include "footer.php"?>
<script>
$(document).ready(function(){
    var data=[];
    var items = [];
    
      <?php
      $employees = $db->query("SELECT *, concat(firstname,' ',lastname) as name From user natural join position where  level>  $level ORDER by level asc");
      $employees->execute();
      $result = $employees->fetchAll();
      foreach($result as $row) {?>
        items.push({value:<?php echo $row['user_id'];?>,text:'<?php echo $row['name'];?>'});
    <?php  } ?>
 
        var select = $('[data-access_multi_select="true"]').check_multi_select({
            multi_select: true,
            items: items,
            rtl: false
        });
        // Display the selected Values
        $('#display_selected').click(function () {
            $('#user_id').val(select.check_multi_select('fetch_country'));
            //alert(select.check_multi_select('fetch_country'))
            console.log($('#user_id').val());
        });
    });
    /*var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
       removeItemButton: true,
       maxItemCount:null,
       searchResultLimit:5,
       renderChoiceLimit:5
     });   */
</script>

