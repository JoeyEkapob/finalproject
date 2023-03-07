<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['updatetask_id'])){
   
		
        $taskid =  $_REQUEST['updatetask_id'];
        $project_id= $_REQUEST['project_id'];

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
    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="file_item_task" name="file_item_task" value="">
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขงาน</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">ชื่องาน</label>
                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmttaskrrow['name_tasklist']?>">
                        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่สั่ง</label>
                            <input type="datetime-local" class="form-control" autocomplete="off" name="start_date" min="<?php echo $stmttaskrrow['strat_date_task'] ?>" value="<?php echo $stmttaskrrow['strat_date_task']?>" >
                        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่สิ้นสุด</label>
                            <input type="datetime-local" class="form-control"  autocomplete="off" name="end_date" value="<?php echo $stmttaskrrow['end_date_task']?>" >
                        
                        </div>
                    </div>
                    <div class="col-md-12">						
                    <div class="mb-3">
                            <label for="" class="control-label">สมาชิกทีม</label>
                                <select name="user" id="type" class="form-select">
                                <option value="<?php echo $stmttaskrrow['user_id'] ?>"><?php echo $stmttaskrrow['name'] ?></option>
                                <?php
                                    $stmtuser = $db->query("SELECT *, concat(firstname,' ',lastname) as name From project_list natural join user where project_id = $project_id");
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
                                    <input type="file" name="files[]" class="form-control streched-link" accept=".pdf, .jpg, .jpeg, .png" multiple>
                                    <?php 
                                                    $sql = "SELECT * FROM  file_item_task  WHERE task_id = $taskid";
                                                    $qry = $db->query($sql);
                                                    $qry->execute();
                                                    while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)) {  ?>
                                    <a><?php echo $row2['filename_task']?>
                                    <button    onclick="delfiletask('<?php echo $row2['file_item_task'] ?>','<?php echo $row2['task_id']?>','<?php echo $project_id?>');"><i data-feather="trash-2"></i></button>
                                    </a> 
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                    <div class="justify-content-center">
                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="7" name="textarea">  <?php echo  $stmttaskrrow['description_task']; ?>  
                        </textarea>
                          
                        </div>
                        <div class="mb-3">
                        </div>
                        <hr>
                        <div class="col-lg-12 text-right justify-content-center d-flex">
                            <button class="btn btn-primary " name ="edittask" onclick="edit_task('<?php echo $taskid ?>','<?php echo $project_id?>');">Edit</button>
                            <a href="view_project.php?view_id=<?php echo $project_id?>" class="btn btn-secondary" type="button"  >Cancel</a>
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
     function edit_task(taskid,project_id){
        $('#proc').val('edittask');
        $('#task_id').val(taskid);
        $('#project_id').val(project_id);
    }
    function delfiletask(file_item_task,taskid,project_id){
        $('#proc').val('delfiletask');
        $('#task_id').val(taskid);
        $('#file_item_task').val(file_item_task);
        $('#project_id').val(project_id);

    }
</script>
<?php include "footer.php"?>