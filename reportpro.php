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
    $id = $_GET['projectid'];

    if(isset($_GET['userid'])){
        $userid = $_GET['userid'];
    }
 
/* echo $userid ;
exit; */
    $select_project = $db->prepare("SELECT * FROM project  natural JOIN job_type  WHERE project_id = :id");
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
    $numtask = $db->query("SELECT * FROM task_list where project_id = $id ");
    $numtask = $numtask->rowCount(); 

    $stmt2 = $db->query("SELECT * FROM task_list WHERE project_id =  $id AND status_timetask = 2   ");
    $numchktime = $stmt2->rowCount();

    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);


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
    <div>
        <?php if(isset($userid)){?>
        <a href="reportuserpro.php?userid=<?php echo $userid?>" class="back-button">&lt;</a>
        <?php }else{ ?>
        <a href="report.php" class="back-button">&lt;</a>
         <?php } ?>    
    </div>
    <div class="col-12 d-flex flex-row-reverse" >
        <button class="btn btn-flat  btn-danger" id="print" onclick="report('<?php echo  $id ?>');"><i class="fa fa-print"></i>PDF</button>
       
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
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>รหัสหัวข้องาน :</b></div>
                                        <div class="col-md-3 col-sm-8 "><?php echo $project_id ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>ชื่อโปรเจค :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $name_project ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse "><b>ประเภทงาน :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $name_jobtype ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>ผู้สร้างโปรเจค :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $manager['name'] ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>วันที่เริ่ม :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo  ThDate($start_date) ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>วันที่สิ้นสุด :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo ThDate($end_date) ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>ความคืบหน้า :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $progress_project ?> %</div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>สถานะ :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo showstatprotext1($status_1).'(' .showstatprotext2($status_2).')' ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>สมาชิก :</b></div>
                                        <div class="col-md-9 col-sm-8">
                                        <?php 
                                            $sql = "SELECT * FROM project_list  natural join user  where project_id = $id ";
                                            $qry = $db->query($sql);
                                            $qry->execute();
                                            $numpsuer = $qry->rowcount();
                                            $i = 0;
                                            while ($row = $qry->fetch(PDO::FETCH_ASSOC)){  
                                            echo $row['firstname']." ".$row['lastname'];
                                            if (++$i != $numpsuer) {
                                                echo ' , ';
                                            }if($i % 3 == 0) {
                                                echo '<br>';
                                            }
                                            }
                                            
                                        ?>
                                        </div>
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
                                    <h5 class="card-title mb-0">รายการงาน</h5>
                                </div>
                                 <div class="row">
                                        <div class="col-md-3 col-sm-4 d-flex flex-row-reverse"><b>จำนวนงาน :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $numtask  ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>จำนวนงานที่ล่าช้า :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $numchktime ?></div>
                                </div>
                                <br>
                            <div class="table-responsive-xl">
                                <table class="table m-0 table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="id-col">ลำดับที่</th>
                                            <th class="namepro-col">ชื่องาน</th>
    
                                            <th class=" namepro-col">วันที่เรื่ม - วันที่สิ้นสุด</th>
                                            <th class="comptask-col" >ความสำเร็จ</th>
                                            <th class="mannager-col">มอบหมาย</th>
                                            <th class="action-col">สถานะ</th>
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
                                             
                                                $stmt = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 1   ");
                                                $numsenddetails = $stmt->rowCount();
                                                $stmt2 = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 2   ");
                                                $numchkdetails = $stmt2->rowCount();
                                                    ?>
                                        <tr>
                                            <td class="id-col">
                                            <?php echo $row2['task_id']  ?>
                                            </td>

                                            <td class="numtask-col">
                                                <?php echo $row2['name_tasklist']  ?>
                                            </td>

                                            <td class="comptask-col">
                                                <?php echo thai_date_short(strtotime($row2['strat_date_task'])).' - '.thai_date_short(strtotime($row2['end_date_task'])) ?> 
                                            </td>
                                             
                                            <td  class="numtask-col " >
                                            <?php echo $row2['progress_task'] ?> %
                                            </td>

                                            <td class="mannager-col">
                                                    <?php  echo $row2['firstname']." ".$row2['lastname'] ?>  
                                            </td>

                                            <td class="action-col">
                                                    <?php  echo  showstattaskreport($row2['status_task']);?>
                                            </td>
                                            <td class="action-col" id='action'>
                                                <a class='btn btn-bitbucket btn-sm' href='reporttaskdetails.php?taskid=<?php echo $row2['task_id']?>&projectid=<?php echo $id ?>'>รายละเอียด</a>
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
    function report(id) {
     $('#proc').val('reportpro');
     $('#projectid').val(id);
     console.log(projectid);
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
                          