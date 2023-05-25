<?php
    session_start();
    require_once 'connect.php';
    /* require_once 'funtion.php'; */
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
    date_default_timezone_set('asia/bangkok');
    $date = date ("Y-m-d H:i");
    $us=$_SESSION['user_login'];
    $id = $_GET['userid'];
    $startdate = "";
    $enddate ="";
    if(isset($_GET['startdate'])){
        $startdate = $_GET['startdate'];
    }
    if(isset($_GET['enddate'])){
    $enddate = $_GET['enddate'];
    }


    
    $select_project = $db->prepare("SELECT * FROM user as u left join position as p on u.role_id = p.role_id  left join department as d on u.department_id = d.department_id WHERE user_id = :id");
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);

    
    $sql2 = "SELECT manager_id FROM project WHERE manager_id =  '$user_id'";
    $sql3 = "SELECT user_id FROM project_list as pl left join project as p ON pl.project_id  =  p.project_id where user_id = '$user_id'";
    $sql4 = "SELECT user_id FROM task_list where user_id = '$user_id' ";
    $sql5 = "SELECT * FROM details as d  left join task_list as t ON d.task_id = t.task_id  where user_id = '$user_id'  AND send_status ='2'";
    $sql6 = "SELECT * FROM task_list  where user_id = '$user_id ' AND status_timetask = '2'";  
    $stmttasklist = "SELECT DISTINCT pl.project_id, pl.user_id, p.project_id, p.name_project, p.description, p.status_1, p.create_project, p.start_date, p.end_date, p.manager_id, p.status_2, p.id_jobtype, p.progress_project, j.id_jobtype, j.name_jobtype, j.status, u.user_id, u.role_id, u.department_id, u2.firstname, u2.lastname, u2.shortname_id, po.role_id, po.position_name, po.level, po.position_status, d.department_id, d.department_name, d.department_status
    FROM project_list AS pl
    LEFT JOIN project AS p ON pl.project_id = p.project_id 
    LEFT JOIN job_type AS j ON p.id_jobtype = j.id_jobtype 
    LEFT JOIN user AS u ON pl.user_id = u.user_id
    LEFT JOIN user AS u2 ON p.manager_id = u2.user_id
    LEFT JOIN position AS po ON po.role_id = u.role_id
    LEFT JOIN department AS d ON d.department_id = u.department_id
    WHERE pl.user_id = $id ";
    
    if (!empty($startdate)) {
        $sql2 .= "AND start_date >= '$startdate' ";
        $sql3 .= "AND start_date >= '$startdate' ";
        $sql4 .= "AND strat_date_task >= '$startdate' ";
        $sql5 .= "AND t.strat_date_task >= '$startdate' ";
        $sql6 .= "AND strat_date_task >= '$startdate' ";
        $stmttasklist .= " AND start_date >= '$startdate' ";

    }
    if (!empty($enddate)) {
        $sql2 .= "AND end_date <= '$enddate' ";
        $sql3 .= "AND end_date <= '$enddate' ";
        $sql4 .= "AND end_date_task <= '$enddate' ";
        $sql5 .= "AND end_date_task <= '$enddate' ";
        $sql6 .= "AND end_date_task <= '$enddate' "; 
        $stmttasklist .= " AND end_date <= '$enddate' "; 
    }
   
    $sql2 = $db->query($sql2); 
    $nummannagerpro = $sql2->rowCount(); 
    $sql3 = $db->query($sql3); 
    $numuserpro = $sql3->rowCount(); 
    $sql4 = $db->query($sql4); 
    $numusertask = $sql4->rowCount(); 
    $sql5 = $db->query($sql5); 
    $numdetails= $sql5->rowCount(); 
    $sql6 = $db->query($sql6); 
    $numdela = $sql6->rowCount();   
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
<form action="reportpropdf.php" method="post" id="viewpro" class="form-horizontal" enctype="multipart/form-data" target="_black">
<input type="hidden" id="proc" name="proc" value="">
<input type="hidden" id="userid" name="userid" value="">
<input type="hidden" id="startdate" name="startdate" value="">
<input type="hidden" id="enddate" name="enddate" value="">
    <main class="content">
    <div>
        <a href="reportuser.php" class="back-button">&lt;</a>
    </div>
    <div class="d-flex flex-row-reverse" >
        <button class="btn btn-flat  btn-danger" id="print" onclick="reportuserpro('<?php echo $id  ?>','<?php echo $startdate  ?>','<?php echo $enddate  ?>');"><i class="fa fa-print"></i> Print</button>
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
                                        <div class="col-md-2 col-sm-8 "><?php echo showshortname($shortname_id).' '.$firstname.' '.$lastname ?></div>
                                        <div class="col-md-2 col-sm-4 d-flex justify-content-end"><b>ตำเเหน่ง : </b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $position_name.' '.'( ฝ่าย'.$department_name.' )' ?></div>
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
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>งานที่ล่าช้า : </b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo $numdela ?></div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 d-flex flex-row-reverse"><b>จำนวนครั้งที่ถูกสั่งเเก้ :</b></div>
                                        <div class="col-md-2 col-sm-8"><?php echo $numdetails ?></div>
                           
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
                                    <h5 class="card-title mb-0">รายการหัวข้องานที่ได้รับมอบหมาย</h5>
                                </div>
                               
                                <div class="row">
                                <?php if(!empty($startdate)){ ?>
                                    <div class="col-md-4 col-sm-4 d-flex flex-row-reverse"><b>วันที่เริ่ม : </b></div>
                                    <div class="col-md-2 col-sm-8"><?php echo thai_date_short(strtotime($startdate))   ?></div>
                                <?php }else{?>
                                    <div class="col-md-4 col-sm-4 d-flex flex-row-reverse"><b>วันที่เริ่ม : </b></div>
                                    <div class="col-md-2 col-sm-8"><?php echo "-";   ?></div>
                                <?php } ?>
                                <?php if(!empty($enddate)){ ?>
                                        <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>วันที่สิ้นสุด :</b></div>
                                        <div class="col-md-3 col-sm-8"><?php echo thai_date_short(strtotime($enddate)) ?></div>
                                <?php }else{?>  
                                    <div class="col-md-2 col-sm-4 d-flex flex-row-reverse"><b>วันที่สิ้นสุด :</b></div>
                                    <div class="col-md-3 col-sm-8"><?php echo "-" ?></div>
                                <?php } ?>  

                                    </div>
                                    <br>
                                    
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
                                            <?php echo showshortname($row2['shortname_id']).' '. $row2['firstname'].' '.$row2['lastname']; ?>
                                            </td>
                                            <td class="action-col" id='action'>
                                           <a class='btn btn-bitbucket btn-sm tooltiptext' title="ดูรายละเอียดหัวข้องาน" href='reportpro.php?projectid=<?php echo  $row2['project_id']?>&userid=<?php echo $id ?>&startdate=<?php echo  $startdate ?>&enddate=<?php echo $enddate ?>'><i class="bi bi-search"></i></a>
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
    function reportuserpro(id,startdate,enddate){
        $('#proc').val('reportuserpro');
        $('#userid').val(id);
        $('#startdate').val(startdate);
        $('#enddate').val(enddate);
        
        console.log(startdate);
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
