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
    <?php if($row['level'] != 5 ): ?>
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
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-left">ชื่อโปรเจค</th>
                                        <th class="text-center">วันที่เริ่ม</th>
                                        <th class="text-center">วันที่สิ้นสุด</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","อยู่ระหว่างการตรวจสอบ","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
                                        $where = "";    
                                        if($row['level'] >= 3 ){
                                            $where = "natural join project_list where user_id  = '{$_SESSION['user_login']}'"  ;
                                            echo 555;
                                        }
                                        $sql = "SELECT * FROM project  $where order by name_project asc ";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                           
                                    ?>
                                    
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                             <td>
                                                <p><b><?php echo $row["name_project"]?></b></p>
                                                <p class="truncate"><?php echo substr($row['description'],0,100).'...';  ?></p>

						                    </td>
                                         
                                            <td class="text-center" ><b><?php echo date("M d, Y",strtotime($row['start_date'])) ?></b></td>
					                        <td class="text-center "><b><?php echo date("M d, Y",strtotime($row['end_date'])) ?></b></td>
                                            <td class="text-center">
                                                <?php
                                                /*  echo $stat1[$row['status_1']];
                                                 exit; */

                                                if($row['status_1'] =='1'){
                                                    echo "<span class='badge bg-secondary'>{$stat1[$row['status_1']]}</span>";
                                                }elseif($row['status_1'] =='2'){
                                                    echo "<span class='badge bg-primary'>{$stat1[$row['status_1']]}</span>";
                                                }elseif($row['status_1'] =='3'){
                                                    echo "<span class='badge bg-success'>{$stat1[$row['status_1']]}</span>";
                                                }elseif($stat1[$row['status_1']] =='4'){
                                                    echo "<span class='badge bg-warning'>{$stat1[$row['status_1']]}</span>";
                                                }elseif($stat1[$row['status_1']] =='5'){
                                                    echo "<span class='badge bg-danger'>{$stat1[$row['status_1']]}</span>";
                                                }elseif($stat1[$row['status_1']] =='6'){
                                                    echo "<span class='badge bg-danger'>{$stat1[$row['status_1']]}</span>";
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">                   
                                               <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                       
                                                 <a href="view_project.php?view_id=<?php echo $row['project_id']?>" class="btn btn-primary btn">2</a>   
                                                <!-- <a href="editproject.php?update_id=<?php echo $row['project_id']?>" class="btn btn-warning btn-sm">2</a>
                                                <a href="deleteproject.php?delete_id=<?php echo $row['project_id']?>" class="btn btn-danger btn-sm" >trash</a> -->
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
</script>
<?php include "footer.php"?>