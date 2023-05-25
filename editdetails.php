<?php 
session_start();
 include 'connect.php';
 date_default_timezone_set('asia/bangkok');
 $date = date ("Y-m-d H:i");
 if (isset($_GET['details_id'])){
   
        $details_id = $_GET['details_id'];
        $taskid =  $_GET['task_id'];
        $project_id= $_GET['project_id'];
        //$progress_task= $_GET['progress_task'];

        $stmtdetails = $db->prepare("SELECT *  ,concat(firstname,' ',lastname) as name  FROM details natural JOIN task_list natural JOIN project natural JOIN user  WHERE details_id = :details_id");
        $stmtdetails->bindParam(":details_id", $details_id);
        $stmtdetails->execute();
        $stmtdetailsrrow = $stmtdetails->fetch(PDO::FETCH_ASSOC);
    }   

?> 
<!DOCTYPE html>
<html lang="en">
    <form action="proc.php" method="post" id="editdetails" class="form-horizontal" enctype="multipart/form-data">
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
    <input type="hidden" id="proc" name="proc" value="">
    <input type="hidden" id="task_id" name="task_id" value="">
    <input type="hidden" id="project_id" name="project_id" value="">
    <input type="hidden" id="details_id" name="details_id" value="">
    <input type="hidden" id="senddate" name="senddate" value=" ">
   <input type="hidden" id="state_details" name="state_details" value=""> 
   <input type="hidden" id="progress_task" name="progress_task" value=""> 
   <input type="hidden" id="file_details_id" name="file_details_id" value=""> 

		<main class="content">
        <a href="details_page.php?task_id=<?php echo $taskid ?>&project_id=<?php echo $project_id ?>" class="back-button">&lt;</a> 
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขรายละเอียดงานที่ถูกส่งมา</h1>
				</div>
					<div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">ชื่อหัวข้องาน</label>
                                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmtdetailsrrow['name_project']?> " disabled>
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">ชื่องาน</label>
                                            <input type="text" name="taskname" class="form-control" value="<?php echo $stmtdetailsrrow['name_tasklist']?> " disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">วันที่ส่งงาน</label>
                                            <input type="datetime-local" class="form-control" autocomplete="off" name="date1" value="<?php echo $stmtdetailsrrow['date_detalis']?>" disabled >
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="control-label">วันที่ส่งกลับเเก้ไข</label>
                                            <input type="datetime-local" class="form-control"   autocomplete="off" name="date_detalis"  value="<?php echo $stmtdetailsrrow['date_detalis'] ; ?>" disabled>
                                        
                                        </div>
                                    </div>
                                   <!--  <div class="justify-content-center">
                                        <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                        <textarea class="form-control" name="text_comment" id="exampleFormControlTextarea1" rows="7" disabled> <?php// echo $stmttaskrrow['comment']?></textarea>
                                    </div> -->
                                    <div class="col-md-12">		
                                        				  
                                    </div>

                                    <div class="col-md-6">						
                                        <div class="mb-3">
                                        
                                            <label for="" class="control-label">ความคืบหน้า</label>
                                            <select class="form-select" aria-label="Default select example" name ="progress">
                                                <option value="<?php  echo $stmtdetailsrrow['progress_details']; ?>" ><?php  echo $stmtdetailsrrow['progress_details']; ?></option>
                                                <option value="10">10%</option>
                                                <option value="20">20%</option>
                                                <option value="30">30%</option>
                                                <option value="40">40%</option>
                                                <option value="50">50%</option>
                                                <option value="60">60%</option>
                                                <option value="70">70%</option>
                                                <option value="80">80%</option>
                                                <option value="90">90%</option>
                                            </select>
                                          
                                        </div>    
                                    </div>

                                    <div class="col-md-12" >						
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="" class="control-label">ไฟล์เเนบ</label>	
                                                <input id="input-b6b" name="files[]" type="file" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple>

<!--                                                 <input type="file" name="files[]" class="form-control streched-link" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple> -->
                                                <?php
                                                $sql = "SELECT * FROM  file_item_details  WHERE details_id =  $details_id";
                                                        $qry = $db->query($sql);
                                                        $qry->execute();
                                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {  ?>
                                                      <div><?php echo  $row['filename_details'] ?>
                                                      <a  onclick="delfileeditdetails('<?php echo $row['file_details_id'] ?>','<?php echo $project_id ?>','<?php echo $taskid?>','<?php echo $details_id ?>');"><i data-feather="trash-2"></i></a>  </div>
                                                  
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>  
                                     

                                    <div class="justify-content-center">
                                        <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                        <textarea class="form-control" name="text_comment" id="exampleFormControlTextarea1" rows="7" ><?php echo $stmtdetailsrrow['comment'] ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                    </div>
                                    <hr>
                                    <div class="col-lg-12 text-right justify-content-center d-flex">
                                        <button class="btn btn-primary " name ="editdetails" onclick="editdetailss('<?php echo $taskid ?>','<?php echo $project_id ?>','<?php echo $details_id ?>');">เเก้ไข</button>
                                        &nbsp; <a href="details_page.php?task_id=<?php echo $taskid ?>&project_id=<?php echo $project_id ?>" class="btn btn-secondary" type="button">กลับ</a>
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
     function editdetailss(taskid,project_id,details_id){
        $('#proc').val('editdetails');
        $('#task_id').val(taskid);
        $('#project_id').val(project_id);
        $('#details_id').val(details_id);
    }
    
    function delfileeditdetails(file_details_id,taskid,project_id,details_id){
        $('#proc').val('delfileeditdetails');
        $('#file_details_id').val(file_details_id);
        $('#task_id').val(taskid);
        $('#project_id').val(project_id);
        $('#details_id').val(details_id);
        $('#editdetails').submit()

        
    }
    function delfileeditdetails(file_details_id,taskid,project_id,details_id) {
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
                                data: 'proc=' + 'delfileeditdetails' + '&details_id=' + details_id + '&task_id=' + taskid + '&project_id=' + project_id + '&file_details_id=' + file_details_id ,
                    
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ลบงานเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'editdetails.php?details_id='+ details_id + '&task_id=' + taskid + '&project_id=' + project_id ;
            
                                    
                                    
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