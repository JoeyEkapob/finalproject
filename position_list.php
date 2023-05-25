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

<form action="proc.php" method="post" class="form-horizontal" enctype="multipart/form-data">

    <input type=hidden id="proc" name="proc" value="">
    <input type=hidden id="id_jobtype" name="id_jobtype" value="">
        
    <main class="content">
        <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
                        <div class="d-flex flex-row-reverse bd-highligh">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" data-bs-toggle="modal" data-bs-target="#addposition" ><i class="fa fa-plus"></i> + เพิ่มตำเเหน่ง</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           
                 
                          
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">ตำเเหน่ง</h5>
                        </div>
                            <table class="table table-hover my-0" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-left">ชื่อตำเเหน่ง</th>
                                        <th class="text-left">ระดับ</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        
                                        $sql = "SELECT * FROM position WHERE position_status = 1 ";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                            //extract($row);
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="text-left"><?php echo $row['position_name'] ?></td>
                                            <td class="text-left"><?php echo $row['level'] ?></td>
                                            <td class="text-center">                               
                                               <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                       
                                                <!-- <a href="edituser_page.php?update_id=<?php echo $row['role_id']?>" class="btn btn-warning btn-sm">2</a>   --> 
                                                <a class="btn btn-warning btn-sm" title="เเก้ไขข้อมูลตำเเหน่ง" href="editposition.php?update_id=<?php echo $row['role_id']?>"><i  data-feather="edit"></i></a>
                                                <button class="btn btn-danger btn-sm deleteposition-btn" title="ลบข้อมูลตำเเหน่ง" data-role_id="<?php echo $row['role_id']?>" data-level="<?php echo $row['level']?>" ><i data-feather="trash-2"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>           
                            </table>
                            <?php include 'addmodel.php'?>
                    </div>
                        
                  
        </main>
        
</form>

    </body>
</html>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});

function addposition(){
    $('#proc').val('addposition');
}

    $(".deleteposition-btn").click(function(e) {
            var role_id = $(this).data('role_id');
            var level = $(this).data('level');
            console.log(level);
            e.preventDefault();
            deleteConfirm(role_id,level);
        })

        function deleteConfirm(role_id,level) {
            console.log(level);
            Swal.fire({
                
                title: 'คุณต้องยกเลิกตำเเหน่งใช่หรือไม่',
                icon: 'error',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ยกเลิก!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                
                    return new Promise(function(resolve) {
               
                        $.ajax({
                            
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'delposition' + '&role_id=' + role_id + '&level=' + level,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'เรียบร้อย',
                                    text: 'ยกเลิกเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'position_list.php';
                                    
                                    
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