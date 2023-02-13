<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
    $us=$_SESSION['user_login'];
    $id = $_GET['view_id'];
    $targetDir = "img/avatars/";
    $json='';
    $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","ส่งเรียบร้อยเเล้ว","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
    $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    $select_project = $db->prepare('SELECT * FROM project  natural JOIN job_type  WHERE project_id = :id');
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);

    //$imageURL = 'img/avatars/'.$manager['avatar'];
   /*  if(!isset($_POST['addtask_btn'])){
        echo 5424245245245;

        /*  $stat = 1 ;
      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
      $taskname =$_POST['taskname'];
      $user=$_POST['user'];
      $textarea=$_POST['textarea'];
      $pro_id= $_GET['view_id']
     // $file_task = null;

      $stmttask = $db->prepare("INSERT INTO task_list(name_tasklist, description_task,status_task, strat_date_task,end_date_task,file_task,project_id,user_id) 
      VALUES(:taskname,:textarea,:status,:start_date,:end_date,:file_task,:pro_id,:users_id)");
       $stmttask->bindParam(":taskname", $proname);
       $stmttask->bindParam(":textarea", $textarea);
       $stmttask->bindParam(":status", $stat);
       $stmttask->bindParam(":start_date", $start_date);
       $stmttask->bindParam(":end_date", $end_date);
       $stmttask->bindParam(":file_task",$file_task);
       $stmttask->bindParam(":pro_id", $pro_id);
       $stmttask->bindParam(":users_id",$user );
       $stmttask->execute();   
    } */
    /* $stmt = $db->query("SELECT * FROM project where project_id=2");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $json='';*/

?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
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
         
