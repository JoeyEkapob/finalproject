<?php 
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }


    if (isset($_GET['update_id'])){
            $pro_id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * ,concat(firstname,' ',lastname) as name ,
            DATE_FORMAT(start_date,'%Y-%m-%d') AS start_date_pro,
            DATE_FORMAT(end_date,'%Y-%m-%d') AS end_date_pro
            FROM project   natural JOIN project_list natural JOIN job_type natural JOIN user  WHERE project_id = :id");
            $select_stmt->bindParam(":id", $pro_id);
            $select_stmt->execute();
            $row2 = $select_stmt->fetch(PDO::FETCH_ASSOC);

    }   
      

?> 
<!DOCTYPE html>
<html lang="en">
        <?php include "head.php"?>
    <body>
        <?php include "sidebar.php"?>
        <?php include "funtion.php" ?>
        <style>
            .placeholder {
                display: inline-block;
                min-height: 1em;
                vertical-align: middle;
                cursor: auto;
                background-color: #FFFFFF !important;
                opacity: .10;
            }

        </style> 
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
        <form action="proc.php" method="post" id="formeditpro" class="form-horizontal" enctype="multipart/form-data" >

        <input type="hidden" id="proc" name="proc" value="">
        <input type="hidden" id="project_id" name="project_id" value="">
        <input type="hidden" id="file_item_project" name="file_item_project" value="">
        
                <main class="content"> 
                <div class="container-fluid p-0">
					<h1 class="h3 mb-3">เเก้ไขโปรเจค</h1>
				</div>
                    <div class="row">
						<div class="card">		
							<div class="card-body">
								<div class="row">
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">ชื่อโปรเจค</label>
											<input type="text" name="proname" class="form-control"  value="<?php echo $row2['name_project']; ?>">
                                        
										</div>
                                    </div>
                                 
                                    <div class="col-md-6">
                                    <div class="mb-3">
											<label for="" class="control-label" >ประเภทงาน</label>
												<select name="job" id="type" class="form-control"  >
                                                <option value="<?php  echo $row2['id_jobtype']; ?>" ><?php  echo $row2['name_jobtype']; ?></option>
													<?php
													$stmt = $db->query("SELECT * FROM job_type WHERE status = 1");
													$stmt->execute();
													$result = $stmt->fetchAll();
													foreach($result as $row) {
													?>
												 <option value="<?= $row['id_jobtype'];?>"><?= $row['name_jobtype'];?></option>
                									<?php } ?>
												</select>
										</div> 		
                                    </div>
                                    
                                
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่สั่ง</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="<?php echo $row2['start_date_pro']; ?>"  >
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่เสร็จ</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="end_date" value="<?php echo $row2['end_date_pro']; ?>"  >
										</div>
                                    </div>						
									
                                    <div class="col-md-6">
										<div class="mb-4">
											<label for="" class="control-label">สมาชิกทีมโครงการ</label>
                                            <input type="text" class="form-control" name="users_id" id="user_id"  data-access_multi_select="true"  placeholder="กรุณาใส่สมาชิก">
                                                
              	                                
										</div>
                                    </div>

                                    <div class="col-md-6">   
                                        <div class="mb-4">
											<label for="" class="control-label">ความเร่งของงาน</label>
												 <select  name="status2" class="form-select"  >
                                                 <option value="<?php  echo $row2['status_2']; ?>" ><?php  showstatpro2($row2['status_2']) ?></option>	
              	                                    <option value="1">งานปกติ</option>
                                                    <option value="2">งานด่วน</option>
                                                    <option value="3">งานด่วนมาก</option>
												</select>  
                                           <?php// print_r ($result); ?>
										</div>
                                    </div>
                                    <div class="col-md-6"> 
                                    </div>   
                                    <div class="col-md-6">   
                                        <div class="mb-4">
											<!-- <label for="" class="control-label">สถานะงาน</label> -->
                                             <?php if($row2['status_1'] == 1){ ?>
										<div class="form-check form-switch ">
											<input class="form-check-input" type="checkbox" role="switch" id="status1" name="status1" onclick="closeproject('<?php echo $pro_id ?>')" checked>
											<label class="form-check-label" for="flexSwitchCheckChecked">สถานะการหัวข้องาน</label>
										</div>
										<?php }else{ ?>
										<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" role="switch" id="status1" name="status1" onclick="openproject('<?php echo $pro_id ?>')" >
											<label class="form-check-label" for="flexSwitchCheckChecked">สถานะการหัวข้องาน</label>
										</div>
										<?php } ?>	 
                                             <!-- <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="status1" name="status1"  checked>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">สถานะงาน</label>
                                                    </div>	
                                                </div>	 --> 
												<!-- <select  name="status1" class="form-select"  >
                                                    <option value="<?php  echo $row2['status_1']; ?>" ><?php   showstatpro($row2['status_1']); ?></option>	
              	                                    <option value="1">รอดำเนินการ</option>
                                                    <option value="3" >ปิดโปรเจค</option>
												</select>   -->
                                           <?php// print_r ($result); ?>
										</div>
                                    </div>                 
                                    


                                    <div class="mb-3">
											<div class="form-group">
                                                <label for="" class="control-label">ไฟล์เเนบ</label>	
                                                <div class="file-loading"> 
                                                        <input id="input-b6b" name="files[]" type="file" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple>
                                                    </div>
                                                    <p class="small mb-0 mt-2"><b>รายละเอียด:</b>รองรับไฟล์งาน .pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx <b>ขนาดไฟล์ห้ามเกิน: 20 MB</b></p> 

                                                    <!-- <input type="file" name="files[]" class="form-control streched-link" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple> -->
                                                    
                                                    <?php 
                                                        $sql = "SELECT * FROM  file_item_project  WHERE project_id = $pro_id";
                                                        $qry = $db->query($sql);
                                                        $qry->execute();
                                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {  ?>
                                                      <div>  <?php echo $row['filename']?>    
                                                        <a  onclick="delfilepro('<?php echo $row['project_id'] ?>','<?php echo $row['file_item_project']?>');"><i data-feather="trash-2"></i></a>
                                                        </div>
                                        <?php } ?>
									</div>
                                </div>
                                   

                                    
                                    <div class="justify-content-center">
                                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name ="description" rows="7"><?php echo $row2['description'];?></textarea>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <hr>
										    <div class="col-lg-12 text-right justify-content-center d-flex">
                                                <button class="btn btn-primary" id="display_selected"  onclick="editpro('<?php echo $pro_id ?>');" >เเก้ไข</button>
                                                <a class="btn btn-secondary" href="project_list.php" type="button" >กลับ</a>
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
<script> 
$(document).ready(function() {
    $("#input-b6b").fileinput({
        showUpload: false,
        dropZoneEnabled: false,
        maxFileCount: 10,
        inputGroupClass: "input-group"
    });
});
$(document).ready(function(){
    var data=[];
    var items = [];
    
      <?php
      $sql = $db->query("SELECT level,u.department_id FROM user as u  NATURAL JOIN position as p  WHERE user_id =  $row2[manager_id]" );
      $sql->execute();
      $sql2 = $sql->fetch(PDO::FETCH_ASSOC);
      $department_id = $sql2['department_id'];
      $level2 = $sql2['level'];

       $where ="where  level >  $level2 ORDER by level asc  ";
      if($level2 > 2){
        $where = "where  level >  $level2  and d.department_id =  $department_id    ORDER by level asc";
      } 
      $employees = $db->query("SELECT *, concat(firstname,' ',lastname) as name From user as u natural join position as p  natural join department as d $where");
      $employees->execute();
      $result = $employees->fetchAll();
      foreach($result as $row) {?>
          items.push({ 
        value: <?php echo $row['user_id'];?>,
        text: '<?php echo $row['name'];?><?php echo " ( ";?><?php echo $row['position_name'].' '. $row['department_name']?><?php echo " ) ";?>',
        html: '<button class="btn btn-primary btn-sm viewuserdata" data-userid="<?php echo $row['user_id']; ?>">ดูรายระเอียด</button>'

    });
    <?php  } ?>
    <?php  
      $id = $_REQUEST['update_id'];
      $select_stmt1 = $db->prepare("SELECT * from project_list WHERE project_id = :id");
      $select_stmt1->bindParam(":id", $id);
      $select_stmt1->execute();
      $row21 = $select_stmt1->fetchAll();
      foreach( $row21 as $rowa) {?>
           data.push(<?php echo $rowa['user_id'];?>);
      <?php  } ?>
        var select = $('[data-access_multi_select="true"]').check_multi_select({
            multi_select: true,
            items: items,
            defaults: data,
            rtl: false
        });
        $('#display_selected').click(function () {
            $('#user_id').val(select.check_multi_select('fetch_country'));
          /*   alert(select.check_multi_select('fetch_country'))
            console.log($('#user_id').val()); */
        });
    });

    $(document).ready(function(){
  $('.viewuserdata').click(function(){
    var proc = 'viewdatauser';
    var userid=$(this).data("userid");
 /*    var usersendid=$(this).data("send");
    var sendstatus=$(this).data("status"); */
    console.log(userid);
    $.ajax({
        url:"proc.php",
        method:"post",
        data:{proc:proc,userid:userid},
        success:function(data){
           // console.log(data);

            $('#datauser').html(data);
            $('#datausermodal').modal('show'); 
        }
    })
  });
});

    function editpro(pro_id){
        $('#proc').val('editpro');
        $('#project_id').val(pro_id);
    }
  /*   function delfilepro(project_id,file_item_project){
        $('#proc').val('delfilepro');
        $('#file_item_project').val(file_item_project);
        $('#project_id').val(project_id);
        $('#formeditpro').submit();
        
    } */
    function delfilepro(project_id,file_item_project) {
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
                                data: 'proc=' + 'delfilepro' + '&project_id=' + project_id + '&file_item_project=' + file_item_project ,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'ลบงานเรียบร้อยเเล้ว!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'editproject_page.php?update_id='+ project_id;
                                    
                                    
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
        function closeproject(project_id) {
                Swal.fire({
                title: 'คุณต้องการปิดหัวข้องานใช่หรือไม่',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ต้องการปิด!',
                cancelButtonText: 'กลับ',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                            url: 'proc2.php',
                            type: 'post',
                            data: 'proc=' + 'closeproject' + '&project_id=' + project_id ,
                        })
                        .done(function() {
                            Swal.fire({
                                title: 'success',
                                text: 'ปิดหัวข้องานเเล้ว!',
                                icon: 'success',
                            }).then(() => {
                                document.location.href = 'editproject_page.php?update_id='+ project_id;
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
    function openproject(project_id) {
            Swal.fire({
            title: 'คุณต้องการเปิดหัวข้องานใช่หรือไม่',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่ต้องการปิด!',
            cancelButtonText: 'กลับ',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: 'proc2.php',
                        type: 'post',
                        data: 'proc=' + 'openproject' + '&project_id=' + project_id ,
                    })
                    .done(function(response) {
                        console.log(response);
                        if (response != 1) {
                            Swal.fire({
                                title: 'เปิดหัวข้องานเรียบร้อยเเล้ว!',
                                text: '',
                                icon: 'success',
                            }).then(() => {
                                 document.location.href = 'view_project.php?view_id='+ project_id; 
                            })
                        } else {
                            Swal.fire({
                                title: 'เวลาของหัวข้อนี้ได้หมดลงเเล้วไม่สามารถเปิดหัวข้องานได้!',
                                text: '',
                                icon: 'error',
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
