<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css" 
<?php include "sidebar.php"?>
<?php include "funtion.php"?>
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

<form action="proc.php" method="post" class="form-horizontal" enctype="multipart/form-data">

    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <main class="content">
    <?php if($level != 5 ): ?>
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
                            <table class="table table-hover my-0" id="example" >
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-left">ชื่อโปรเจค</th>
                                        <th class="text-left">ความคืบหน้า</th>
                                        <th class="text-center">วันที่เริ่ม</th>
                                        <th class="text-center">วันที่สิ้นสุด</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        $where = "";    
                                        if($row['level'] >= 3 ){
                                            $where = " where manager_id = '{$_SESSION['user_login']}' ";   
                                        }
                                       /*  $numsql ="SELECT COUNT(task_id) as numtask, task_list.* FROM task_list natural JOIN project ";
                                        $numqry = $db->query($numsql);
                                        $numqry->execute(); */
                                        
                                      
                                        $sql = "SELECT * FROM project  $where order by end_date,status_2  DESC ";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                            $pro_id=$row['project_id'];
                                            $stmt = $db->query("SELECT * FROM task_list WHERE project_id =  $pro_id");
                                            $numtask = $stmt->rowCount();
                                    ?>
                                    
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                             <td>
                                                <p><b><?php echo $row["name_project"]?></b>
                                                <?php showstatpro2($row['status_2']);?></p>
                                                <p class="truncate"><?php echo substr($row['description'],0,100).'...';  ?></p>
						                    </td>

                                            <td class="">

                                            <div class="progress ">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo number_format($row['progress_project'],2) ?>%" ><?php  echo number_format($row['progress_project'],2) ?></div>
                                            </div>

                                            </td>

                                         
                                            <td class="text-center" ><?php echo ThDate($row['start_date']) ?></td>
					                        <td class="text-center "><?php echo ThDate($row['end_date']) ?></td>

                                            

                                            <td class="text-center">
                                                <?php showstatpro($row['status_1']);  ?>
                                            </td>
                                            <td class="text-center">                   
                                               <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                      
                                                <a class="btn btn-bitbucket btn-sm" href="view_project.php?view_id=<?php echo $row['project_id']?>"><i data-feather="zoom-in"></i></a>
                                                <a class="btn btn-warning btn-sm" href="editproject_page.php?update_id=<?php echo $row['project_id']?>"><i data-feather="edit"></i></a>
                                                <?php 
                                                    if ($numtask == 0) {
                                                    echo '<button class="btn btn-danger btn-sm" onclick="deleteproject(\''. $row['project_id'] .'\')"><i data-feather="trash-2"></i></button>';
                                                    } else {
                                                    echo '<button class="btn btn-danger btn-sm disabled" onclick="deleteproject(\''. $row['project_id'] .'\')"><i data-feather="trash-2"></i></button>';
                                                    }
                                                    ?>
                                            </td>
                                        </tr>
                                        
                                    <?php } ?>
                                </tbody>           
                            </table>
                    </div>
                        
                  
        </main>
        
</form>

    </body>
</html>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});
function deleteproject(project_id){
    $('#proc').val('deleteproject');
    $('#project_id').val(project_id);
}

</script>
<?php include "footer.php"?>