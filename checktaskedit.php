<?php 
session_start();
 include 'connect.php';
 date_default_timezone_set('asia/bangkok');
 $date = date ("Y-m-d H:i");
 if (isset($_GET['details_id'])){
   
        $details_id = $_GET['details_id'];
        $taskid =  $_GET['task_id'];
        $project_id= $_GET['project_id'];
        $progress_task= $_GET['progress_task'];

        $stmttask = $db->prepare("SELECT *  ,concat(firstname,' ',lastname) as name  FROM details natural JOIN task_list natural JOIN project natural JOIN user  WHERE details_id = :details_id");
        $stmttask->bindParam(":details_id", $details_id);
        $stmttask->execute();
        $stmttaskrrow = $stmttask->fetch(PDO::FETCH_ASSOC);
    }   

?> 
<!DOCTYPE html>
<html lang="en">
    <form action="proc.php" method="post" class="form-horizontal" enctype="multipart/form-data">
    <?php include 'head.php'?> 
    <body>
    <?php include "sidebar.php"?>
    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="details_id" name="details_id" value="">
    <input type="hidden" id="senddate" name="senddate" value=" ">
   <input type="hidden" id="state_details" name="state_details" value=""> 
   <input type="hidden" id="progress_task" name="progress_task" value=""> 
   
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">ส่งงานกลับเเก้</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">ชื่อหัวข้องาน</label>
                                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmttaskrrow['name_project']?> " disabled>
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">ชื่องาน</label>
                                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmttaskrrow['name_tasklist']?> " disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">วันที่ส่งงาน</label>
                                            <input type="datetime-local" class="form-control" autocomplete="off" name="date1" value="<?php echo $stmttaskrrow['date_detalis']?>" disabled >
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">วันที่ส่งกลับเเก้ไข</label>
                                            <input type="datetime-local" class="form-control"   autocomplete="off" name="date_detalis"  value="<?php echo $date; ?>" disabled>
                                        
                                        </div>
                                    </div>
                                   <!--  <div class="justify-content-center">
                                        <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                        <textarea class="form-control" name="text_comment" id="exampleFormControlTextarea1" rows="7" disabled> <?php// echo $stmttaskrrow['comment']?></textarea>
                                    </div> -->
                                    <div class="col-md-12">						  
                                    </div>

                                    <div class="col-md-6">						
                                        <div class="mb-3">
                                        
                                            <label for="" class="control-label">ความคืบหน้า</label>
                                            <select class="form-select" aria-label="Default select example" name ="progress">
                                                <option selected>กรุณากรอกความคืบหน้า</option>
                                                <option value="10">10%</option>
                                                <option value="20">20%</option>
                                                <option value="30">30%</option>
                                                <option value="40">40%</option>
                                                <option value="50">50%</option>
                                                <option value="60">60%</option>
                                                <option value="70">70%</option>
                                                <option value="80">80%</option>
                                                <option value="90">90%</option>
                                            </select>
                                          
                                        </div>    
                                    </div>

                                    <div class="col-md-6" >						
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="" class="control-label">ไฟล์เเนบ</label>	
                                                <input type="file" name="files[]" class="form-control streched-link" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="justify-content-center">
                                        <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                        <textarea class="form-control" name="text_comment" id="exampleFormControlTextarea1" rows="7" ></textarea>
                                    </div>
                        <div class="mb-3">
                        </div>
                        <hr>
                        <div class="col-lg-12 text-right justify-content-center d-flex">
                            <button class="btn btn-primary " name ="edittask" onclick="send_edittask('<?php echo $taskid ?>','<?php echo $project_id?>','<?php echo $details_id?>','<?php echo $progress_task?>');">Send</button>
                            <a href="checktask_list.php" class="btn btn-secondary" type="button">Cancel</a>
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
<script>
     function send_edittask(taskid,project_id,details_id,progress_task){
        $('#proc').val('send_edittask');
        $('#task_id').val(taskid);
        $('#project_id').val(project_id);
        $('#details_id').val(details_id);
        $('#progress_task').val(progress_task);
        $('#state_details').val('N');
        $('#senddate').val('<?php echo $date?>');
        
    }
   
</script>
<?php include "footer.php"?>