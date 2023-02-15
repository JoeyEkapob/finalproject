<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['update_id'])){
    try {
		
        $taskid =  $_REQUEST['update_id'];
        $project_id= $_REQUEST['project_id'];

        $stmttask = $db->prepare("SELECT *  ,concat(firstname,' ',lastname) as name  FROM task_list natural JOIN user  WHERE task_id = :id");
        $stmttask->bindParam(":id", $taskid);
        $stmttask->execute();
        $stmttaskrrow = $stmttask->fetch(PDO::FETCH_ASSOC);
       
 

    } catch(PDOException $e) {
        $e->getMessage();
    }
}   
if(isset($_POST['edittask'])){
    
      
    $stat = 1 ;
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $taskname =$_POST['taskname'];
    $user=$_POST['user'];
    $textarea=$_POST['textarea'];
    $file_task = null;


    
    if (empty($taskname)) {
        $_SESSION['error'] = 'กรุณากรอกชื่องาน';
        header('location:view_project.php?view_id='.$pro_id);

     }else if (!isset($_SESSION['error'])) {
 
       $updatestmttask = $db->prepare("UPDATE task_list SET name_tasklist=:taskname, description_task=:textarea, status_task=:status, strat_date_task=:start_date, end_date_task=:end_date, file_task=:file_task, user_id=:users_id WHERE task_id = :id ");
       $updatestmttask->bindParam(":taskname", $taskname);
       $updatestmttask->bindParam(":textarea", $textarea);
       $updatestmttask->bindParam(":status", $stat);
       $updatestmttask->bindParam(":start_date", $start_date);
       $updatestmttask->bindParam(":end_date", $end_date);
       $updatestmttask->bindParam(":file_task",$file_task);
       //$stmttask->bindParam(":pro_id", $project_id);
       $updatestmttask->bindParam(":users_id",$user );
       $updatestmttask->bindParam(":id", $taskid);
       $updatestmttask->execute();   
       
     $_SESSION['success'] = "เพิ่มงานเรียบร้อย! ";
     header('location:view_project.php?view_id='.$project_id);
  
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด";
        header('location:view_project.php?view_id='.$project_id);
    
    } 
}


?> 


<!DOCTYPE html>
<html lang="en">
<form action="" method="post" enctype="multipart/form-data">
<?php include 'head.php'?> 
<body>
<?php include "sidebar.php"?>
		
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
                            <input type="hidden" name="pro_id" value =<?php //echo $taskid ?> >
                            <label for="" class="control-label">ชื่องาน</label>
                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmttaskrrow['name_tasklist']?>">
                        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่สั่ง</label>
                            <input type="datetime-local" class="form-control" autocomplete="off" name="start_date" value="<?php echo $stmttaskrrow['strat_date_task']?>" >
                        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="control-label">วันที่เสร็จ</label>
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
                                    <input type="file" name="file" class="form-control streched-link" accept="">
                                    <p class="small mb-0 mt-2"><b>Note:</b></p> 
                                </div>
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
                            <button class="btn btn-primary " name ="edittask">Edit</button>
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
<?php include "footer.php"?>