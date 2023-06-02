<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
        
    }

    $us=$_SESSION['user_login'];
    $status = $_GET['statustask'];
    
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css"  
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

<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
    <main class="content">
        <div class="row">
                    <div class="col-lg-12 ">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="d-flex justify-content-start">
                                    <h5 class="card-title mb-0">รายการงาน</h5>
                                    </div>
                            </div> 
                            <div class="table-responsive-xl">
                            <table class="table table-hover my-0"  id="example" >
                                    <thead>
                                        <tr>
                                            <th class="id-col text-center">ลำดับที่</th>
                                            <th class="name-col text-center">ชื่องาน</th>
                                            <th class="start-col text-center">วันที่เริ่ม</th>
                                            <th class="end-col text-center">วันที่สิ้นสุด</th>
                                            <th class="progress-col text-center">ความคืบหน้า</th>
                                            <th class="assign-col text-center">มอบหมาย</th>
                                            <th class="status-col text-center ">สถานะ</th>
                                            <th class="action-col text-center">Action</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <?php
                                            $i = 1;
                                            $where ='';
                                            if($level > 2){
                                            $where = " AND t.user_id  = $us";
                                            }
                                            if($status == 1){
                                               $where .=" ";
                                            }else if($status == 2){
                                                $where .= " AND p.status_1 != 3 AND p.progress_project  != 100 AND t.status_task != 5 AND t.status_task2 != 1 AND t.progress_task != 100 ";
                                            }else if($status == 3){
                                                $where .= " AND p.status_1 != 3 AND p.progress_project  != 100 AND t.status_task != 5 AND t.status_task2 != 1 AND t.progress_task != 100 AND t.status_timetask = 2 ";
                                                    
                                            }
                                            $stmttasklist = "SELECT *
                                            FROM task_list as t 
                                            left join user as u ON t.user_id = u.user_id 
                                            left join project as p ON t.project_id = p.project_id 
                                            WHERE 1=1 $where ";
                                            $stmttasklist = $db->query($stmttasklist);
                                            $stmttasklist->execute();  
                                            while ($row2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){
                                                 $task_id = $row2['task_id'];
                                                 $project_id = $row2['project_id'];
                                             
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
                                                    <?php  echo  showshortname($row2['shortname_id'])." ".$row2['firstname']." ".$row2['lastname'] ?>  
                                            </td>

                                            <td class="status-col" >
                                               <?php  if($row2['status_task2']== 1){
                                                     echo showstattask2($row2['status_task2']);
                                               }else{
                                                   echo showstattask($row2['status_task']);
                                               }
                                                    ?>
                                            </td>
                                            

                                            <td class="action-col">
                                		                                  
                                            <?php  if ($row2['user_id'] == $us   || $level <= 2   || $row2['manager_id'] == $us ) { ?>
                                            <a class="btn btn-google btn-sm" title="ดูรายละเอียดการส่งงาน" href="details_page.php?task_id=<?php echo $row2['task_id']?>&project_id=<?php echo $row2['project_id']?>"><i data-feather="message-square"></i></a>   
                                            <!-- <a class="btn btn-google btn-sm" data-bs-toggle="modal" data-bs-target="#viewdetailsmodal<?php echo $row2['details_id']?>"><i data-feather="message-square"></i></a> -->
                                                <?php } ?>
                                                <a class="btn btn-bitbucket btn-sm viewdatatask"  title="ดูรายละเอียดงาน" data-task_id="<?php echo $row2['task_id']?>"  data-project_id="<?php echo $project_id ?>"><i data-feather="zoom-in"></i></a>

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
                                                if ($row2['user_id'] == $us   || $level <= 2   || $row2['manager_id'] == $us   AND $row2['status_task'] != 5 AND $row2['progress_task'] != 100  AND $row2['status_1'] != 3 AND $row2['status_task'] != 2 AND $row2['status_task2'] != 1 ) {
                                                    echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' .   $row2['project_id'] .'&user_id='. $us .'&statustimetask='. $row2['status_timetask'].'" class="btn btn-success btn-sm" title="ส่งงาน"><i data-feather="share"></i></a>';  
                                                }
                                             
                                                else if($row2['user_id'] == $us   || $level <= 2   || $row2['manager_id'] == $us   AND $row2['progress_task'] != 100 AND $row2['status_task'] = 2  AND $row2['status_1'] != 3 AND $row2['status_task2'] != 1){
                                                    echo '<button class="btn btn-danger btn-sm deletedetals-btn" title="ยกเลิกงาน" data-project_id="'.$row2['project_id'].'"  data-task_id="'.$row2['task_id'].'"  data-details_id="'.$stmt2['details_id'].'" ><i data-feather="x"></i></button> '; 
                                                    //echo $row2['project_id'];
                                                    
                                                } 
                                                    // echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' . $row2['project_id'] . '" class="btn btn-danger btn-sm"><i data-feather="x"></i></a>';
                                                    // echo '<a href="send_task.php?task_id=' . $row2['task_id'] . '&project_id=' . $row2['project_id'] . '" class="btn btn-success btn-sm disabled"><i data-feather="share"></i></a>'; 
                                                    echo ' ';
                                                if($row2['manager_id'] == $us || $level <= 2 AND  $row2['status_1'] != 3 AND $row2['progress_task'] != 100 AND $row2['status_task'] != 5 ) {
                                                    echo '<a class="btn btn-warning btn-sm" title="เเก้ไขงาน" href="edittask_page.php?updatetask_id='.$row2['task_id'].'&project_id='.$row2['project_id'].'"><i data-feather="edit"></i></a>';
                                                    echo ' ';
                                                }if($numsenddetails == 0 AND $row2['manager_id'] == $us || $level <= 2 AND$row2['status_1'] != 3 AND $row2['status_task2'] != 1){
                                                    echo '<button class="btn btn-danger btn-sm delete-btn" title="ลบงาน" data-project_id="'.$row2['project_id'].'" data-task_id="'.$row2['task_id'].'" data-status="'.$status.'"><i data-feather="trash-2"></i></button>';
                                                }   
                                                ?>
                                                <?php if ($row2['manager_id']== $us || $level <= 2) {?>
                                                        <!-- <a class="btn btn-warning btn-sm" href="edittask_page.php?updatetask_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>" class="btn btn-warning btn-sm"><i  data-feather="edit"></i></a> -->
                                                        <!-- <a class="btn btn-danger btn-sm" onclick="test();"><i  data-feather="edit"></i></a> -->
                                                        <!-- <a class="btn btn-danger btn-sm" href="deletetask.php?delete_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>"><i data-feather="trash-2"></i></a>  -->
                                                        <!-- <button class="btn btn-danger btn-sm"  onclick="del_task('<?php echo $row2['task_id']?>','<?php echo $row2['project_id']?>')"><i data-feather="trash-2"></i></button>  -->

                                                    
                                                <?php } ?>

                                            </td>
                                        </tr>
                                    
                                    <?php  } ?>
                                </tbody>
                            
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
<script>
$(document).ready(function () {
    $('#example').DataTable();
});
$(document).ready(function(){
  $('.viewdatatask').click(function(){
    var proc = 'viewdatatask';
    var task_id=$(this).data("task_id");
    var project_id=$(this).data("project_id");
    //var sendstatus=$(this).data("status"); 
    console.log(project_id);
    $.ajax({
        url:"proc2.php",
        method:"post",
        data:{proc:proc,task_id:task_id,project_id:project_id},
        success:function(data){
           // console.log(data);

            $('#datatask').html(data);
            $('#viewtaskmodal').modal('show'); 
        }
    })
  });
});
$(".delete-btn").click(function(e) {
            var project_id = $(this).data('project_id');
            var task_id  = $(this).data('task_id');
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
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ลบ!',
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
                                    title: 'เรียบร้อย',
                                    text: 'ลบงานเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                    confirmButtonText: 'ตกลง!',

                                }).then(() => {
                                    document.location.href = 'task_list.php?statustask='+ status;
                                    
                                    
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
</script>
<?php include "footer.php"?>