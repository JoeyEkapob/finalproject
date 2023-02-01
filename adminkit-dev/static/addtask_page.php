
<?php 
    session_start();
    require_once 'connect.php';
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
            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                
                <main class="content"> 
                <div class="container-fluid p-0">
					<h1 class="h3 mb-3">เพิ่มงาน</h1>
				</div>
                    <div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ชื่องาน</label>
											<input type="text" name="proname" class="form-control form-control">
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ประเภทงาน</label>
												<select name="type" id="type" class="form-control">
													<option value="" >เลือกประเภทงาน</option>			
												 <option value=""></option>
                                                 <option value=""></option>
												</select>
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่สั่ง</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="">
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่เสร็จ</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="">
										</div>
                                    </div>
                                    <div class="col-md-6">						
                                    <div class="mb-3">
											<label for="" class="control-label">สมาชิกทีม</label>
												<select name="type" id="type" class="form-control">
													<option value="" >เลือกสมาชิก</option>			
												 <option value=""></option>
												</select>
										</div>
                                    </div>
                                    <div class="col-md-6">
										
                                    </div>
                                    <div class="col-md-8" >						
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
                    
                                    
                        







        </form>
    </body>
</html>

<?php include "footer.php"?>