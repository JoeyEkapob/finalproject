<?php 
session_start();
 include 'connect.php';
 
 if (isset($_GET['updatetask_id'])){
   
		
        $taskid =  $_REQUEST['updatetask_id'];
        $project_id= $_REQUEST['project_id'];

        $stmttask = $db->prepare("SELECT *  ,concat(firstname,' ',lastname) as name  FROM task_list natural JOIN user  WHERE task_id = :id");
        $stmttask->bindParam(":id", $taskid);
        $stmttask->execute();
        $stmttaskrrow = $stmttask->fetch(PDO::FETCH_ASSOC);
    }   

    $stmt = $db->query("SELECT * FROM details WHERE task_id =  $taskid ORDER BY details_id DESC ");
    $stmt->execute();
    $stmt2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $numsenddetails = $stmt->rowCount();
?> 
<!DOCTYPE html>
<html lang="en">
    <?php include 'head.php'?> 
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
    <form action="proc.php" method="post" id="formedittask" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="status_timetask" name="status_timetask" value="">
    <input type="hidden" id="file_item_task" name="file_item_task" value="">
		<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขงาน</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    
                                    <div class="col-md-6">
                                <?php if($stmttaskrrow['status_task2'] == 0) { ?>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">เปิดงาน</label>
                                                <input class="form-check-input" type="checkbox" role="switch" id="status1" name="status1" onclick="closetask('<?php echo $taskid ?>','<?php echo $project_id ?>')" checked>    
                                            </div>
										</div>
                                    <?php }else{?>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">ปิดงาน</label>
                                                <input class="form-check-input" type="checkbox" role="switch" id="status1" name="status1" onclick="opentask('<?php echo $taskid ?>','<?php echo $project_id ?>')" >     
                                            </div>
										</div>
                                        <?php }?>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="" class="control-label">ชื่องาน</label>
                                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmttaskrrow['name_tasklist']?>">
                                        
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="" class="control-label">วันที่สั่ง</label>
                                            <input type="datetime-local" class="form-control" autocomplete="off" name="start_date" min="<?php echo $stmttaskrrow['strat_date_task'] ?>" value="<?php echo $stmttaskrrow['strat_date_task']?>" >
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="" class="control-label">วันที่สิ้นสุด</label>
                                            <input type="datetime-local" class="form-control"  autocomplete="off" name="end_date" value="<?php echo $stmttaskrrow['end_date_task']?>" >
                                        
                                        </div>
                                    </div>
                                <?php if($numsenddetails == 0){ ?>
                                    <div class="col-md-12">						
                                    <div class="mb-3">
                                            <label for="" class="control-label">สมาชิกทีม</label>
                                                <select name="user" id="type" class="form-select">
                                                <option value="<?php echo $stmttaskrrow['user_id'] ?>"><?php echo $stmttaskrrow['name'] ?></option>
                                                <?php
                                                    $stmtuser = $db->query("SELECT *, concat(firstname,' ',lastname) as name From project_list natural join user where project_id = $project_id");
                                                    $stmtuser->execute();
                                                    $result = $stmtuser->fetchAll();
                                                    foreach($result as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['name'] ?></option>
                                                    <?php } ?>
                                                </select>  
                                        </div>
                                    </div>
                                <?php } ?>
                                    <div class="col-md-12" >						
                                        <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="" class="control-label">ไฟล์เเนบ</label>	
                                                    <div class="file-loading"> 
                                                            <input id="input-b6b" name="files[]" type="file" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple>
                                                    </div>
                                                    <p class="small mb-0 mt-2"><b>รายละเอียด:</b>รองรับไฟล์งาน .pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx <b>ขนาดไฟล์ห้ามเกิน: 20 MB</b></p> 

                                                    <?php 
                                                                    $sql = "SELECT * FROM  file_item_task  WHERE task_id = $taskid";
                                                                    $qry = $db->query($sql);
                                                                    $qry->execute();
                                                                    while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)) {  ?>
                                                    <a><?php echo $row2['filename_task']?>
                                                    <a onclick="delfiletask('<?php echo $row2['file_item_task'] ?>','<?php echo $row2['task_id']?>','<?php echo $project_id?>');"><i data-feather="trash-2"></i></a>
                                                    <!-- <a onclick="delfiletask('<?php echo $row2['file_item_task'] ?>','<?php echo $row2['task_id']?>','<?php echo $project_id?>');"><i data-feather="trash-2"></i></a> -->
                                                    </a> 
                                                </div>
                                                <?php } ?>
                                        </div>
                                        
                                    <div class="justify-content-center">
                                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="7" name="textarea"><?php echo trim($stmttaskrrow['description_task']);?></textarea>
                                        
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <hr>
                                        <div class="col-lg-12 text-right justify-content-center d-flex">
                                            <button class="btn btn-primary " name ="edittask" onclick="edit_task('<?php echo $taskid ?>','<?php echo $project_id?>','<?php echo $stmttaskrrow['status_timetask'] ?>');">เเก้ไข</button>
                                            <a href="view_project.php?view_id=<?php echo $project_id?>" class="btn btn-secondary" type="button"  >กลับ</a>
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
<script>
    $(document).ready(function() {
    $("#input-b6b").fileinput({
        showUpload: false,
        dropZoneEnabled: false,
        maxFileCount: 10,
        inputGroupClass: "input-group"
    });
});
     function edit_task(taskid,project_id,status_timetask){
        $('#proc').val('edittask');
        $('#task_id').val(taskid);
        $('#project_id').val(project_id);
        $('#status_timetask').val(status_timetask);
        console.log(status_timetask);
    }
  /*   function delfiletask(file_item_task,taskid,project_id){
        $('#proc').val('delfiletask');
        $('#task_id').val(taskid);
        $('#file_item_task').val(file_item_task);
        $('#project_id').val(project_id);
        $('#formedittask').submit();
    } */

    function delfiletask(file_item_task,taskid,project_id) {
            Swal.fire({
                title: 'คุณต้องการลบไฟล์งานใช่หรือไม่',
                icon: 'error',
                //text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ต้องการลบ!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
               
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'proc.php',
                                type: 'post',
                                data: 'proc=' + 'delfiletask' + '&project_id=' + project_id + '&taskid=' + taskid + '&file_item_task=' + file_item_task ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ลบงานเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'edittask_page.php?updatetask_id='+ taskid + '&project_id=' + project_id;
                                    
                                    
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
        function closetask(taskid,project_id) {
                Swal.fire({
                title: 'คุณต้องการปิดงานใช่หรือไม่',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่ต้องการปิด!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                            url: 'proc2.php',
                            type: 'post',
                            data: 'proc=' + 'closetask' + '&taskid=' + taskid + '&project_id=' + project_id,
                        })
                        .done(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'ปิดงานเเล้ว!',
                                icon: 'success',
                                confirmButtonText: 'ตกลง!',
                            }).then(() => {
                                document.location.href = 'view_project.php?view_id='+ project_id  ; 
                            })
                        })
                        .fail(function() {
                            Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                            window.location.reload();
                        });
                    });
                },
                }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.reload();
            }
        });
    }
    function opentask(taskid,project_id) {
            Swal.fire({
            title: 'คุณต้องการเปิดงานใช่หรือไม่',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่ต้องการปิด!',
            cancelButtonText: 'กลับ',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: 'proc2.php',
                        type: 'post',
                        data: 'proc=' + 'opentask' + '&taskid=' + taskid + '&project_id=' + project_id,
                    })
                    .done(function(response) {
                        console.log(response);
                        if (response != 1) {
                            Swal.fire({
                                title: 'เปิดงานเรียบร้อยเเล้ว!',
                                text: '',
                                icon: 'success',
                                confirmButtonText: 'ตกลง!',
                            }).then(() => {
                                document.location.href = 'view_project.php?view_id='+ project_id  ; 
                            })
                        } else {
                            Swal.fire({
                                title: 'เวลาของานนี้ได้หมดลงเเล้วไม่สามารถเปิดหัวข้องานได้!',
                                text: '',
                                icon: 'error',
                                confirmButtonText: 'ตกลง!',
                            }).then(() => {
                                window.location.reload();
                            })  
                        }
                    })
                    .fail(function() {
                        Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                        window.location.reload();
                    });
                });
            },
            }).then((result) => {
        if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.reload();
        }
    });
    }
</script>
<?php include "footer.php"?>