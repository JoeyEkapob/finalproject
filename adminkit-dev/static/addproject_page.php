
<?php 
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
   /*  $managers = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where type = 2 order by concat(firstname,' ',lastname) asc ");
    $row= $managers->fetchAll();
    print_r ($row);
    exit; */
?>
<!DOCTYPE html>
<html lang="en">
        <?php include "head.php"?>
    <body>
        <?php include "sidebar.php"?>
            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                
                <main class="content"> 
                <div class="container-fluid p-0">
					<h1 class="h3 mb-3">เพิ่มโปรเจค</h1>
				</div>
                    <div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ชื่อโปรเจค</label>
											<input type="text" name="proname" class="form-control">
										</div>
                                    </div>
                                 
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">สมาชิกทีมโครงการ</label>
												 <select  class="form-control"  name="users_id[]" id="choices-multiple-remove-button" multiple >	
                                                <?php
													$employees = $db->query("SELECT * ,concat(firstname,' ',lastname) as name FROM user AS u 
                                                    LEFT JOIN position AS p ON u.role_id = p.role_id 
                                                    where p.level > $level
                                                    ORDER by level asc");
													$employees->execute();
													$result = $employees->fetchAll();
													foreach($result as $row) {
													?>
              	                                    <option value="<?php echo $row['user_id'] ?>" <?php echo isset($users_id) && in_array($row['user_id'],explode(',',$users_id)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                									<?php } ?>
												</select>  
                                           <?php// print_r ($result); ?>
										</div>
                                    </div>
                                 
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่สั่ง</label>
                                            <input type="date" class="form-control form-control" autocomplete="on" name="start_date" value="">
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่เสร็จ</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="">
										</div>
                                    </div>						
									<div class="mb-3">
											<div class="form-group">
												<label for="" class="control-label"></label>	
												<input type="file" name="file" class="form-control streched-link" accept="">
												<p class="small mb-0 mt-2"><b>Note:</b></p> 
											</div>
                                    </div>
                                    
                                    <div class="justify-content-center">
                                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="7"></textarea>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="signup">ADD</button>
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
    
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
       removeItemButton: true,
       maxItemCount:null,
       searchResultLimit:5,
       renderChoiceLimit:5
     }); 
    
    
});

</script>