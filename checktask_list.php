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
    <input type="hidden" id="details_id" name="details_id" value="">
    <main class="content">
    
           
                 
                          
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">รายการโปรเจค</h5>
                        </div>
                        <div class="table-responsive-xl">
                            <table class="table table-hover my-0" id="example" >
                                <thead>
                                    <tr>
                                        <th class="id-col text-center">ลำดับ</th>
                                        <th class="name-col text-center">ชื่อโปรเจค</th>
                                        <th class="name-col text-center ">ชื่องาน</th>
                                        <th class="start-col text-center">วันที่สั่งงาน</th>
                                        <th class="end-col text-center">วันที่ส่ง</th>
                                        <th class="status-col text-center ">สถานะ</th>
                                        <th class="action-col text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        $where = "";    
                                        if($row['level'] >= 3 ){
                                            $where = " where manager_id = '{$_SESSION['user_login']}' AND state_details	= 'y'";   
                                        }else{
                                            $where = " where state_details	= 'y'";
                                        }
                                       /*  $numsql ="SELECT COUNT(task_id) as numtask, task_list.* FROM task_list natural JOIN project ";
                                        $numqry = $db->query($numsql);
                                        $numqry->execute(); */
                                        
                                      
                                        $sql = "SELECT *
                                        FROM details
                                        natural  JOIN task_list/*  ON details.task_id = task_list.task_id */
                                        natural  JOIN project 
                                        natural  JOIN user  $where /* ON details.project_id = project.project_id; */";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                          /*   $pro_id=$row['project_id'];
                                            $stmt = $db->query("SELECT * FROM task_list WHERE project_id =  $pro_id");
                                            $numtask = $stmt->rowCount(); */
                                            $manager_id = $row['manager_id'];
                                            $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
                                            $manager = $manager->fetch(PDO::FETCH_ASSOC);  
                                            
                                    ?>
                                  
                                        <tr class="id-col">
                                            <td ><?php echo $i++ ?></td>
                                                <td class="name-col">
                                                    <b><?php echo $row['name_project'] ?></b>
						                        </td>

                                            <td class="name-col">
                                                <b><?php echo $row['name_tasklist']?>
                                            </td>

                                            <td class="start-col " ><?php echo ThDate($row['strat_date_task']); ?></td>
					                        <td class="end-col " ><?php echo ThDate($row['date_detalis']) ?></td>

                                            

                                            <td class="status-col ">
                                                <?php  showstattask($row['status_task']);  ?>
                                                
                                            </td>
                                            <td class="text-center">                   
                                               <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                      
                                                <a class="btn btn-bitbucket btn-sm" title="ดูรายละเอียดงาน" data-bs-toggle="modal" data-bs-target="#viewdetailsmodal<?php echo $row['details_id']?>"><i data-feather="zoom-in"></i></a>
                                                <button class="btn btn-success btn-sm checktasksuccess" title="เช็คว่างงานเสร็จสิ้นเรียบร้อย" data-details_id="<?php echo $row['details_id'] ?>" data-task_id="<?php echo $row['task_id'] ?>" data-project_id="<?php echo $row['project_id'] ?>"> <i data-feather="check-square"></i></button>
                                                <a class="btn btn-warning btn-sm" href="checktaskedit.php?details_id=<?php echo $row['details_id'] ?>&task_id=<?php echo $row['task_id'] ?>&project_id=<?php echo $row['project_id'] ?>&progress_task=<?php echo $row['progress_task']?>"> <i data-feather="check-square"></i></a>
                                                <!-- <a class="btn btn-warning btn-sm" href=""><i data-feather="share"></i></a> -->
                                  
                                            </td>
                                        </tr>
                                    
                                       
                                        <?php  include "viewdetails_model.php"  ?>
                                    <?php } ?>
                                </tbody>           
                            </table>
                            </div>
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

$(".checktasksuccess").click(function(e) {
            var project_id = $(this).data('project_id');
            var task_id  = $(this).data('task_id');
            var details_id  = $(this).data('details_id');
            console.log(details_id);
            e.preventDefault();
            checktasksuccess(project_id, task_id,details_id);
        })

        function checktasksuccess(project_id,task_id,details_id) {
            console.log(details_id);
            Swal.fire({
                
                title: 'งานชิ้นนี้เสร็จสิ้นเเล้วใช่หรือไม่',
                icon: 'info',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่งานเสร็จเเล้ว!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                
                    return new Promise(function(resolve) {
               
                        $.ajax({
                            
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'checktasksuccess' + '&project_id=' + project_id + '&task_id=' + task_id + '&details_id=' + details_id ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ตรวจงานเสร็จเรียบร้อย!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'checktask_list.php';
                                    
                                    
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
/* function checktasksuccess(details_id,task_id,project_id){
    $('#proc').val('checktasksuccess');
    $('#details_id').val(details_id);
    $('#task_id').val(task_id);
    $('#project_id').val(project_id);
    $('#proc').submid
} */
/* function checktaskedit(details_id,task_id,project_id){
    $('#proc').val('checktaskedit');
    $('#details_id').val(details_id);
    $('#task_id').val(task_id);
    $('#project_id').val(project_id);
} */
</script>
<?php include "footer.php"?>