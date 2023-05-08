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
    $id = $_GET['userid'];
    $targetDir = "img/avatars/";
    $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","ส่งเรียบร้อยเเล้ว","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
    $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    
    $select_project = $db->prepare("SELECT * FROM user as u left join position as p on u.role_id = p.role_id  WHERE user_id = :id");
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $sql2 = $db->query("SELECT * FROM project WHERE manager_id =  $user_id"); 
    $nummannagerpro = $sql2->rowCount(); 
    $sql3 = $db->query("SELECT * FROM project_list where user_id = $user_id");
    $numuserpro = $sql3->rowCount(); 
    $sql4 = $db->query("SELECT * FROM task_list where user_id = $user_id ");
    $numusertask = $sql4->rowCount(); 
    $sql5 = $db->query("SELECT * FROM details as d  left join task_list as t ON d.task_id = t.task_id  where user_id = $user_id  AND send_status = 2");
    $numdetails= $sql5->rowCount(); 
  
   /*  $numtask = $db->query("SELECT * FROM task_list where project_id = $id ");
    $numtask = $numtask->rowCount();  */

    /* $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);
 */

?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>

<body>
<?php include "sidebar.php"?>
<?php include "funtion.php"?>
<form action="reportpropdf.php" method="post" id="viewpro" class="form-horizontal" enctype="multipart/form-data" target="_black">
<input type="hidden" id="proc" name="proc" value="">
<input type="hidden" id="userid" name="userid" value="">
    <main class="content">
    <div>
        <a href="reportuser.php" class="back-button">&lt;</a>
    </div>
    <div class="d-flex flex-row-reverse" >
        <button class="btn btn-flat  btn-danger" id="print" onclick="reportuserpro('<?php echo $id  ?>');"><i class="fa fa-print"></i> Print</button>
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
                                        <div class="col-md-4 col-sm-4 d-flex flex-row-reverse"><b>ชื่อ-นามสกุล : </b></div>
                                        <div class="col-md-2 col-sm-8 "><?php echo $firstname.' '.$lastname ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex justify-content-end"><b>ตำเเหน่ง : </b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $position_name ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 d-flex flex-row-reverse"><b>หัวข้องานที่สร้าง : </b></div>
                                        <div class="col-md-2 col-sm-8"><?php echo $nummannagerpro  ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>หัวข้องานที่ถูกสั่ง : </b></div>
                                        <div class="col-md-3 col-sm-8"><?php  echo $numuserpro ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 d-flex flex-row-reverse"><b>จำนวนงาน : </b></div>
                                        <div class="col-md-2 col-sm-8"><?php echo  $numusertask   ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>จำนวนครั้งที่ถูกสั่งเเก้ :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $numdetails ?></div>
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
                                    <h5 class="card-title mb-0">รายการหัวข้องาน</h5>
                                </div>
                           
                            <div class="table-responsive-xl">
                                <table class="table m-0 table-bordered" >
                                    <thead>
                                    <tr>
                                            <th class="id-col">
                                                รหัสหัวข้องาน
                                            </th>
                                            <th  class="namepro-col" >
                                                ชื่อหัวข้องาน
                                            </th>
                                            <th  class="jobtype-col" >
                                                ประเภทงาน
                                            </th>
                                            <th  class="numtask-col">
                                                วันที่เริ่ม -  วันที่สิ้นสุด
                                            </th>
                                            <!-- <th  class="comptask-col">
                                                วันที่สิ้นสุด
                                            </th> -->
                                            <th  class="success-col">         
                                                สถานะ
                                            </th>
                                            <!--  <th>         
                                                สถานะเร่งของงาน
                                            </th> -->
                                             <th  class="mannager-col" >         
                                                คนที่มอบหมาย
                                            </th> 
                                            <th  class="action-col" id='action'>         
                                                Action
                                            </th> 
                                        </tr>
                                    </thead>
                                <tbody>
  
                                        <?php
                                            $i = 1;
                                            
                                            $stmttasklist = "SELECT *
                                            FROM project_list 
                                            NATURAL JOIN project 
                                            NATURAL JOIN job_type 
                                            NATURAL JOIN user 
                                      
                                            WHERE user_id = $id";
                                            $stmttasklist = $db->query($stmttasklist);
                                            $stmttasklist->execute();  
                                            while ($row2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){
                                                 $project_id = $row2['project_id'];
                                                 $sql2 = $db->query("SELECT * FROM task_list WHERE project_id =  $project_id ");
                                                 $numtask = $sql2->rowCount(); 
                                                 $comptask = $db->query("SELECT * FROM task_list where project_id = $project_id  and status_task = 5");
                                                 $comptask2 = $comptask->rowCount(); 
                                             
                                                    ?>
                                        <tr>
                                            <td class="id-col">
                                            <?php echo $row2['project_id']; ?>
                                            </td>

                                            <td class="">
                                            <?php echo $row2['name_project']; ?>
                                            </td>

                                            <td class="">
                                            <?php echo $row2['name_jobtype']; ?>
                                            </td>

                                            <td class=" numtask-col" >
                                            <?php echo  thai_date_short(strtotime($row2['start_date'])).' - '. thai_date_short(strtotime($row2['end_date']))  ?>
                                            </td>
                                             
                                            <td  class="numtask-col " >
                                            <?php echo showstatprotext1($row2['status_1']).' ('.showstatprotext2($row2['status_2']).')' ?>
                                            </td>


                                            <td class="mannager-col">
                                            <?php echo $row2['firstname'].' '.$row2['lastname']; ?>
                                            </td>
                                            <td class="action-col" id='action'>
                                           <a class='btn btn-bitbucket btn-sm' href='reportpro.php?projectid=<?php echo  $row2['project_id']?>&userid=<?php echo $id ?>'>รายละเอียด</a>
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
    function reportuserpro(id){
        $('#proc').val('reportuserpro');
        $('#userid').val(id);
        
        console.log(userid);
    }

/* function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#Receipt').clone();
        printcontent.find('#action').remove();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    } */
 </script>
<?php include "footer.php"?>
