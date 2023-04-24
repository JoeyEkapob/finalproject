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
<form action="proc.php" method="post" id="viewpro" class="form-horizontal" enctype="multipart/form-data">

    <main class="content">
    <div class="d-flex flex-row-reverse" >
        <button class="btn btn-flat  btn-danger" id="print" onclick="printContent('Receipt');"><i class="fa fa-print"></i> Print</button>
    </div>
        <div id ="Receipt" >
            <div class="col-12  d-flex" >
                <div class="card flex-fill">  
                    <div class="card-header">

                        <div class="row">
                            <div class="project-image">
                                    <img src="pic/LOGORMUTK.png" class="project-image">
                            </div>

                            <table >
                                <tr>
                                    <td class ="class1" >ชื่อ-นามสกุล : </td>
                                    <td class ="class3" ><?php echo $firstname.' '.$lastname ?></td>
                                    <td class ="class2" >ตำเเหน่ง : </td>
                                    <td class ="class4" ><?php echo $position_name ?></td>
                                </tr>
                              
                                <tr>
                                    <td class ="class1" >หัวข้องานที่สร้าง : </td>
                                    <td class ="class3" ><?php echo $nummannagerpro  ?></td>
                                    <td class ="class2" >หัวข้องานที่ถูกสั่ง : </td>
                                    <td class ="class4" ><?php  echo $numuserpro ?></td>
                                </tr>
                               
                            
                                <tr>
                                    <td class ="class1" >จำนวนงาน : </td>
                                    <td class ="class3" ><?php echo  $numusertask   ?></td>
                                    <td class ="class2" >จำนวนครั้งที่ถูกสั่งเเก้ :</td>
                                    <td class ="class4" ><?php echo $numdetails ?></td>
                                </tr>
                                
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
                                                จำนวนงาน
                                            </th>
                                            <th  class="comptask-col">
                                                งานที่เสร็จ
                                            </th>
                                            <th  class="success-col">         
                                                ความสำเร็จ
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
                                            <?php echo  $numtask ?>
                                            </td>
                                             
                                            <td  class="numtask-col " >
                                            <?php echo $comptask2 ?>
                                            </td>

                                            <td class="mannager-col">
                                            <?php echo $row2['progress_project']; ?>
                                            </td>

                                            <td class="mannager-col">
                                            <?php echo $row2['firstname'].' '.$row2['lastname']; ?>
                                            </td>
                                            <td class="action-col" id='action'>
                                           <a class='btn btn-bitbucket btn-sm' href='reportpro.php?projectid=<?php echo  $row2['project_id']?>'>รายละเอียด</a>
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
 </script>
<?php include "footer.php"?>
