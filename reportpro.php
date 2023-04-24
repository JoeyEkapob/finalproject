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
    $targetDir = "img/avatars/";
    $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","ส่งเรียบร้อยเเล้ว","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
    $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    
    $select_project = $db->prepare("SELECT * FROM project  natural JOIN job_type  WHERE project_id = :id");
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
    $numtask = $db->query("SELECT * FROM task_list where project_id = $id ");
    $numtask = $numtask->rowCount(); 

    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>

<body>
<?php include "sidebar.php"?>
<?php include "funtion.php"?>
<form action="proc.php" method="post" id="viewpro" class="form-horizontal" enctype="multipart/form-data">

    <main class="content">
    <div class="d-flex flex-row-reverse" >
        <button class="btn btn-flat  btn-danger" id="print" onclick="printContent('Receipt');"><i class="fa fa-print"></i> Print</button>
</div >
        <div id ="Receipt" >
            <div class="col-12  d-flex" >
                <div class="card flex-fill">  
                    <div class="card-header">

                        <div class="row">
                            <div class="project-image">
                                    <img src="pic/LOGORMUTK.png" class="project-image">
                            </div>

                            <table class="project-details">
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
                                <td class ="class1" ><b>สมาชิก : </b></td>
                                <td>  <?php 
                                    $sql = "SELECT * FROM project_list  natural join user  where project_id = $id ";
                                    $qry = $db->query($sql);
                                    $qry->execute();
                                    $numpsuer = $qry->rowcount();
                                    $i = 0;
                                    while ($row = $qry->fetch(PDO::FETCH_ASSOC)){  ?>  
                                                
                                   <?php 
                                    echo  $row['firstname']." ".$row['lastname'];
                                    if (++$i !== $numpsuer) {
                                        echo ' , ';
                                    }if($i == 3){
                                        echo ' <br>';
                                    }
                                   
                                   ?>
                                    <?php }?></td>
                                <td>  
                                </tr>
                            </table>
                                
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
                           
                            <div class="table-responsive-xl">
                                <table class="table m-0 table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="id-col">ลำดับที่</th>
                                            <th class="namepro-col">ชื่องาน</th>
                                            <th class="comptask-col" >ความสำเร็จ</th>
                                            <th class=" namepro-col">จำนวนครั้งที่ส่งงาน</th>
                                            <th class="namepro-col">จำนวนที่ถูกกลับเเก้</th>
                                            <th class="mannager-col">มอบหมาย</th>
                                            <th class="action-col">สถานะ</th>
                                   
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
                                                <?php echo $i++ ?>
                                            </td>

                                            <td class="namepro-col">
                                                <?php echo $row2['name_tasklist']  ?>
                                            </td>

                                            <td class="comptask-col">
                                                <?php echo $row2['progress_task'] ?> %
                                            </td>

                                            <td class=" numtask-col" >
                                                <?php echo  $numsenddetails ?>
                                            </td>
                                             
                                            <td  class="numtask-col " >
                                            <?php echo  $numchkdetails ?>
                                            </td>

                                            <td class="mannager-col">
                                                    <?php  echo $row2['firstname']." ".$row2['lastname'] ?>  
                                            </td>

                                            <td class="action-col">
                                                    <?php  echo  showstattaskreport($row2['status_task']);?>
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
        function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#Receipt').clone();
        printcontent.find('#action').remove();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
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