<form action="addtask.php" method="post" class="form-horizontal" enctype="multipart/form-data">
    <main class="content">
                 
                    <div class="col-12  d-flex">
                         <div class="card flex-fill">  
                             <div class="card-header">
                                 <div class="row">
                                    <div class="col-md-6">
                                                <dl>
                                                    
                                                    <dt><b class="border-bottom border-primary">ชื่อโปรเจค</b><?php
                                                     if ($status_2 == '1') {
                                                        echo " "."<span class='badge bg-secondary'>".$stat2[$status_2]."</span>";
                                                    }else if($status_2 == '2'){
                                                        echo " "."<span class='badge bg-warning'>".$stat2[$status_2]."</span>";
                                                    }else if($status_2 == '3'){
                                                        echo " "."<span class='badge bg-danger'>".$stat2[$status_2]."</span>";
                                                    }
                                                    //echo "  "."<span class='badge bg-danger'>".$stat2[$status_2]."</span>" ?></dt>
                                                    <dd><?php echo $name_project  ?></dd>

                                                    <dt><b class="border-bottom border-primary">คำอธิบาย</b></dt>
                                                    <dd><?php echo $description ?></dd>

                                                    <dt><b class="border-bottom border-primary">ประเภทงาน</b></dt>
                                                    <dd><?php echo $name_jobtype ?></dd>


                                                </dl>
                                                <dl>

                                                    

                                                    <dt><b class="border-bottom border-primary">ผู้สร้างโปรเจค</b></dt>
                                                    <dd> 
                                                         <div class="d-flex align-items-center mt-1">
                                                            <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $manager['avatar']?>" alt="Avatar" width="35"  height="35">
                                                            <b><?php echo $manager['name'] ?> </b>
                                                        </div>
                                                    </dd>

                                                </dl> 
                                        </div>

                                            <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันที่เริ่ม</b></dt>
                                                    <dd><?php echo date("F d, Y",strtotime($start_date)) ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันสิ้นสุด</b></dt>
                                                    <dd><?php echo date("F d, Y",strtotime($end_date)) ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                    <dd>
                                                        <?php
                                                    if($status_1 =='1'){
                                                    echo "<span class='badge bg-secondary'>".$stat1[$status_1]."</span>";
                                                }elseif($status_1 =='2'){
                                                    echo "<span class='badge bg-primary'>".$stat1[$status_1]."</span>";
                                                }elseif($status_1 =='3'){
                                                    echo "<span class='badge bg-success'>".$stat1[$status_1]."</span>";
                                                }elseif($status_1 =='4'){
                                                    echo "<span class='badge bg-warning'>".$stat1[$status_1]."</span>";
                                                }elseif($status_1 =='5'){
                                                    echo "<span class='badge bg-danger'>".$stat1[$status_1]."</span>";
                                                }elseif($status_1 =='6'){
                                                    echo "<span class='badge bg-danger'>".$stat1[$status_1]."</span>";
                                                }
                                                ?>
                                                    </dd>
                                                </dl>
                                                <dl>
                                                    
                                                    <dt><b class="border-bottom border-primary">สมาชิก</b></dt>
                                                    <dd>
                                                        <?php //if(isset($manager['id'])) :
                                                         /* foreach($row as $result) {
                                                                    $json = $users_id;     
                                                            }
                                                            $array = json_decode($json);
                                                                foreach($array as $value) { */
                                                                    $sql = "SELECT * FROM project_list  natural join user  where project_id = $id ";
                                                                    $qry = $db->query($sql);
                                                                    $qry->execute();
                                                                    while ($row = $qry->fetch(PDO::FETCH_ASSOC)){  ?>  
                                                                     
                                                         
                                                                <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/<?php echo $row['avatar']?>" alt="Avatar" width="35"  height="35">
                                                                <b><?php  echo $row['firstname']." ".$row['lastname'] ?></b>
                                                            <?php  }?>
                                                    </dd>
                                                </dl> 
                                            </div>
                                            <div class="col-md-12">
                                            <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>
                                            <div class="d-flex align-items-center mt-1">
                                             <b></b>
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
                                <?php   
                                        if ($manager_id == $us || $level <= 2) {?>
                                <div class="d-flex flex-row-reverse">
                                    <a class="btn btn-block btn-sm btn-default btn-flat border-primary"  type="button" id="new_task" data-bs-toggle="modal" data-bs-target="#addModal1"> <i class="fa fa-plus"></i>  + Add task</a>
                                </div>
                                <?php  } ?>
                                <div class="d-flex justify-content-start">
                                    <h5 class="card-title mb-0">รายการงาน</h5>
                                    </div>
                            </div>
                            
                            <table class="table table-hover my-0">
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
                                    $stmttasklist = "SELECT * FROM task_list natural join user where project_id = $id ";
                                    $stmttasklist = $db->query($stmttasklist);
                                    $stmttasklist->execute();
                                    while ($row2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){  ?>  
                             <tr>
                                    <td class="text-center">
                                        <?php echo $i++ ?>
                                    </td>

                                    <td>
                                        <h5><b><?php echo $row2['name_tasklist']  ?></h5></b>
                                        <p class="truncate"><?php echo substr($row2['description_task'],0,100).'...';  ?></p>
                                    </td>
    
                                    <td >
                                        <?php echo date("F d, Y",strtotime($row2['strat_date_task'])); ?>
                                    </td>

                                    <td>
                                        <?php echo date("F d, Y",strtotime($row2['end_date_task'])); ?>
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

                                       <a class="btn btn-bitbucket btn-sm" href="viewtask_page.php?update_id=<?php echo $row2['task_id']?>"><i data-feather="zoom-in"></i></a>

                                      <?php if($row2['user_id'] == $us || $level <= 2 || $manager_id == $us ){?>
                                       <a href="?update_id=<?php echo $row2['task_id']?>" class="btn btn-success btn-sm"  ><i data-feather="share"></i></a>

                                       <?php } ?>  

                                       <?php if ($manager_id == $us || $level <= 2) {?>
                                                <a class="btn btn-warning btn-sm" href="edittask_page.php?update_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>" class="btn btn-warning btn-sm"><i  data-feather="edit"></i></a>
                                                <a class="btn btn-danger btn-sm" href="deletetask.php?delete_id=<?php echo $row2['task_id']?>&project_id=<?=$row2['project_id']?>"><i data-feather="trash-2"></i></a> 
                                               
                                        <?php } ?>

                                    </td>
                                </tr>
                               
                                
                                    <?php } ?>
                                </tbody>
                                <?php include "addtask_model.php"?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
</form>

    </body>
    <script>

    </script>
</html>


<?php include "footer.php"?>
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
