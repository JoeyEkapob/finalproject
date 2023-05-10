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
    $taskid = $_GET['taskid'];
    $projectid = $_GET['projectid'];

    
    $select_project = $db->prepare("SELECT * FROM project as p 
    left join task_list as t ON p.project_id = t.project_id  
    left join user as u ON t.user_id = u.user_id  
    WHERE task_id = :id");
    $select_project->bindParam(":id",  $taskid);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
 /*    $numtask = $db->query("SELECT * FROM task_list where project_id = $id ");
    $numtask = $numtask->rowCount(); */

    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);  

    
    $stmt = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 1   ");
    $numsenddetails = $stmt->rowCount();
    $stmt2 = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 2   ");
    $numchkdetails = $stmt2->rowCount(); 
    $stmt3 = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 1  AND status_timedetails = 2 ");
    $chktimesend = $stmt3->rowCount();
   /*  $stmt2 = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 2   ");
    $numchkdetails = $stmt2->rowCount();  */
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>

<body>
<?php include "sidebar.php"?>
<?php include "funtion.php"?>
<form action="reportpropdf.php" method="post" id="viewpro" class="form-horizontal" enctype="multipart/form-data" target="_blank">

    <main class="content">
    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="projectid" name="projectid" value="">
    <input type="hidden" id="taskid" name="taskid" value="">
    <div>
        <a href="reportpro.php?projectid=<?php echo $projectid ?>" class="back-button">&lt;</a>
    </div>
    <div class="col-12 d-flex flex-row-reverse" >
        <button class="btn btn-flat  btn-danger" id="print" onclick="report('<?php echo  $projectid ?>','<?php echo  $taskid ?>');"><i class="fa fa-print"></i>PDF</button>
       
    </div>
 

        <div id ="Receipt" >
            <div class="col-12  d-flex" >
                <div class="card flex-fill">  
                    <div class="card-header">
                        <div class="row">
                            
                            <div class="project-image">
                                    <img src="pic/LOGORMUTK.png" class="project-image">
                            </div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>รหัสงาน :</b></div>
                                        <div class="col-md-3 col-sm-8 "><?php echo $task_id ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>ชื่องาน :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $name_tasklist ?></div>
                                    </div>

                                    <div class="row">
                                    <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>ผู้สร้างงาน :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $manager['name'] ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>ความคืบหน้า :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $progress_task ?> %</div>
                                       
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>วันที่เริ่ม :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo  thai_date_and_time_short($strat_date_task) ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>วันที่สิ้นสุด :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo thai_date_and_time_short($end_date_task) ?></div>
                                    </div>

                                  
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>ผู้รับผิดชอบ :</b></div>
                                        <div class="col-md-9 col-sm-8"><?php echo $firstname.' '.$lastname ?></div>
                                    </div>
                                </div>
                           
                                             
                        </div>                       
                    </div>
                </div>
            </div> 
        </div> 
        
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="card flex-fill">
                            <div class="card-header">
                             
                                <div class="d-flex justify-content-start">
                                    <h5 class="card-title mb-0">รายการรายละเอียดงาน</h5>
                                </div>

                                <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>ส่งทั้งหมด :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo  $numsenddetails ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>เเก้ไขทั้งหมด  :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $numchkdetails ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>ส่ง (ล่าช้า) :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo  $chktimesend ?></div>
                                        
                                    </div>
                                    <br>
                            <div class="table-responsive-xl">
                                <table class="table m-0 table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="id-col">ครั้งที่</th>
                                            <th class="namepro-col">ชื่องาน</th>
    
                                            <th class=" namepro-col">วันที่ส่ง</th>
                                            <th class="comptask-col" >ความคืบหน้า</th>
                                            <th class="action-col">สถานะ</th>
                                            <th class="action-col">หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                <tbody>
  
                                        <?php
                                            $i = 1;
                                            $send_status =1;
                                            $sqldetailsuser = $db->prepare('SELECT * FROM details  NATURAL JOIN task_list  NATURAL JOIN project where task_id = :task_id AND send_status = :send_status');
                                            $sqldetailsuser->bindParam(":task_id", $task_id);
                                            $sqldetailsuser->bindParam(":send_status", $send_status);
                                            $sqldetailsuser->execute();
                                            while ($sqldetailsuser2 = $sqldetailsuser->fetch(PDO::FETCH_ASSOC)) {
                                            
                                            /* $stmttasklist = "SELECT *
                                            FROM task_list 
                                            NATURAL JOIN user 
                                            WHERE project_id = $id";
                                            $stmttasklist = $db->query($stmttasklist);
                                            $stmttasklist->execute();  
                                            while ($row2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){
                                                $task_id = $row2['task_id'];
                                             
                                                $stmt = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 1   ");
                                                $numsenddetails = $stmt->rowCount();
                                                $stmt2 = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 2   ");
                                                $numchkdetails = $stmt2->rowCount();  */
                                                    ?>
                                        <tr>
                                            <td class="id-col">
                                            <?php echo $i++ ?>
                                            </td>

                                            <td class="numtask-col">
                                                <?php echo $sqldetailsuser2['name_tasklist']  ?>
                                            </td>

                                            <td class="numtask-col ">
                                                <?php echo thai_date_and_time_short($sqldetailsuser2['date_detalis'])?> 
                                            </td>
                                             
                                            <td  class="numtask-col " >
                                            <?php echo $sqldetailsuser2['progress_details'] ?> %
                                            </td>

                                            <td class="mannager-col">
                                            <?php echo showstatdetail($sqldetailsuser2['state_details']).showstatustimepdf($sqldetailsuser2['status_timedetails']) ?>
                                            </td>

                                           <td class="action-col">
                                                    <?php  echo  showtdetailtext($sqldetailsuser2['detail']);?>
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
        </div>
        </main>
        
</form>
    </body>
</html>
<script>
    function report(projectid,taskid) {
     $('#proc').val('reporttaskdetails');
     $('#projectid').val(projectid);
     $('#taskid').val(taskid);
     console.log(taskid);
    } 
   /*      function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#Receipt').clone();
        printcontent.find('#action').remove();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    } */
function searchreport(){
    var proc = "searchreport"; 
    var nameproject = $('#nameproject').val();
    var job = $('#job').val();
    var startdate = $('#startdate').val();
    var enddate = $('#enddate').val();
    var status1 = $('#status1').val();
    var status2 = $('#status2').val();
}
 </script>
<?php include "footer.php"?>
<!--  <table class="project-details">
                                <tr>
                                    <td class ="class1" ><b>รหัสหัวข้องาน  :</b></td>
                                    <td class ="class3" ><?php echo $project_id ?></td>
                                    <td class ="class2" ><b>ชื่อโปรเจค :</b></td>
                                    <td class ="class4" ><?php echo $name_project ?></td>
                                </tr>
                              
                                <tr>
                                    <td class ="class1" ><b>ประเภทงาน : </b></td>
                                    <td class ="class3" ><?php echo $name_jobtype ?></td>
                                    <td class ="class2" ><b>ผู้สร้างโปรเจค :</b></td>
                                    <td class ="class4" ><?php echo $manager['name'] ?></td>
                                </tr>
                               
                            
                                <tr>
                                    <td class ="class1" ><b>วันที่เริ่ม : </b></td>
                                    <td class ="class3" ><?php echo  ThDate($start_date) ?></td>
                                    <td class ="class2" ><b>วันที่สิ้นสุด :</b></td>
                                    <td class ="class4" ><?php echo ThDate($end_date) ?></td>
                                </tr>
                                <tr>
                                    <td class ="class1" ><b>ความคืบหน้า : </b></td>
                                    <td class ="class3" ><?php echo $progress_project ?> %</td>
                                    <td class ="class2" ><b>จำนวนงานในหัวข้องาน :</b></td>
                                    <td class ="class4" ><?php echo $numtask ?></td>
                                </tr>
                                <tr>
                                <td class ="class1"  ><b>สมาชิก : </b></td>
                                <td>  <?php 
                                    $sql = "SELECT * FROM project_list  natural join user  where project_id = $id ";
                                    $qry = $db->query($sql);
                                    $qry->execute();
                                    $numpsuer = $qry->rowcount();
                                    $i = 0;
                                    while ($row = $qry->fetch(PDO::FETCH_ASSOC)){  ?>  
                                                
                                   <?php 
                                    echo  $row['firstname']." ".$row['lastname'];
                                    /* if (++$i != $numpsuer) {
                                        echo ' , ';
                                    }if($i == 3){
                                        echo ' <br>';
                                    } */
                                   
                                   ?>
                                    <?php }?></td>
                                <td>  
                                </tr>
                            </table> -->
                          