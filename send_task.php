<?php 
session_start();
 include 'connect.php';
 date_default_timezone_set('asia/bangkok');
 $date = date ("Y-m-d H:i");
 if (isset($_GET['task_id'])){
   
		
        $taskid =  $_REQUEST['task_id'];
        $project_id= $_REQUEST['project_id'];
        $user_id= $_REQUEST['user_id'];

        $stmttask = $db->prepare("SELECT *  ,concat(firstname,' ',lastname) as name  FROM task_list natural JOIN user  WHERE task_id = :id");
        $stmttask->bindParam(":id", $taskid);
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
    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="senddate" name="senddate" value=" ">
    <input type="hidden" id="state_details" name="state_details" value=" ">
    <input type="hidden" id="progress_task" name="progress_task" value=" ">
    <input type="hidden" id="user_id" name="user_id" value=" ">
  
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">ส่งงาน</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">ชื่องาน</label>
                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmttaskrrow['name_tasklist']?> " disabled>
                        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่สั่งงาน</label>
                            <input type="datetime-local" class="form-control" autocomplete="off" name="start_date" min="<?php echo $stmttaskrrow['strat_date_task'] ?>" value="<?php echo $stmttaskrrow['strat_date_task']?>" disabled >
                        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่ส่ง</label>
                            <input type="datetime-local" class="form-control"   autocomplete="off"   value="<?php echo $date; ?>" disabled>
                        
                        </div>
                    </div>
                    <div class="col-md-12">						  
                    </div>
                
                    <div class="col-md-12" >						
                        <div class="mb-3">
                                <div class="form-group">
                                    <label for="" class="control-label">ไฟล์เเนบ</label>	
                                    <input type="file" name="files[]" class="form-control streched-link" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple>
                                    <p class="small mb-0 mt-2"><b>รายละเอียด:รองรับไฟล์งาน .pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx </b></p> 
                                </div>
                    </div>
                    <div class="justify-content-center">
                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" name="text_comment" id="exampleFormControlTextarea1" rows="7"></textarea>
                          
                        </div>
                        <div class="mb-3">
                        </div>
                        <hr>
                        <div class="col-lg-12 text-right justify-content-center d-flex">
                            <button class="btn btn-primary " name ="edittask" onclick="send_task('<?php echo $taskid ?>','<?php echo $project_id?>','<?php echo $stmttaskrrow['progress_task'] ?>','<?php echo $user_id ?>');">ส่งงาน</button>
                            <a href="view_project.php?view_id=<?php echo $project_id?>" class="btn btn-secondary" type="button"  >กลับ</a>
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
     function send_task(taskid,project_id,progress_task,user_id){
        $('#proc').val('sendtask');
        $('#task_id').val(taskid);
        $('#project_id').val(project_id);
        $('#progress_task').val(progress_task);
        $('#user_id').val(user_id);
        $('#state_details').val('Y');
        $('#senddate').val('<?php echo $date?>');
        
    }
   
</script>
<?php include "footer.php"?>