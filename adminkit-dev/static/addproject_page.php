
<?php 
    session_start();
    require_once 'connect.php';
    //$user_id = $_SESSION['user_login'];
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
   /*  $managers = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where type = 2 order by concat(firstname,' ',lastname) asc ");
    $row= $managers->fetchAll();
    print_r ($row);
    exit;  */
      
       if(isset($_POST['addpro'])){
         print_r($_POST['users_id']); 

           $status1 = 1;
           $proname = $_POST['proname'];
           $users_id=$_POST['users_id'];
           $start_date = $_POST['start_date'];
           $end_date = $_POST['end_date'];
           $description =$_POST['description'];
           $manager_id=$_SESSION['user_login'];
           $status2=$_POST['inlineRadioOptions'];

           echo $proname;
           echo $start_date;
           echo $end_date;
           echo $description;
           echo $manager_id;
           echo $status2;

            /* $stmtpro = $db->prepare("INSERT INTO project(project_id, name_project, description, status, start_date, end_date, file_project, manager_id,id_jobtype,status_text) 
           VALUES(:proname, :description, :status, :start_date, :end_date,:file_project,:manager_id,:id_jobtype,:status_text)");
            $stmtpro->bindParam(":firstname", $proname);
            $stmtpro->bindParam(":description", $description);
            $stmtpro->bindParam(":status", $status);
            $stmtpro->bindParam(":start_date", $start_date);
            $stmtpro->bindParam(":end_date", $end_date);
            $stmtpro->bindParam(":file_project", $file_project);
            $stmtpro->bindParam(":manager_id", $manager_id);
            $stmtpro->bindParam(":id_jobtype", $id_jobtype);
            $stmtpro->execute(); */
           /*  $sql= "INSERT INTO `project`(`project_id`, `name_project`, `description`, `status`, `start_date`, `end_date`, `file_project`, `manager_id`)
            VALUES (null,$proname,$description,1,$start_date,$end_date,null,$user_id )" ;
           if $db->query($sql) === TRUE {
                $last_id = $conn->insert_id;
           }
              if(!empty($_POST['users_id'])){
                foreach ($_POST['users_id'] as $id => $users_id){
                $sql1="INSERT INTO `project_list`(`project_id`, `user_id`) VALUES ($last_id,$users_id)";
                $conn->query($sql1);
            
            }
        }     */
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
											<label for="" class="control-label" >ประเภทงาน</label>
												<select name="type" id="type" class="form-control" >
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
                                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="">
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่เสร็จ</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="end_date" value="">
										</div>
                                    </div>						
									
                                    <div class="col-md-6">
										<div class="mb-4">
											<label for="" class="control-label">สมาชิกทีมโครงการ</label>
												 <select  name="users_id[]" id="countries" multiple>	
                                                <?php
													$employees = $db->query("SELECT *, concat(firstname,' ',lastname) as name From user natural join position where  level> $level ORDER by level asc");
													$employees->execute();
													$result = $employees->fetchAll();
													foreach($result as $row) {
													?>
              	                                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['name'] ?></option>
                									<?php } ?>
												</select>  
                                           <?php// print_r ($result); ?>
										</div>
                                    </div>

                                    <div class="col-md-6">   
                                        <label for="" class="control-label">สถานะงาน</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">งานปกติ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">งานด่วน</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="3">
                                                    <label class="form-check-label" for="inlineRadio2">งานด่วนมาก</label>
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
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name ="description" rows="7"></textarea>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" name="addpro">ADD</button>
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
    new MultiSelectTag('countries')  // id
</script>
<script>
/* $(document).ready(function(){
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
       removeItemButton: true,
       maxItemCount:null,
       searchResultLimit:5,
       renderChoiceLimit:5
     });   
}); */
</script>
