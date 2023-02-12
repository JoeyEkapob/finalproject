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
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
<form action="adduser.php" method="post" class="form-horizontal" enctype="multipart/form-data">
    <main class="content">
        <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
                        <div class="d-flex flex-row-reverse bd-highligh">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" data-bs-toggle="modal" data-bs-target="#addModal1" ><i class="fa fa-plus"></i>  + Add New User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    
                                <div class="card ">
                                    <div class="card-header">

                                        <h5 class="card-title mb-0">สมาชิก</h5>
                                    </div>
                                    <table class="table table-hover table-responsive" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-left">NAME</th>
                                                <th class="text-left">Email</th>
                                                <th class="text-left">ตำเเหน่ง</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i = 1;
                                            //$type = array('',"Admin","คณบดี","รองคณบดีฝ่ายวิชาการ","ผู้ชวยรองรองคณบดีฝ่ายวิชาการ","หัวหน้าหน่วย","หัวสาขา","เจ้าหน้าที่");
                                            $sql = "SELECT *,concat(firstname,' ',lastname) as name FROM user natural join position order by concat(firstname,' ',lastname) asc ";
                                            $qry = $db->query($sql);
                                            $qry->execute();
                                            while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                                //extract($row);
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="text-left"><?php echo ucwords($row['name']) ?></td>
                                            <td class="text-left" ><?php echo $row['email'] ?></td>
                                            <td class="text-left" ><?php echo $row['position_name']?></td>
                                            <td class="text-center">                               
                                                <a class="btn btn-bitbucket btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal"><i data-feather="zoom-in"></i></a>                                                  
                                                <a class="btn btn-warning btn-sm" href="edituser_page.php?update_id=<?php echo $row['user_id']?>"><i  data-feather="edit"></i></a>
                                                <a class="btn btn-danger btn-sm" href="deleteuser.php?delete_id=<?php echo $row['user_id']?>"><i data-feather="trash-2"></i></a>
                                            </td>
                                        </tr>
                                        <?php //include "adduser_modal.php"?>
                                        
                                            <?php } ?>
                                        </tbody>
                                        
                                    </table>
                                    <?php include "adduser_modal.php"?>
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