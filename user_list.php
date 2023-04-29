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

        <input type=hidden id="proc" name="proc" value="">
        <input type=hidden id="user_id" name="user_id" value="">

        <main class="content">
            <div class="col-lg-12">
                <div class="card card-outline card-success">
                    <div class="container-fluid p-0">
                        <div class="card-header">
                            <div class="d-flex flex-row-reverse bd-highligh">
                                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" data-bs-toggle="modal" data-bs-target="#adduserModal" ><i class="fa fa-plus"></i>  + Add New User</a>
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
                                                <th class="text-left">ชื่อ-นามสกุล</th>
                                                <th class="text-left">อีเมลล์</th>
                                                <th class="text-left">ตำเเหน่ง</th>
                                                <th class="text-left">ฝ่าย</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                        <?php
                                            $i = 1;
                                            //$type = array('',"Admin","คณบดี","รองคณบดีฝ่ายวิชาการ","ผู้ชวยรองรองคณบดีฝ่ายวิชาการ","หัวหน้าหน่วย","หัวสาขา","เจ้าหน้าที่");
                                            $sql = "SELECT *,concat(firstname,' ',lastname) as name FROM user natural join position natural join department  order by concat(firstname,' ',lastname) asc ";
                                            $qry = $db->query($sql);
                                            $qry->execute();
                                            
                                            while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                                //extract($row);
                                                $user_id = $row['user_id'];
                                                $stmt = $db->query("SELECT * FROM project_list WHERE user_id =  $user_id");
                                                $meproject = $stmt->rowCount();
                                           
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="text-left"><?php echo ucwords($row['name']) ?></td>
                                            <td class="text-left" ><?php echo $row['email'] ?></td>
                                            <td class="text-left" ><?php echo $row['position_name']?></td>
                                            <td class="text-left" ><?php echo $row['department_name']?></td>
                                            <td class="text-center">  
                                            <a  class="resetbtn" type="button"  data-user_id ="<?php echo $row['user_id']?>"> <h3> <i data-feather="key"></i> </h3> </a>
                            
                                             <a class="btn btn-bitbucket btn-sm view_data"  title="ดูรายละเอียด" data-bs-toggle="modal" data-bs-target="#viewusermodal<?php echo $row['user_id']?>" ><i data-feather="zoom-in"></i></a> 
                                                <!--  <a class="btn btn-bitbucket btn-sm view_data"  id="<?php echo $row['user_id']?>" ><i data-feather="zoom-in"></i></a>        -->                                             
                                                <a class="btn btn-warning btn-sm" title="เเก้ไขข้อมูลสมาชิก" href="edituser_page.php?update_id=<?php echo $row['user_id']?>"><i  data-feather="edit"></i></a>
                                                <?php if($meproject == 0 OR $level == 1)  {?>
                                                    <a class="btn btn-danger btn-sm deluserbtn" title="ลบข้อมูลสมาชิก" data-user_id ="<?php echo $row['user_id']?>"><i data-feather="trash-2"></i></a>
                                                <?php   } else {?>
                                                    <a class="btn btn-danger btn-sm deluserbtn disabled" title="ลบข้อมูลสมาชิก" data-user_id ="<?php echo $row['user_id']?>"><i data-feather="trash-2"></i></a>
                                                    <?php } ?>
                                            </td>
                                        </tr>   
                                        <?php include "viewuser_modal.php"?>
                                            <?php } ?>
                                     </tbody>   
                                     <?php include "adduser_modal.php"?> 
                                 </table>
                                 
                                 
                                </div>
                            
                            <?php //include "viewuser_modal.php"?>
        </main>
        
    </form>
    </body>

</html>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});

    function Preview(ele) {
        $('#img').attr('src', ele.value);
                if (ele.files && ele.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }
                reader.readAsDataURL(ele.files[0]);
            }
        }
        function adduser(){
            $('#proc').val('adduser');
        }
       /*  function resetpass(user_id){
            console.log('user_id');
            $('#proc').val('resetpass');
            $('#user_id').val(user_id);
            $('#userlist').submit();
        } */
        $(".resetbtn").click(function(e) {
            var user_id = $(this).data('user_id');
            console.log(user_id);
            e.preventDefault();
            resetbtn(user_id);
        })

        function resetbtn(user_id) {
            Swal.fire({
                title: 'คุณต้องการรีเซ็ตพาสเวิร์ดใช่หรือไม่',
                icon: 'info',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ต้องการรีเซ็ตพาสเวิร์ด!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'resetpass' + '&user_id=' + user_id  ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'รีเซ็ตพาสเวิร์ดเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'user_list.php';
                                    
                                    
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
        $(".deluserbtn").click(function(e) {
            var user_id = $(this).data('user_id');
            console.log(user_id);
            e.preventDefault();
            deluserbtn(user_id);
        })

        function deluserbtn(user_id) {
            Swal.fire({
                title: 'คุณต้องการลบสมาชิกใช่หรือไม่',
                icon: 'error',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ต้องการลบสมาชิก!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'deluserbtn' + '&user_id=' + user_id  ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ลบสมาชิกเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'user_list.php';
                                    
                                    
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