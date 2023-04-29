<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
        
    }
    $user_id=$_SESSION['user_login'];
    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $user_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);

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
    <?php if($level!= 5 ): ?>
         <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
            
                        
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="addproject_page.php"><i class="fa fa-plus"></i>  + เพิ่มโปรเจค</a>
                            
                        </div>
                 
                    </div>
                </div>
            </div>
        </div> 
        <?php endif; ?>
        <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">รายการโปรเจค</h5>
                        </div>
                            <table class="table table-hover my-0" id="example">
                                <thead>
                                    <tr>
                                    <th class="text-center">ID</th>
                                        <th class="text-left">ชื่องาน</th>
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
                                        $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","อยู่ระหว่างการตรวจสอบ","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
                                        $where = "";    
                                        if($level >= 3 ){
                                            $where = " where user_id  = $user_id"  ;
                                            
                                        }
                                        $stmtprotasklist = "SELECT *,
                                            DATE_FORMAT(strat_date_task, '%e %M %Y ') AS start_date, 
                                            DATE_FORMAT(end_date_task, '%e %M %Y ') AS end_date,
                                            DATE_FORMAT(strat_date_task, 'เวลา %H:%i น.') AS start_time, 
                                            DATE_FORMAT(end_date_task, 'เวลา %H:%i น.') AS end_time
                                            FROM project natural join project_list natural join task_list natural join user $where order by end_date,status_2  DESC ";
                                        $stmtprotasklist = $db->query($stmtprotasklist);
                                        $stmtprotasklist->execute();
                                            while($row2 = $stmtprotasklist->fetch(PDO::FETCH_ASSOC)){ ?>  
                                <tr>
                                    <td class="text-center">
                                        <?php echo $i++ ?>
                                    </td>

                                    <td>
                                        <h5><b><?php echo $row2['name_tasklist'] ?> </h5></b>
                                        
                                        <p class="truncate"><?php echo substr($row2['description_task'],0,100).'...';  ?></p>
                                    </td>
    
                                    <td >
                                    <?php echo $row2['start_date'].'<br>'.$row2['start_time']  ?>
                                    </td>

                                    <td>
                                    <?php echo $row2['end_date'].'<br>'.$row2['end_time']  ?>
                                    </td>

                                    <td>
                                        <div class="progress ">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 10%" >0</div>
                                        </div>
                                    </td>

                                    <td class="text-center" >
                                            <?php  echo $row2['firstname']." ".$row2['lastname'] ?>  
                                    </td>

                                    <td class="text-center">
                                            <?php  
                                                if($row2['status_task'] =='1'){
                                                echo "<span class='badge bg-secondary'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='2'){
                                                echo "<span class='badge bg-primary'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='3'){
                                                echo "<span class='badge bg-success'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='4'){
                                                echo "<span class='badge bg-warning'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='5'){
                                                echo "<span class='badge bg-danger'>".$stat1[$row2['status_task']]."</span>";
                                            }elseif($row2['status_task'] =='6'){
                                                echo "<span class='badge bg-danger'>".$stat1[$row2['status_task']]."</span>";
                                            } ?>
                                    </td>
                                       
                                    <td class="text-center">
                                  
                                    <a class="btn btn-google btn-sm" href="?update_id=<?php echo $row2['task_id']?>"  > <i data-feather="message-square"></i></a>   

                                       <a class="btn btn-bitbucket btn-sm" data-bs-toggle="modal" data-bs-target="#viewtaskmodal<?php echo $row2['task_id']?>"><i data-feather="zoom-in"></i></a>

                                      <?php if($row2['manager_id'] == $user_id || $level <= 2 || $row2['user_id'] == $user_id ){?>
                                       <a href="?update_id=<?php echo $row2['task_id']?>" class="btn btn-success btn-sm"  ><i data-feather="share"></i></a>

                                       <?php } ?>  

                                       <?php if ($row2['manager_id'] == $user_id || $level <= 2) {?>
                                                <a class="btn btn-warning btn-sm" href="edittask_page.php?update_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>" class="btn btn-warning btn-sm"><i  data-feather="edit"></i></a>
                                                <a class="btn btn-danger btn-sm" href="deletetask.php?delete_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>"><i data-feather="trash-2"></i></a> 
                                               
                                        <?php } ?>

                                    </td>
                                </tr>
                               
                                <?php include "viewtask_modal.php"?>
                                    <?php } ?>
                                </tbody>
                            
                            </table>
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
</script>
<?php include "footer.php"?>