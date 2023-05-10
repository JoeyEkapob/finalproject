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
    <main class="content">
    <?php if($level != 5 ): ?>
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
                            <div class="table-responsive-xl">
                                <table class="table table-hover" id="example">
                                    <thead>
                                        <tr>
                                            <th class="id-col text-center">ลำดับ</th>
                                            <th class="name-col">ชื่อโปรเจค</th>
                                            <th class="progress-col text-center">ความคืบหน้า</th>
                                            <th class="start-col text-center">วันที่เริ่ม</th>
                                            <th class="end-col text-center ">วันที่สิ้นสุด</th>
                                            <th class="status-col text-center ">สถานะ</th>
                                            <th class="action-col text-center">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            $where = "";    
                                            if($row['level'] >= 3 ){
                                                $where = " where manager_id = '{$_SESSION['user_login']}' ";   
                                            }
                                        /*  $numsql ="SELECT COUNT(task_id) as numtask, task_list.* FROM task_list natural JOIN project ";
                                            $numqry = $db->query($numsql);
                                            $numqry->execute(); */
                                            
                                        
                                            $sql = "SELECT * FROM project  $where order by end_date,status_2  DESC ";
                                            $qry = $db->query($sql);
                                            $qry->execute();
                                            while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                                $pro_id=$row['project_id'];
                                                $stmt = $db->query("SELECT * FROM task_list WHERE project_id =  $pro_id");
                                                $numtask = $stmt->rowCount();
                                        ?>
                                        
                                            <tr>
                                                <td class="id-col"><?php echo $i++ ?></td>
                                                <td class="name-col">
                                                    <p><b><?php echo $row["name_project"]?></b>
                                                    <?php showstatpro2($row['status_2']);?></p>
                                                    <p class="truncate"><?php echo mb_substr($row['description'],0,20).'...';  ?></p>
                                                </td>

                                                <td class="progress-col">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:<?php echo number_format($row['progress_project'],2) ?>%" ><?php  echo number_format($row['progress_project'],2) ?></div>
                                                    </div>
                                                </td>

                                            
                                                <td class="start-col" ><?php echo ThDate($row['start_date']) ?></td>
                                                <td class="end-col"><?php echo ThDate($row['end_date'])  ?></td>

                                                

                                                <td class="status-col">
                                                    <?php showstatpro($row['status_1']);  ?>
                                                </td>
                                                <td class="action-col">                   
                                                <!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                      
                                                    <a class="btn btn-bitbucket btn-sm" href="view_project.php?view_id=<?php echo $row['project_id']?>"><i data-feather="zoom-in"></i></a>
                                                
                                                    <a class="btn btn-warning btn-sm" href="editproject_page.php?update_id=<?php echo $row['project_id']?>"><i data-feather="edit"></i></a>
                                                   

                                                    <?php 
                                                        if ($numtask == 0 || $row['status_1'] == 4) {
                                                        echo '<button class="btn btn-danger btn-sm delete-btn"  data-project_id="'.$row['project_id'].'"><i data-feather="trash-2"></i></button>';

                                                        } else {
                                                        echo '<button class="btn btn-danger btn-sm disabled" onclick="deleteproject(\''. $row['project_id'] .'\')"><i data-feather="trash-2"></i></button>';
                                                        }
                                                        ?>
                                                </td>
                                            </tr>
                                            
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
/* function deleteproject(project_id){
    $('#proc').val('deleteproject');
    $('#project_id').val(project_id);
}
 */
        $(".delete-btn").click(function(e) {
            var project_id = $(this).data('project_id');
            console.log(project_id);
            e.preventDefault();
            deleteConfirm(project_id);
        })

        function deleteConfirm(project_id) {
            Swal.fire({
                title: 'คุณต้องการลบหัวข้องาน',
                icon: 'error',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่ต้องการลบ!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'deleteproject' + '&project_id=' + project_id,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ลบหัวข้องานเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                    confirmButtonText: 'ตกลง!',
                                }).then(() => {
                                    document.location.href = 'project_list.php';
                                    
                                    
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