<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
    date_default_timezone_set('asia/bangkok');
    $date = date ("Y-m-d H:i");
    $us=$_SESSION['user_login'];
    $id = $_GET['view_id'];
    $targetDir = "img/avatars/";
    $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","ส่งเรียบร้อยเเล้ว","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
    $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    $select_project = $db->prepare('SELECT * FROM project   natural JOIN job_type  WHERE project_id = :id');
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>

<body>
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
<!-- form action="addtask.php" method="post" class="form-horizontal" enctype="multipart/form-data" -->
<form action="proc.php" method="post" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="file_item_project" name="file_item_project" value="">

    <main class="content">
                 
                    <div class="col-12  d-flex">
                         <div class="card flex-fill">  
                             <div class="card-header">
                                 <div class="row">
                                    <div class="col-md-6">
                                                <dl>
                                                    
                                                    <dt><b class="border-bottom border-primary">ชื่อโปรเจค</b>
                                                    <?php  showstatpro2($status_2); ?>
                                                </dt>
                                                    <dd><?php echo $name_project  ?></dd>

                                                    <dt><b class="border-bottom border-primary">คำอธิบาย</b></dt>
                                                    <dd><?php echo $description ?></dd>

                                                    <dt><b class="border-bottom border-primary">ประเภทงาน</b></dt>
                                                    <dd><?php echo $name_jobtype ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">ผู้สร้างโปรเจค</b></dt>
                                                    <dd> 
                                                         <div class="d-flex align-items-center mt-1">
                                                            <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $manager['avatar']?>" alt="Avatar" width="35"  height="35">
                                                            <b><?php echo $manager['name'] ?> </b>
                                                        </div>
                                                    </dd>

                                                </dl> 
                                        </div>

                                            <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันที่เริ่ม</b></dt>
                                                    <dd><?php echo ThDate($start_date) ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันสิ้นสุด</b></dt>
                                                    <dd><?php echo ThDate($end_date) ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                    <dd>
                                                        <?php  showstatpro($status_1); ?>
                                                    </dd>
                                                </dl>
                                                <dl>
                                                    
                                                    <dt><b class="border-bottom border-primary">สมาชิก</b></dt>
                                                    <dd>
                                                        <?php 
                                                                $sql = "SELECT * FROM project_list  natural join user  where project_id = $id ";
                                                                $qry = $db->query($sql);
                                                                $qry->execute();
                                                                while ($row = $qry->fetch(PDO::FETCH_ASSOC)){  ?>  
                                                                     
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $row['avatar']?>" alt="Avatar" width="35"  height="35">
                                                                <b><?php  echo $row['firstname']." ".$row['lastname'] ?></b>
                                                            <?php  }?>
                                                    </dd>
                                                </dl> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <b class="border-bottom border-primary">ไฟล์เเนบ</b>
                                                    </div>
                                                    
                                                </div>
                                                
                                               
                                               
                                            
                                                <?php 
                                                    $sql = "SELECT * FROM project 
                                                    NATURAL JOIN file_item_project 
                                                    WHERE project_id = $id";
                                                    $qry = $db->query($sql);
                                                    $qry->execute();
                                                    while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)) {  ?>
                                                <div class="row">
                                                    <div class="col-sm">
                                                     <a href="proc.php?proc=download&file_item_project=<?php echo $row2['file_item_project']?>"><?php echo $row2['filename']?></a> 
                                                        <!-- <a onclick="download('<?php echo $row2['file_item_project']?>') "><?php echo $row2['filename']?></a> -->
                                                        <!-- <a href="../static/img/file/<?php echo $row2['filename']?> " target="_blank"><?php echo $row2['filename']?></a><br>  -->
                                                    </div>
                                                    
                                                </div>          
                                                <?php } ?>
                                            </div>
                                          
                                </div>
                            </div>
                        </div>
                    </div> 
        
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <?php   
                                        if ($manager_id == $us || $level <= 2) {?>
                                <div class="d-flex flex-row-reverse">
                                    <a class="btn btn-block btn-sm btn-default btn-flat border-primary"  type="button" id="new_task" data-bs-toggle="modal" data-bs-target="#addModal1"> <i class="fa fa-plus"></i>  + Add task</a>
                                </div>
                                <?php  } ?>
                                <div class="d-flex justify-content-start">
                                    <h5 class="card-title mb-0">รายการงาน</h5>
                                    </div>
                            </div>
                            
                            <table class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-left">ชื่องาน</th>
                                       <!--  <th class="d-none d-xl-table-cell">ชื่องาน</th> -->
                                        
                                        <th class="text-left">วันที่เริ่ม</th>
                                        <th class="text-left">วันที่สิ้นสุด</th>
                                        <th class="text-center">ความคืบหน้า</th>
                                        <th class="text-center">มอบหมาย</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    $stmttasklist = "SELECT *,
                                    DATE_FORMAT(strat_date_task, '%e %M %Y ') AS start_date, 
                                    DATE_FORMAT(end_date_task, '%e %M %Y ') AS end_date,
                                    DATE_FORMAT(strat_date_task, 'เวลา %H:%i น.') AS start_time, 
                                    DATE_FORMAT(end_date_task, 'เวลา %H:%i น.') AS end_time
                                    FROM task_list 
                                    NATURAL JOIN user 
                                    WHERE project_id = $id";
                                    $stmttasklist = $db->query($stmttasklist);
                                    $stmttasklist->execute();
                                    while ($row2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){  
                                        $task_id = $row2['task_id'];
                                        $stmt = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND state_details = 'Y' ");
                                        $numsenddetails = $stmt->rowCount();
                                            ?>
                             <tr>
                                    <td class="text-center">
                                        <?php echo $i++ ?>
                                    </td>

                                    <td>
                                        <h5><b><?php echo $row2['name_tasklist']  ?></h5></b>
                                        <p class="truncate"><?php echo substr($row2['description_task'],0,20).'...';  ?></p>
                                    </td>
    
                                    <td >
                                        <?php echo ThDate($row2['start_date']); ?>
                                        <p class="truncate" ><?php echo $row2['start_time']  ?></p>
                                    </td>

                                    <td>
                                        <?php echo ThDate($row2['end_date']); ?>
                                        <p class="truncate" ><?php echo $row2['end_time']  ?></p>
                                    </td>

                                    <td>
                                        <div class="progress ">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo $row2['progress_task'] ?>%" ><?php echo $row2['progress_task'] ?></div>
                                        </div>
                                    </td>

                                    <td class="text-center" >
                                            <?php  echo $row2['firstname']." ".$row2['lastname'] ?>  
                                    </td>

                                    <td class="text-center">
                                            <?php   showstattask($row2['status_task']);?>
                                    </td>
                                       
                                    <td class="text-center">
                                  
                                       <a class="btn btn-google btn-sm" href="?update_id=<?php echo $row2['task_id']?>"  > <i data-feather="message-square"></i></a>   

                                       <a class="btn btn-bitbucket btn-sm" data-bs-toggle="modal" data-bs-target="#viewtaskmodal<?php echo $row2['task_id']?>"><i data-feather="zoom-in"></i></a>

                                       <?php
                                            if ($row2['user_id'] == $us || $level <= 2 || $manager_id == $us AND $row2['progress_task'] != 100  AND $numsenddetails == 0 ) {
                                                echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' . $row2['project_id'] . '" class="btn btn-success btn-sm"><i data-feather="share"></i></a>';  
                                            }else{
                                                // echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' . $row2['project_id'] . '" class="btn btn-danger btn-sm"><i data-feather="x"></i></a>';
                                                if( $row2['progress_task'] != 100){
                                                echo '<button class="btn btn-danger btn-sm"  onclick="deldetails('. $row2['task_id'] .''.$row2['project_id'].')"><i data-feather="x"></i></button> '; 
                                                echo ' '; 
                                                }else{
                                                    
                                                }
                                                // echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' . $row2['project_id'] . '" class="btn btn-success btn-sm disabled"><i data-feather="share"></i></a>'; 
                                            }
                                            ?>  

                                       <?php if ($manager_id == $us || $level <= 2) {?>
                                                <a class="btn btn-warning btn-sm" href="edittask_page.php?updatetask_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>" class="btn btn-warning btn-sm"><i  data-feather="edit"></i></a>
                                                <!-- <a class="btn btn-danger btn-sm" onclick="test();"><i  data-feather="edit"></i></a> -->
                                                <!-- <a class="btn btn-danger btn-sm" href="deletetask.php?delete_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>"><i data-feather="trash-2"></i></a>  -->
                                                <button class="btn btn-danger btn-sm"  onclick="del_task('<?php echo $row2['task_id']?>','<?php echo $row2['project_id']?>')"><i data-feather="trash-2"></i></button> 

                                               
                                        <?php } ?>

                                    </td>
                                </tr>
                               
                                <?php include "viewtask_modal.php";
                             } ?>
                                </tbody>
                                <?php include "addtask_model.php"?>
                            </table>
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
    $(document).ready(function () {
        $('#example').DataTable();
    });

    function del_task(id_task,project_id){
        $('#proc').val('deltask');
        $('#task_id').val(id_task);
        $('#project_id').val(project_id);
    }

    function add_task(){
        $('#proc').val('add_task');
    }
    function download(file_item_project){
        $('#proc').val('download');
        $('#file_item_project').val(file_item_project);

    }

    function delfilepro(file_item_project,project_id){
        $('#proc').val('delfile');
        $('#file_item_project').val(file_item_project);
        $('#project_id').val(project_id);
    } 
    function deldetails(id_task,project_id){
        $('#proc').val('deldetails');
        $('#task_id').val(id_task);
        $('#project_id').val(project_id);
    }
     // function test(){
        //     var url = "proc.php";
        //     var data = {proc:'add_task',taskname:'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        //         pro_id:170,
        //         start_date:'',
        //         end_date:'',
        //         user:'2',
        //         textarea:'', 
        //     };
        //     $.post(url,data,function(data){
        //         console.log(data);
        //     });
        // }


</script>
