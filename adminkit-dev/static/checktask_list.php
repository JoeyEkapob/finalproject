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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css" 
<?php include "sidebar.php"?>
<?php include "funtion.php"?>
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

<form action="proc.php" method="post" class="form-horizontal" enctype="multipart/form-data">

    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="details_id" name="details_id" value="">
    <main class="content">
    
           
                 
                          
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">รายการโปรเจค</h5>
                        </div>
                            <table class="table table-hover my-0" id="example" >
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-left">ชื่อโปรเจค</th>
                                        <th class="text-left">ชื่องาน</th>
                                        <th class="text-center">วันที่สั่งงาน</th>
                                        <th class="text-center">วันที่ส่ง</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        $where = "";    
                                        if($row['level'] >= 3 ){
                                            $where = " where manager_id = '{$_SESSION['user_login']}' AND state_details	= 'y'";   
                                        }else{
                                            $where = " where state_details	= 'y'";
                                        }
                                       /*  $numsql ="SELECT COUNT(task_id) as numtask, task_list.* FROM task_list natural JOIN project ";
                                        $numqry = $db->query($numsql);
                                        $numqry->execute(); */
                                        
                                      
                                        $sql = "SELECT * ,
                                        DATE_FORMAT(strat_date_task, '%e %M %Y ') AS start_date_task, 
                                        DATE_FORMAT(end_date_task, '%e %M %Y ') AS end_date_task,
                                        DATE_FORMAT(strat_date_task, 'เวลา %H:%i น.') AS start_time_task, 
                                        DATE_FORMAT(end_date_task, 'เวลา %H:%i น.') AS end_time_task
                                        FROM details
                                        natural  JOIN task_list/*  ON details.task_id = task_list.task_id */
                                        natural  JOIN project 
                                        natural  JOIN user  $where /* ON details.project_id = project.project_id; */";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                          /*   $pro_id=$row['project_id'];
                                            $stmt = $db->query("SELECT * FROM task_list WHERE project_id =  $pro_id");
                                            $numtask = $stmt->rowCount(); */
                                            $manager_id = $row['manager_id'];
                                            $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
                                            $manager = $manager->fetch(PDO::FETCH_ASSOC);  
                                            
                                    ?>
                                    
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                             <td>
                                                <p><b><?php echo $row['name_project'] ?></b>
                                                <?php ?></p>
                                                <p class="truncate"><?php  ?></p>
						                    </td>

                                            <td class="">
                                            <p><b><?php echo $row['name_tasklist']?></b>
                                           
                                            </td>

                                            <td class="text-center" ><?php echo ThDate($row['strat_date_task']); ?></td>
					                        <td class="text-center "><?php echo ThDate($row['date_detalis']) ?></td>

                                            

                                            <td class="text-center">
                                                <?php  showstattask($row['status_task']);  ?>
                                                
                                            </td>
                                            <td class="text-center">                   
                                               <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                      
                                                <a class="btn btn-bitbucket btn-sm" title="Free Web tutorials" data-bs-toggle="modal" data-bs-target="#viewdetailsmodal<?php echo $row['details_id']?>"><i data-feather="zoom-in"></i></a>
                                                <button class="btn btn-success btn-sm" title="Free Web tutorials" onclick="checktasksuccess('<?php echo $row['details_id'] ?>','<?php echo $row['task_id'] ?>','<?php echo $row['project_id'] ?>');"> <i data-feather="check-square"></i></button>
                                                <a class="btn btn-warning btn-sm" href="checktaskedit.php?details_id=<?php echo $row['details_id'] ?>&task_id=<?php echo $row['task_id'] ?>&project_id=<?php echo $row['project_id'] ?>&progress_task=<?php echo $row['progress_task']?>"> <i data-feather="check-square"></i></a>
                                                <!-- <a class="btn btn-warning btn-sm" href=""><i data-feather="share"></i></a> -->
                                  
                                            </td>
                                        </tr>
                                    
                                       
                                        <?php  include "viewdetails_model.php"  ?>
                                    <?php } ?>
                                </tbody>           
                            </table>
                    </div>
                        
                  
        </main>
        
</form>

    </body>
</html>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});
function deleteproject(project_id){
    $('#proc').val('deleteproject');
    $('#project_id').val(project_id);
}

function checktasksuccess(details_id,task_id,project_id){
    $('#proc').val('checktasksuccess');
    $('#details_id').val(details_id);
    $('#task_id').val(task_id);
    $('#project_id').val(project_id);
    $('#proc').submid
}
/* function checktaskedit(details_id,task_id,project_id){
    $('#proc').val('checktaskedit');
    $('#details_id').val(details_id);
    $('#task_id').val(task_id);
    $('#project_id').val(project_id);
} */
</script>
<?php include "footer.php"?>