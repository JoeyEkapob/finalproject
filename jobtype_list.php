<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
    if(isset($_POST['addjob'])){
        $namejob = $_POST['namejob'];
        $status = 1;
        if (empty($namejob)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อประเภทงาน';
           // header("location: addjobtype.php");

        }else if (!isset($_SESSION['error'])) {
            $stmtjob = $db->prepare("INSERT INTO job_type(name_jobtype,status) 
                                VALUES(:namejob, :status)");
            $stmtjob->bindParam(":namejob", $namejob);
            $stmtjob->bindParam(":status", $status);
            $stmtjob->execute();
            $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! ";
            header("location: jobtype_list.php");
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            header("location: jobtype_list.php");
        } 
    } 

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

<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
    <main class="content">
        <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
                        <div class="d-flex flex-row-reverse bd-highligh">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" data-bs-toggle="modal" data-bs-target="#addModal1" ><i class="fa fa-plus"></i> + เพิ่มประเภทงาน</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           
                 
                          
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">ประเภทงาน</h5>
                        </div>
                            <table class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-left">ชื่อประเภทงาน</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        
                                        $sql = "SELECT * FROM job_type  WHERE status = 1";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                            //extract($row);
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="text-left"><?php echo $row['name_jobtype'] ?></td>
                                            <td class="text-center">                               
                                               <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                       
                                                <!-- <a href="edituser_page.php?update_id=<?php echo $row['id_jobtype']?>" class="btn btn-warning btn-sm">2</a>   --> 
                                                <a class="btn btn-warning btn-sm" title="เเก้ไขข้อมูลประเภทงาน" href="editjobtype_page.php?update_id=<?php echo $row['id_jobtype']?>"><i  data-feather="edit"></i></a>
                                                <a class="btn btn-danger btn-sm" title="ลบข้อมูลประเภทงาน" href="deletejobtype.php?delete_id=<?php echo $row['id_jobtype']?>"><i data-feather="trash-2"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>           
                            </table>
                            <?php include 'addjobtype_model.php'?>
                    </div>
                        
                  
        </main>
        
</form>

    </body>
</html>
<?php include "footer.php"?>