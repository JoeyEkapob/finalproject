<?php 
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }

    $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    
    if (isset($_GET['update_id'])){
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * ,concat(firstname,' ',lastname) as name FROM project natural JOIN project_list natural JOIN job_type natural JOIN user  WHERE project_id = :id");
            $select_stmt->bindParam(":id", $id);
            $select_stmt->execute();
            $row2 = $select_stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }   
      
       
if(isset($_POST['editpro'])){
    
      $id1=$_POST['editpro'];
      $status1 = 1;
      $proname = $_POST['proname'];
      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
      $description =$_POST['description'];
      $manager_id=$_SESSION['user_login'];
      $status2=$_POST['status2'];
      $file_project = null;
      $job = $_POST['job'];
      $users_id1 = $_POST['users_id'];
      
      $users_id = explode(",", $users_id1);
     // $user_string = "(" . implode(",",$users_id) . ")";
   /*   echo $users_id1;
     exit; */
    



   if (!empty($users_id1)) {
    $update_stmtpro = $db->prepare('UPDATE project SET name_project=:name_project,description= :description,status_1=:status_1,start_date= :start_date,end_date=:end_date
    ,status_2=:status_2,id_jobtype=:id_jobtype WHERE project_id =:id');
    $update_stmtpro->bindParam(":name_project", $proname);
    $update_stmtpro->bindParam(":description", $description);
    $update_stmtpro->bindParam(":status_1", $status1);
    $update_stmtpro->bindParam(":start_date", $start_date);
    $update_stmtpro->bindParam(":end_date", $end_date);
    //$update_stmtjob->bindParam(":file_project",$file_project);
    //$update_stmtjob->bindParam(":manager_id", $manager_id);
    $update_stmtpro->bindParam(":status_2", $status2);
    $update_stmtpro->bindParam(":id_jobtype", $job);
    $update_stmtpro->bindParam(":id",$id1);
    $update_stmtpro->execute(); 

    $sql = "DELETE FROM task_list WHERE project_id = :project_id AND user_id NOT IN ($users_id1)";
    $delete_stmttask = $db->prepare($sql);
    $delete_stmttask->bindParam(":project_id", $id1);
    $delete_stmttask->execute();
   
    $delete_stmtprojectlist = $db->prepare('DELETE FROM project_list WHERE project_id=:id');
    $delete_stmtprojectlist->bindParam(":id",$id1);
    $delete_stmtprojectlist->execute(); 
     
   
   
    foreach ($users_id as $id => $users_id){
    $inser_stmtprolist= $db->prepare("INSERT INTO project_list(project_id,user_id) VALUES(:project_id,:user_id)");
    $inser_stmtprolist->bindParam(":project_id", $id1 );
    $inser_stmtprolist->bindParam(":user_id", $users_id );
    $inser_stmtprolist->execute(); 
            }

        $_SESSION['success'] = "เเก้ไขเรียบร้อย! ";
        header("location: project_list.php");
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: project_list.php");
        } 
    }


?> 
<!DOCTYPE html>
<html lang="en">
        <?php include "head.php"?>
    <body>
        <?php include "sidebar.php"?>
        <form action="editproject_page.php" method="post" class="form-horizontal" enctype="multipart/form-data">
        
                <main class="content"> 
                <div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขโปรเจค</h1>
				</div>
                    <div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ชื่อโปรเจค</label>
											<input type="text" name="proname" class="form-control"  value="<?php echo $row2['name_project']; ?>">
										</div>
                                    </div>
                                 
                                    <div class="col-md-6">
                                    <div class="mb-3">
											<label for="" class="control-label" >ประเภทงาน</label>
												<select name="job" id="type" class="form-control"  >
                                                <option value="<?php  echo $row2['id_jobtype']; ?>" ><?php  echo $row2['name_jobtype']; ?></option>
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
                                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="<?php echo $row2['start_date']; ?>"  >
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่เสร็จ</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="end_date" value="<?php echo $row2['end_date']; ?>"  >
										</div>
                                    </div>						
									
                                    <div class="col-md-6">
										<div class="mb-4">
											<label for="" class="control-label">สมาชิกทีมโครงการ</label>
                                            <input type="text" class="form-control" name="users_id" id="user_id"  data-access_multi_select="true" placeholder="">
                                                
              	                                
										</div>
                                    </div>

                                    <div class="col-md-6">   
                                    <div class="mb-4">
											<label for="" class="control-label">สมาชิกทีมโครงการ</label>
												 <select  name="status2" class="form-control"  >
                                                 <option value="<?php  echo $row2['status_2']; ?>" ><?php echo  $stat2[$row2['status_2']]; ?></option>	
              	                                    <option value="1">งานปกติ</option>
                                                    <option value="2">งานด่วน</option>
                                                    <option value="3">งานด่วนมาก</option>
												</select>  
                                           <?php// print_r ($result); ?>
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
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name ="description" rows="7">
                                            <?php echo  $row2['description']; ?>  
                                            </textarea>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" id="display_selected" name="editpro" value=<?php echo  $id; ?>>EDIT</button>
											<a class="btn btn-secondary" href="project_list.php" type="button" >Cancel</a>
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
        items.push({value:<?php echo $row['user_id'];?>,text:'<?php echo $row['name'];?><?php echo " ( ";?><?php echo $row['position_name'];?><?php echo " ) ";?>'});
    <?php  } ?>
    <?php  
      $id = $_REQUEST['update_id'];
      $select_stmt1 = $db->prepare("SELECT * from project_list WHERE project_id = :id");
      $select_stmt1->bindParam(":id", $id);
      $select_stmt1->execute();
      $row21 = $select_stmt1->fetchAll();
      foreach( $row21 as $rowa) {?>
           data.push(<?php echo $rowa['user_id'];?>);
      <?php  } ?>
        var select = $('[data-access_multi_select="true"]').check_multi_select({
            multi_select: true,
            items: items,
            defaults: data,
            rtl: false
        });
        $('#display_selected').click(function () {
            $('#user_id').val(select.check_multi_select('fetch_country'));
            alert(select.check_multi_select('fetch_country'))
            console.log($('#user_id').val());
        });
    });
</script>
