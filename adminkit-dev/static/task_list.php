<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
        
    }
    $user_id=$_SESSION['user_login'];
    
    
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
    <?php if($level != 5 ): ?>
         <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
            
                        
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="addproject_page.php"><i class="fa fa-plus"></i>  + เพิ่มหัวข้องาน</a>
                            
                        </div>
                 
                    </div>
                </div>
            </div>
        </div> 
        <?php endif; ?>
        <div class="row">
                    <div class="col-lg-12 ">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="d-flex justify-content-start">
                                    <h5 class="card-title mb-0">รายการงาน</h5>
                                    </div>
                            </div> 
                            <table class="table table-hover my-0"  id="example" >
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
                                 $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","อยู่ระหว่างการตรวจสอบ","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
                                 $where = "";    
                                 if($level >= 2 ){
                                    $where = " where manager_id  = $user_id ";
                                 }
                                    
                                    
                                
                             
                                 
                                 $stmtprotasklist = "SELECT * FROM project natural join project_list natural join task_list natural join user $where order by end_date,status_2  DESC ";
                                 $stmtprotasklist = $db->query($stmtprotasklist);
                                 $stmtprotasklist->execute();
                                while($stmtprotasklistrow = $stmtprotasklist->fetch(PDO::FETCH_ASSOC)){  ?>  
                             <tr>
                                    <td class="text-center">
                                        <?php echo $i++ ?>
                                    </td>

                                    <td>
                                        <h5><b><?php echo $stmtprotasklistrow['name_tasklist']  ?></h5></b>
                                        
                                        <p class="truncate"><?php echo substr($stmtprotasklistrow['description_task'],0,100).'...';  ?></p>
                                    </td>
    
                                    <td >
                                        <?php echo date("F d, Y",strtotime($stmtprotasklistrow['strat_date_task'])); ?>
                                    </td>

                                    <td>
                                        <?php echo date("F d, Y",strtotime($stmtprotasklistrow['end_date_task'])); ?>
                                    </td>

                                    <td>
                                        <div class="progress ">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 10%" >0</div>
                                        </div>
                                    </td>

                                    <td class="text-center" >
                                            <?php  echo $stmtprotasklistrow['firstname']." ".$stmtprotasklistrow['lastname'] ?>  
                                    </td>

                                    <td class="text-center">
                                            <?php  
                                                if($stmtprotasklistrow['status_task'] =='1'){
                                                echo "<span class='badge bg-secondary'>".$stat1[$stmtprotasklistrow['status_task']]."</span>";
                                            }elseif($stmtprotasklistrow['status_task'] =='2'){
                                                echo "<span class='badge bg-primary'>".$stat1[$stmtprotasklistrow['status_task']]."</span>";
                                            }elseif($stmtprotasklistrow['status_task'] =='3'){
                                                echo "<span class='badge bg-success'>".$stat1[$stmtprotasklistrow['status_task']]."</span>";
                                            }elseif($stmtprotasklistrow['status_task'] =='4'){
                                                echo "<span class='badge bg-warning'>".$stat1[$stmtprotasklistrow['status_task']]."</span>";
                                            }elseif($stmtprotasklistrow['status_task'] =='5'){
                                                echo "<span class='badge bg-danger'>".$stat1[$stmtprotasklistrow['status_task']]."</span>";
                                            }elseif($stmtprotasklistrow['status_task'] =='6'){
                                                echo "<span class='badge bg-danger'>".$stat1[$stmtprotasklistrow['status_task']]."</span>";
                                            } ?>
                                    </td>
                                       
                                    <td class="text-center">
                                  
                                       <a class="btn btn-google btn-sm" href="?update_id=<?php echo $stmtprotasklistrow['task_id']?>"  > <i data-feather="message-square"></i></a>   

                                       <a class="btn btn-bitbucket btn-sm" href="viewtask_page.php?update_id=<?php echo $stmtprotasklistrow['task_id']?>"><i data-feather="zoom-in"></i></a>

                                      <?php if($stmtprotasklistrow['manager_id'] == $user_id || $level <= 2 || $stmtprotasklistrow['manager_id'] == $user_id ){?>
                                       <a href="?update_id=<?php echo $stmtprotasklistrow['task_id']?>" class="btn btn-success btn-sm"  ><i data-feather="share"></i></a>

                                       <?php } ?>  

                                       <?php if ($stmtprotasklistrow['manager_id'] == $user_id || $level <= 2) {?>
                                                <a class="btn btn-warning btn-sm" href="edittask_page.php?update_id=<?php echo $stmtprotasklistrow['task_id']?>" class="btn btn-warning btn-sm"><i  data-feather="edit"></i></a>
                                                <a class="btn btn-danger btn-sm" href="deletetask.php?delete_id=<?php echo $stmtprotasklistrow['task_id']?>&project_id=<?=$stmtprotasklistrow['project_id']?>"><i data-feather="trash-2"></i></a> 
                                               
                                        <?php } ?>

                                    </td>
                                </tr>
                               
                                
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