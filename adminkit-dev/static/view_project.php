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
    <div class="row">
                        
                        <div class="col-12 col-lg-8 col-xxl-12 d-flex">
                            <div class="card flex-fill">  
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">ชื่อโปรเจค</b></dt>
                                                    <dd><?php  ?>หกดหกดหกดหกด</dd>
                                                    <dt><b class="border-bottom border-primary">คำอธิบาย</b></dt>
                                                    <dd><?php ?>หกดกหดหกด</dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">ผู้สร้างโปรเจค</b></dt>
                                                    <dd>
                                                        <?php //if(isset($manager['id'])) : ?>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="" alt="Avatar">
                                                            <b><?php  ?></b>
                                                        </div>
                                                    </dd>
                                                </dl> 
                                            </div>
                                            <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันที่เริ่ม</b></dt>
                                                    <dd><?php ?>กหดหกดหก</dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันสิ้นสุด</b></dt>
                                                    <dd><?php ?>หกดหกดกหด</dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                    <dd>
                                                    
                                                    </dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สมาชิก</b></dt>
                                                    <dd>
                                                        <?php //if(isset($manager['id'])) : ?>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="" alt="Avatar">
                                                            <b><?php  ?></b>
                                                        </div>
                                                    </dd>
                                                </dl> 
                                            </div>
                                            <div class="col-md-12">
                                            <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>
                                            <div class="d-flex align-items-center mt-1">
                                                         
                                                            <b><?php  ?></b>
                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!--  </div>
                </div>
            </div> --> 




       <!--  <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
                        <div class="d-flex flex-row-reverse bd-highligh">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="sign-up.php"><i class="fa fa-plus"></i>  + Add New User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        
                        <div class="row">
                            <div class="col-12 col-lg-8 col-xxl-12 d-flex">
                                <div class="card flex-fill">
                                    <div class="card-header">
                                        
                                        <div class="d-flex flex-row-reverse">
                                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href=""><i class="fa fa-plus"></i>  + Add task</a>
                                        </div>
                                        <div class="d-flex justify-content-start">
                                            <h5 class="card-title mb-0">รายการงาน</h5>
                                            </div>
                                    </div>
                                   
                                    <table class="table table-hover my-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="d-none d-xl-table-cell">ชื่องาน</th>
                                                <th class="d-none d-md-table-cell">คำอธิบาย</th>
                                                <th class="">สถานะ</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i = 1;
                                            //$type = array('',"Admin","คณบดี","รองคณบดีฝ่ายวิชาการ","ผู้ชวยรองรองคณบดีฝ่ายวิชาการ","หัวหน้าหน่วย","หัวสาขา","เจ้าหน้าที่");
                                           /*  $sql = "SELECT *,concat(firstname,' ',lastname) as name 
                                            FROM user as u
                                            LEFT JOIN position AS p  ON  u.role_id = p.role_id
                                            order by concat(firstname,' ',lastname) asc ";
                                            $qry = $db->query($sql);
                                            $qry->execute(); */
                                          /*   while ($row = $qry->fetch(PDO::FETCH_ASSOC)){ */
                                                //extract($row);
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php  ?></td>
                                            <td><?php  ?></td>
                                            <td><?php ?></td>
                                            <td class=""><?php ?></td>
                                            <td class="text-center">                               
                                              <!--   <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>                   -->        
                                                <!-- <a href="edituser_page.php?update_id=<?php echo $row['user_id']?>" class="btn btn-warning btn-sm">2</a>   --> 
                                                <!-- <a href="edituser_page.php?update_id=<?php echo $row['user_id']?>" class="btn btn-warning btn-sm">2</a>
                                                <a href="deleteuser.php?delete_id=<?php echo $row['user_id']?>" class="btn btn-danger btn-sm" >trash</a> -->
                                            </td>
                                        </tr>
                                        <?php include "viewuser_modal.php"?>
                                        
                                            <?php// } ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
        </main>
        
</form>

    </body>
</html>
<?php include "footer.php"?>
