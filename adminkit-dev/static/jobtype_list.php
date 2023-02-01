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
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="addjobtype.php"><i class="fa fa-plus"></i>  + Add Job type</a>
                        </div>
                    </div>
                </div>
            </div>
                    <div class="row">
                            <div class="col-12 col-lg-8 col-xxl-12 d-flex">
                                <div class="card flex-fill">
                                    <div class="card-header">

                                        <h5 class="card-title mb-0">ประเภทงาน</h5>
                                    </div>
                                    <table class="table table-hover my-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับ</th>
                                                <th class="d-none d-xl-table-cell">ชื่อประเภทงาน</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i = 1;
                                            //$type = array('',"Admin","คณบดี","รองคณบดีฝ่ายวิชาการ","ผู้ชวยรองรองคณบดีฝ่ายวิชาการ","หัวหน้าหน่วย","หัวสาขา","เจ้าหน้าที่");
                                            $sql = "SELECT * 
                                            FROM job_type  WHERE status = 1";
                                            $qry = $db->query($sql);
                                            $qry->execute();
                                            while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                                //extract($row);
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $row['name_jobtype'] ?></td>
                                            
                                            <td class="text-center">                               
                                               <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                       
                                                <!-- <a href="edituser_page.php?update_id=<?php echo $row['id_jobtype']?>" class="btn btn-warning btn-sm">2</a>   --> 
                                                <a href="editjobtype_page.php?update_id=<?php echo $row['id_jobtype']?>" class="btn btn-warning btn-sm">2</a>
                                                <a href="deletejobtype.php?delete_id=<?php echo $row['id_jobtype']?>" class="btn btn-danger btn-sm" >trash</a>
                                            </td>
                                        </tr>
                                       
                                        
                                            <?php } ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
        </main>
        
</form>

    </body>
</html>
<?php include "footer.php"?>