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
    
    $select_project = $db->prepare("SELECT * FROM project  natural JOIN job_type  WHERE project_id = :id");
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
<form action="proc.php" method="post" id="viewpro" class="form-horizontal" enctype="multipart/form-data" >

    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="file_item_project" name="file_item_project" value="">
    <input type="hidden" id="details" name="details" value="">
   
    <main class="content">
    <a href="project_list.php" class="back-button">&lt;</a> 
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
                                                            
                                                             <?php if($manager['avatar'] !=""){?>
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $manager['avatar']?>" alt="Avatar" width="35"  height="35">
                                                                <b><?php echo $manager['name'] ?> </b>
                                                            <?php }else{ ?>
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                                                                <b><?php echo $manager['name'] ?> </b>
                                                                <?php } ?>
                                                           
                                                        
                                                        </div>
                                                    </dd>
                                                    <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>
                
                                                <?php 
                                                    $sql = "SELECT * FROM project  NATURAL JOIN file_item_project WHERE project_id = $id";
                                                    $qry = $db->query($sql);
                                                    $qry->execute();
                                                    while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)) {  
                                                        $stmt = $db->prepare("SELECT * FROM file_item_project WHERE file_item_project = :file_item_project");
                                                        $stmt->bindParam(":file_item_project", $row2['file_item_project']);
                                                        $stmt->execute();  
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        ?>
                                                <div class="row">
                                                    <div class="col-sm">
                                                     <a href="img/file/file_project/<?php echo $row['newname_filepro']; ?>" download="<?php echo $row2['filename']; ?>"><?php echo $row2['filename']?></a> 
                                                       <!-- <u onclick="download('<?php echo $row2['file_item_project']?>') "style="color:#3399FF;"><?php echo $row2['filename']?></u>  -->
                                                    <!-- <a onclick="download('<?php echo $row2['file_item_project']?>') "><?php echo $row2['filename']?></a> -->
                                                    <!-- <a href="../static/img/file/<?php echo $row2['filename']?> " target="_blank"><?php echo $row2['filename']?></a><br>  -->
                                                    </div>
                                                    
                                                </div>          
                                                <?php } ?>
                                        </div>

                                            <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันที่เริ่ม</b></dt>
                                                    <dd><?php echo  ThDate($start_date) ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันสิ้นสุด</b></dt>
                                                    <dd><?php echo ThDate($end_date) ?></dd>
                                                </dl>
                                                
                                                <dl>
                                                        <dt><b class="border-bottom border-primary">ความคืบหน้า</b></dt>
                                                        <dd>
                                                            <?php
                                                            $progressproject = array();

                                                            $sqlprogressproject = "SELECT * FROM project NATURAL JOIN task_list WHERE project_id = $id";
                                                            $qryprogressproject = $db->query($sqlprogressproject);
                                                            $qryprogressproject->execute();
                                                            while ($progressprojectrow = $qryprogressproject->fetch(PDO::FETCH_ASSOC)) {  
                                                                //array_push($progressproject, $progressprojectrow['progress_task']);
                                                                $progressproject[] = $progressprojectrow['progress_task'];
                                                            }
                                                            //print_r($progressproject);
                                                            $sumprogress =  array_sum($progressproject);
                                                            $numprogress = sizeof($progressproject);
                                                            $totalprogress2 = 0;
                                                            if($numprogress != 0 ){
                                                                $totalprogress = $sumprogress/$numprogress;
                                                                $totalprogress2=number_format($totalprogress,2);   
                                                           }
                                                            //echo $totalprogress2;
                                                            
                                                            $updateproject = $db->prepare('UPDATE project  SET  progress_project = :progress_project WHERE project_id = :project_id');
                                                            $updateproject->bindParam(":progress_project",$totalprogress2);
                                                            $updateproject->bindParam(":project_id",$id);
                                                            $updateproject->execute(); 
                                                             ?> 
                                                        <br>
                                                            <div class="col-md-3">
                                                                <div class="progress ">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo  $totalprogress2 ?>%"><?php  echo $totalprogress2  ?>%</div>
                                                                </div>
                                                            </div>
                                                    
                                                        </dd>
                                                            <br>
                                                        <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                            <dd>
                                                                <?php  showstatpro($status_1); ?>
                                                            </dd>
                                                </dl>
                                                
                                                <dl>
                                                    
                                                    <dt><b class="border-bottom border-primary">สมาชิก</b></dt>
                                                    <dd>
                                                        <?php 
                                                                $num = 1;
                                                                $sql = "SELECT * FROM project_list  natural join user  where project_id = $id ";
                                                                $qry = $db->query($sql);
                                                                $qry->execute();
                                                                $numuser= $qry->rowCount();
                                                                while ($row = $qry->fetch(PDO::FETCH_ASSOC)){  ?>  
                                                            <?php if($row['avatar'] !=""){?>
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $row['avatar']?>" alt="Avatar" width="35"  height="35">
                                                                <a class="viewuserdata" data-userid="<?php echo $row['user_id'] ?>" ><b><?php  echo $row['firstname']." ".$row['lastname'] ?></b></a>
                                                                <?php  if($num++ % 3 == 0){
                                                                   echo "<br>";
                                                                } ?>
                                                            <?php }else{?>
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                                                                <a class="viewuserdata" data-userid="<?php echo $row['user_id'] ?>" ><b><?php  echo $row['firstname']." ".$row['lastname'] ?></b></a>
                                                                <?php  if($num++ % 3 == 0){
                                                                   echo "<br>";
                                                                } ?>
                                                                <?php }?>
                                                            <?php  } ?>
                                                    </dd>
                                                </dl> 
                                                
                                            </div>
                                            
                                          
                                </div>
                            </div>
                        </div>
                    </div> 
                    <?php require 'viewmodel.php'?>
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <?php  
                                        if ($manager_id == $us || $level <= 2 AND $status_1 != 3)  {?>
                                <div class="d-flex flex-row-reverse">
                                    <a class="btn btn-block btn-sm btn-default btn-flat border-primary"  type="button" id="new_task" data-bs-toggle="modal" data-bs-target="#addModal1"> <i class="fa fa-plus"></i>  + Add task</a>
                                </div>
                                <?php  } ?>
                                <div class="d-flex justify-content-start">
                                    <h5 class="card-title mb-0">รายการงาน</h5>
                                </div>
                            </div> 
                            <div class="table-responsive-xl">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="id-col">ลำดับที่</th>
                                            <th class="name-col">ชื่องาน</th>
                                            <th class="start-col">วันที่เริ่ม</th>
                                            <th class="end-col">วันที่สิ้นสุด</th>
                                            <th class="progress-col">ความคืบหน้า</th>
                                            <th class="assign-col">มอบหมาย</th>
                                            <th class="status-col">สถานะ</th>
                                            <th class="action-col">Action</th>
                                        </tr>
                                    </thead>
                                <tbody>
  
                                        <?php
                                            $i = 1;
                                            
                                            $stmttasklist = "SELECT *
                                            FROM task_list 
                                            NATURAL JOIN user 
                                            WHERE project_id = $id";
                                            $stmttasklist = $db->query($stmttasklist);
                                            $stmttasklist->execute();  
                                            while ($row2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){
                                                $task_id = $row2['task_id'];
                                             
                                                $stmt = $db->query("SELECT * FROM details WHERE task_id =  $task_id ORDER BY details_id DESC ");
                                                $stmt->execute();
                                                $stmt2 = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $numsenddetails = $stmt->rowCount();
                                                    ?>
                                        <tr>
                                            <td  class="id-col" >
                                                <?php echo $i++ ?>
                                            </td>

                                            <td class="name-col">
                                                <h5><b><?php echo $row2['name_tasklist']  ?>  <?php echo showstatustime($row2['status_timetask']) ?></h5></b>
                                                <p class="truncate"><?php echo mb_substr($row2['description_task'],0,20).'...';  ?></p>
                                            </td>

                                            <td class="start-col">
                                                <?php echo thai_date_and_time($row2['strat_date_task']); ?>
                                              
                                            </td>

                                            <td class="end-col">
                                                <?php echo thai_date_and_time($row2['end_date_task']); ?>
                                             
                                            </td>
                                             
                                            <td class="progress-col">
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo $row2['progress_task'] ?>%" ><?php echo $row2['progress_task'] ?></div>
                                                </div>
                                            </td>

                                            <td class="assign-col" >
                                                    <?php  echo $row2['firstname']." ".$row2['lastname'] ?>  
                                            </td>

                                            <td class="status-col" >
                                                    <?php   showstattask($row2['status_task']);?>
                                            </td>
                                            
                                            <td class="action-col">
                                        
                                            <a class="btn btn-google btn-sm" href="details_page.php?task_id=<?php echo $row2['task_id']?>&project_id=<?php echo $row2['project_id']?>"><i data-feather="message-square"></i></a>   
                                            <!-- <a class="btn btn-google btn-sm" data-bs-toggle="modal" data-bs-target="#viewdetailsmodal<?php echo $row2['details_id']?>"><i data-feather="message-square"></i></a> -->

                                            <a class="btn btn-bitbucket btn-sm" data-bs-toggle="modal" data-bs-target="#viewtaskmodal<?php echo $row2['task_id']?>"><i data-feather="zoom-in"></i></a>

                                            <?php
                                            /* $member = array();
                                            $stmtprojectuser = "SELECT * FROM project_list NATURAL JOIN user  WHERE project_id = $id";
                                            $stmtprojectuser = $db->query($stmtprojectuser);
                                            $stmtprojectuser->execute();  
                                            while ($row = $stmtprojectuser->fetch(PDO::FETCH_ASSOC)){
                                                $member[] = $row["user_id"];
                                            } */
                                                    /*  print_r ($member) ; */
                                                     
                                                // if (in_array($us,$member) || ( $level <= 2 || $manager_id == $us ) AND $row2['status_task'] != 3 AND $row2['progress_task'] != 100  ) {
                                                if ($row2['user_id'] == $us   || $level <= 2   || $manager_id == $us   AND $row2['status_task'] != 5 AND $row2['progress_task'] != 100  AND $status_1 != 3 AND $row2['status_task'] != 2 ) {
                                                    echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' .   $row2['project_id'] .'&user_id='. $us .'&statustimetask='. $row2['status_timetask'].'" class="btn btn-success btn-sm"><i data-feather="share"></i></a>';  
                                                }
                                             
                                                else if($row2['progress_task'] != 100 AND $row2['status_task'] = 2  AND $status_1 != 3 ){
                                                    echo '<button class="btn btn-danger btn-sm deletedetals-btn"  data-project_id="'.$row2['project_id'].'"  data-task_id="'.$row2['task_id'].'"  data-details_id="'.$stmt2['details_id'].'"><i data-feather="x"></i></button> '; 
                                                    //echo $row2['project_id'];
                                                    
                                                } 
                                                    // echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' . $row2['project_id'] . '" class="btn btn-danger btn-sm"><i data-feather="x"></i></a>';
                                                    // echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' . $row2['project_id'] . '" class="btn btn-success btn-sm disabled"><i data-feather="share"></i></a>'; 
                                                    echo ' ';
                                                if($manager_id == $us || $level <= 2 AND $status_1 != 3 AND $row2['progress_task'] != 100 AND $row2['status_task'] != 5) {
                                                    echo '<a class="btn btn-warning btn-sm" href="edittask_page.php?updatetask_id='.$row2['task_id'].'&project_id='.$row2['project_id'].'"><i data-feather="edit"></i></a>';
                                                    echo ' ';
                                                }if($numsenddetails == 0 AND $manager_id == $us || $level <= 2 AND $status_1 != 3){
                                                    echo '<button class="btn btn-danger btn-sm delete-btn" data-project_id="'.$row2['project_id'].'" data-task_id="'.$row2['task_id'].'"><i data-feather="trash-2"></i></button>';
                                                }   
                                                ?>
                                                <?php if ($manager_id == $us || $level <= 2) {?>
                                                        <!-- <a class="btn btn-warning btn-sm" href="edittask_page.php?updatetask_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>" class="btn btn-warning btn-sm"><i  data-feather="edit"></i></a> -->
                                                        <!-- <a class="btn btn-danger btn-sm" onclick="test();"><i  data-feather="edit"></i></a> -->
                                                        <!-- <a class="btn btn-danger btn-sm" href="deletetask.php?delete_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>"><i data-feather="trash-2"></i></a>  -->
                                                        <!-- <button class="btn btn-danger btn-sm"  onclick="del_task('<?php echo $row2['task_id']?>','<?php echo $row2['project_id']?>')"><i data-feather="trash-2"></i></button>  -->

                                                    
                                                <?php } ?>

                                            </td>
                                        </tr>
                                        <?php include "viewtask_modal.php";?>
                                    <?php  } ?>
                                </tbody>
                            <?php include "addtask_model.php"?>
                        </table>
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
  $('.viewuserdata').click(function(){
    var proc = 'viewdatauser';
    var userid=$(this).data("userid");
 /*    var usersendid=$(this).data("send");
    var sendstatus=$(this).data("status"); */
    console.log(userid);
    $.ajax({
        url:"proc.php",
        method:"post",
        data:{proc:proc,userid:userid},
        success:function(data){
           // console.log(data);

            $('#datauser').html(data);
            $('#datausermodal').modal('show'); 
        }
    })
  });
});
     $(document).ready(function() {
    $("#input-b6b").fileinput({
        showUpload: false,
        dropZoneEnabled: false,
        maxFileCount: 10,
        inputGroupClass: "input-group"
    });
});
    $(document).ready(function () {
        $('#example').DataTable();
    });
    
        $(".delete-btn").click(function(e) {
            var project_id = $(this).data('project_id');
            var task_id  = $(this).data('task_id');
           // console.log('dfgdfgdfgdf');

            e.preventDefault();
            deletetaskConfirm(project_id,task_id);
        })

        function deletetaskConfirm(project_id,task_id) {
            Swal.fire({
                title: 'คุณต้องการลบงานใช่หรือไม่',
                icon: 'error',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ต้องการลบ!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'deltask' + '&project_id=' + project_id + '&task_id=' + task_id ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ลบงานเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                    confirmButtonText: 'ตกลง!',

                                }).then(() => {
                                    document.location.href = 'view_project.php?view_id='+ project_id;
                                    
                                    
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        }
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
        $('#viewpro').submit();

    }

    function delfilepro(file_item_project,project_id){
        $('#proc').val('delfile');
        $('#file_item_project').val(file_item_project);
        $('#project_id').val(project_id);
    } 

    function deldetails(id_task,project_id,details_id){
        $('#proc').val('deldetails');
        $('#task_id').val(id_task);
        $('#project_id').val(project_id);
        $('#details').val(details_id);
    }
    $(".deletedetals-btn").click(function(e) {
            var project_id = $(this).data('project_id');
            var task_id  = $(this).data('task_id');
            var details_id  = $(this).data('details_id');
            console.log(details_id);
            e.preventDefault();
            deleteConfirm(project_id, task_id,details_id);
        })

        function deleteConfirm(project_id,task_id,details_id) {
            console.log(details_id);
            Swal.fire({
                
                title: 'คุณต้องการยกเลิกงานใช่หรือไม่',
                icon: 'error',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ต้องการยกเลิก!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                
                    return new Promise(function(resolve) {
               
                        $.ajax({
                            
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'deldetails' + '&project_id=' + project_id + '&task_id=' + task_id + '&details=' + details_id ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ยกเลิกเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                    confirmButtonText: 'ตกลง!',
                                }).then(() => {
                                    document.location.href = 'view_project.php?view_id='+ project_id;
                                    
                                    
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        }

   /*  function deldetails(viewpro){
        document.getElementById('addtask_btn1').style.display="none";
        document.getElementById('addtask_btn2').style.display="block";
    } */
  
        
    
    


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
