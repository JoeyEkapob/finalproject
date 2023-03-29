<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
        
    }
    $task_id = $_GET['task_id'];
    $project_id = $_GET['project_id'];
    $user_id = $_SESSION['user_login'];

    $proandtasksql = $db->query("SELECT * FROM project NATURAL JOIN  task_list where project_id = $project_id");
    $sqlrow = $proandtasksql->fetch(PDO::FETCH_ASSOC);
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

    <main class="content">
    <?php if($level != 5 ): ?>
        <!-- div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
            
                        
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="addproject_page.php"><i class="fa fa-plus"></i>  + เพิ่มโปรเจค</a>
                            
                        </div>
                 
                    </div>
                </div>
            </div>
        </div> -->
        <?php endif; ?>
      
            <div class="row">
                <div class="col-12 col-lg-6">        
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">รายละเอียดงานที่ส่งไป</h5>
                        </div>
                            <table class="table table-hover my-0" >
                                <thead>
                                    <tr>
                                        <th class="text-center">ส่งครั้งที่</th>
                                        <th class="text-left">ชื่อโปรเจค</th>
                                        <th class="text-left">ชื่องาน</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                   $i = 1 ;
                                    $send_status = "1";
                                    $sqldetailsuser = $db->prepare('SELECT * FROM details  NATURAL JOIN task_list  NATURAL JOIN project where task_id = :task_id AND send_status = :send_status');
                                    $sqldetailsuser->bindParam(":task_id", $task_id);
                                    $sqldetailsuser->bindParam(":send_status", $send_status);
                                    $sqldetailsuser->execute();
                                    while ($sqldetailsuser2 = $sqldetailsuser->fetch(PDO::FETCH_ASSOC)) {  
                                   ?>
                                   <tr>
                                    <td class="text-center">
                                        <?php echo $i++ ?>
                                    </td>

                                    <td>
                                        <h5><b><?php echo $sqldetailsuser2['name_project']  ?></h5></b>

                                    </td>
    
                                    <td >
                                        <?php echo $sqldetailsuser2['name_tasklist'] ; ?>
                                    </td>
                                        
                                    <td class = "text-center">
                                    <a type="button" name="view" value="view" class="btn btn-bitbucket btn-sm view_data" id="<?php echo $sqldetailsuser2['details_id'] ?>" data-send="<?php echo $sqldetailsuser2['usersenddetails'] ?>" data-status="<?php echo $sqldetailsuser2['send_status'] ?>"><i data-feather="zoom-in"></i></a>
                                        
                                    </td>
                                </tbody>   
                                <?php } ?>        
                            </table>
                        </div>
                    </div>
               
                     <div class="col-12 col-lg-6">        
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">รายละเอียดที่ต้องเเก้ไข</h5>
                            </div>
                                <table class="table table-hover my-0" >
                                    <thead>
                                        <tr>
                                        <th class="text-center">เเก้งานครั้งที่</th>
                                        <th class="text-left">ชื่อโปรเจค</th>
                                        <th class="text-left">ชื่องาน</th>
                                        <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    $manager_id = $sqlrow['manager_id'];
                                    $i = 1 ;
                                    $send_status = "2";
                                    $sqldetailsidmax = $db->prepare('SELECT MAX(details_id) AS maxdetails_id FROM details  WHERE task_id = :task_id AND send_status = :send_status');
                                    $sqldetailsidmax->bindParam(":task_id", $task_id);
                                    $sqldetailsidmax->bindParam(":send_status", $send_status);
                                    $sqldetailsidmax->execute();
                                    $sqldetailsidmaxrow = $sqldetailsidmax->fetch(PDO::FETCH_ASSOC);
                                    $maxdetails_id=$sqldetailsidmaxrow['maxdetails_id'];
   
                                    $sqldetailsmanager = $db->prepare('SELECT * FROM details NATURAL JOIN task_list NATURAL JOIN project WHERE task_id = :task_id AND send_status = :send_status');
                                    $sqldetailsmanager->bindParam(":task_id", $task_id);
                                    $sqldetailsmanager->bindParam(":send_status", $send_status);
                                    $sqldetailsmanager->execute();
                                    while ($sqldetailsmanager2 = $sqldetailsmanager->fetch(PDO::FETCH_ASSOC)) {  
                                        $details_id=$sqldetailsmanager2['details_id'];
                                    ?>
                                   <tr>
                                    <td class="text-center">
                                        <?php echo $i++; ?>
                                        
                                    </td>

                                    <td>
                                        <h5><b><?php echo $sqldetailsmanager2['name_project']  ?></h5></b>
                                    
                                    </td>
    
                                    <td  >
                                        <?php echo $sqldetailsmanager2['name_tasklist'] ; ?>

                                    </td>
                                        
                                    <td class = "text-center">
                                    <button type="button" class="btn btn-bitbucket btn-sm view_data" id="<?php echo $sqldetailsmanager2['details_id'] ?>" data-send="<?php echo $sqldetailsmanager2['usersenddetails'] ?>" data-status="<?php echo $sqldetailsmanager2['send_status'] ?>"><i data-feather="zoom-in"></i></button>
                                     <?php 
                               
                                   if($manager_id  == $user_id || $level <= 2 AND $maxdetails_id == $details_id AND $sqlrow['status_1'] != 4 ){?>
                                    <a class=" btn btn-warning btn-sm " href="editdetails.php?details_id=<?php echo $sqldetailsmanager2['details_id'] ?>&task_id=<?php echo $task_id ?>&project_id=<?php echo  $project_id ?>"><i data-feather="edit"></i></a>
                                        <?php }else{
                                    echo '<a class=" btn btn-warning btn-sm disabled" href="editdetails.php?details_id='.$sqldetailsmanager2['details_id'].'&task_id='.$task_id.'&project_id='.$project_id.'"><i data-feather="edit"></i></a>';

                                        } ?>
                                    </td>
                                </tbody>   
                                <?php } ?>        
                            </table>
                        </div>
                    </div> 
              
                </div>   
                <?php require 'viewmodeldetails.php'?>
        </main>
        
    </form>

    </body>
</html>
<script>
$(document).ready(function(){
  $('.view_data').click(function(){
    var proc = 'viewdetails';
    var details_id=$(this).attr("id");
    var usersendid=$(this).data("send");
    var sendstatus=$(this).data("status");
    console.log(details_id);
    $.ajax({
        url:"proc.php",
        method:"post",
        data:{proc:proc,detail_id:details_id,usersendid:usersendid,sendstatus:sendstatus},
        success:function(data){
            $('#details').html(data);
            $('#datamodal').modal('show'); 
        }
    })

   //console.log(did);
    // โค้ดของคุณที่นี่
  });
  /* $('.edit_data').click(function(){
    var proc = 'editdetails';
    var details_id=$(this).attr("id");
    //console.log(details_id);
    $.ajax({
        url:"proc.php",
        method:"post",
        data:{proc:proc,detail_id:details_id},
        dataType:"json",
        success:function(data){
            $('#text_comment').val(data.text_comment);
            $('#editdatamodal').modal('show'); 
        }
    })

   //console.log(did);
    // โค้ดของคุณที่นี่
  }); */

});
</script>
<?php include "footer.php"?>
