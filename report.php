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
    <form action="proc.php" method="post" id="userlist" class="form-horizontal" enctype="multipart/form-data">

        <main class="content">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">รายงาน</h5>
                    </div>
                    <div class="card-body">
						<div class="row">
                            <div class="container">
                                <div class="row g-1">
                                    <div class="col-3 ">
                                    </div>
                                        <div class="col-3 ">
                                            <label for="control-label" style="font-size: 14px;">ชื่อหัวข้องาน</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" class="form-control" placeholder="Input">
                                            </div>
                                        </div>
                                        
                                        <div class="col-3">
                                            <label for="control-label" style="font-size: 14px;">ประเภทงาน</label>

                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" class="form-control" placeholder="Input">
                                            </div>
                                        </div>
                                        <div class="col-3 ">
                                        </div>
                                        <div class="col-3 ">
                                        </div>
                                        <div class="col-3">
                                            <label for="control-label" style="font-size: 14px;">วันที่เริ่ม</label>

                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" class="form-control" placeholder="Input">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <label for="control-label" style="font-size: 14px;">วันที่สิ้นสุด</label>
                                                <div class="input-group input-group-sm mb-2">
                                                    <input type="text" class="form-control" placeholder="Input">
                                                </div>
                                        </div>
                                        <div class="col-3 ">
                                        </div>
                                        <div class="col-3 ">
                                        </div>
                                        <div class="col-3">
                                            <label for="control-label" style="font-size: 14px;">สถานะงาน</label>
                                                <div class="input-group input-group-sm mb-2">
                                                    <input type="text" class="form-control" placeholder="Input">
                                                </div>
                                            </div>
                                        <div class="col-3">
                                            <label for="control-label" style="font-size: 14px;">การเร่งของงาน</label>
                                                <div class="input-group input-group-sm mb-2">
                                                    <input type="text" class="form-control" placeholder="Input">
                                                </div>
                                        </div>
                                        <div class="col-3">
                                        </div>
                                      
                                            <div class="col-lg-12 text-right justify-content-center d-flex">
                                            <button class="btn btn-primary" id="display_selected"  >ค้นหา</button> 
                                            <a class="btn btn-secondary" href="" type="button" >ล้างค่า</a>


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

<?php include "footer.php"?>