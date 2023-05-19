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
<?php include "sidebar.php" ?>
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

    <input type=hidden id="proc" name="proc" value="">
    <!-- <input type=hidden id="id_jobtype" name="id_jobtype" value=""> -->
        
    <main class="content">
        <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
                        <div class="d-flex flex-row-reverse bd-highligh">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" data-bs-toggle="modal" data-bs-target="#adddepartment" ><i class="fa fa-plus"></i> + เพิ่มฝ่ายงาน</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           
                 
                          
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">ฝ่าย</h5>
                        </div>
                            <table class="table table-hover my-0" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-left">ชื่อฝ่าย</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        
                                        $sql = "SELECT * FROM department  WHERE department_status = 1";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($departmentrow = $qry->fetch(PDO::FETCH_ASSOC)){
                                         /*   print_r($row); */
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="text-left"><?php echo $departmentrow['department_name'] ?></td>
                                            <td class="text-center">
                                                
                                            <a class="btn btn-warning btn-sm" title="เเก้ไขข้อมูลประเภทงาน" href="editdepartment.php?update_id=<?php echo $departmentrow['department_id']?>"><i  data-feather="edit"></i></a>
                                            <button class="btn btn-danger btn-sm deletedepartment-btn" title="ลบข้อมูลประเภทงาน" data-department_id="<?php echo $departmentrow['department_id']?>"><i data-feather="trash-2"></i></button> 
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>           
                            </table>
                            
                            <?php   include 'addmodel.php'  ?>
                    </div>
                        
                  
        </main>
        
</form>

    </body>
</html>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});

function adddepartment(){
    $('#proc').val('adddepartment');
    console.log(proc)
}

     $(".deletedepartment-btn").click(function(e) {
            var department_id = $(this).data('department_id');
            console.log(department_id);
            e.preventDefault();
            deleteConfirm(department_id);
        }) 

       function deleteConfirm(department_id) {
           // console.log(id_jobtype);
            Swal.fire({
                
                title: 'คุณต้องลบประเภทงานใช่หรือไม่',
                icon: 'error',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่ต้องการยกเลิก!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                
                    return new Promise(function(resolve) {
               
                        $.ajax({
                            
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'deldepartment' + '&department_id=' + department_id ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ยกเลิกเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'departmant_list.php';
                                    
                                    
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        } 
</script>
<?php include "footer.php"?>