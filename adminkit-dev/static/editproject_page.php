<?php 
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }

    $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    if (isset($_GET['update_id'])){
        try {
            $pro_id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * ,concat(firstname,' ',lastname) as name FROM project   natural JOIN project_list natural JOIN job_type natural JOIN user  WHERE project_id = :id");
            $select_stmt->bindParam(":id", $pro_id);
            $select_stmt->execute();
            $row2 = $select_stmt->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            $e->getMessage();
        }
    }   
      

?> 
<!DOCTYPE html>
<html lang="en">
        <?php include "head.php"?>
    <body>
        <?php include "sidebar.php"?>
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
        <form action="proc.php" method="post" id="form_data" class="form-horizontal" enctype="multipart/form-data" >

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
                                            <input type="date" class="form-control form-control" autocomplete="off" name="start_date" value="<?php echo $row2['start_date']; ?>"  >
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="" class="control-label">วันที่เสร็จ</label>
                                            <input type="date" class="form-control form-control" autocomplete="off" name="end_date" value="<?php echo $row2['end_date']; ?>"  >
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
											<label for="" class="control-label">สมาชิกทีมโครงการ</label>
												 <select  name="status2" class="form-control"  >
                                                 <option value="<?php  echo $row2['status_2']; ?>" ><?php echo  $stat2[$row2['status_2']]; ?></option>	
              	                                    <option value="1">งานปกติ</option>
                                                    <option value="2">งานด่วน</option>
                                                    <option value="3">งานด่วนมาก</option>
												</select>  
                                           <?php// print_r ($result); ?>
										</div>
                                        </div>




                                    <div class="mb-3">
											<div class="form-group">
                                            <label for="" class="control-label">ไฟล์เเนบ</label>	
												<input type="file" name="files[]" class="form-control streched-link" accept=".pdf, .jpg, .jpeg, .png, .docx, .pptx, .xlsx" multiple>
												<?php 
                                                    $sql = "SELECT * FROM  file_item_project  WHERE project_id = $pro_id";
                                                    $qry = $db->query($sql);
                                                    $qry->execute();
                                                    while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {  ?>
                                    <?php echo $row['filename']?> 
                                    <a  onclick="delfilepro('<?php echo $row['project_id'] ?>','<?php echo $row['file_item_project']?>');"><i data-feather="trash-2"></i></a>
                                  
                                </div>
                           
                              
                                <?php } ?>
											</div>
                                    </div>
                                   

                                    
                                    <div class="justify-content-center">
                                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name ="description" rows="7">
                                            <?php echo  $row2['description']; ?>  
                                            </textarea>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <hr>
										<div class="col-lg-12 text-right justify-content-center d-flex">
											<button class="btn btn-primary" id="display_selected"  onclick="editpro('<?php echo $pro_id ?>');" >EDIT</button>
											<a class="btn btn-secondary" href="project_list.php" type="button" >Cancel</a>
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
$(document).ready(function(){
    var data=[];
    var items = [];
    
      <?php
      $employees = $db->query("SELECT *, concat(firstname,' ',lastname) as name From user natural join position where  level >  $level ORDER by level asc");
      $employees->execute();
      $result = $employees->fetchAll();
      foreach($result as $row) {?>
        items.push({value:<?php echo $row['user_id'];?>,text:'<?php echo $row['name'];?><?php echo " ( ";?><?php echo $row['position_name'];?><?php echo " ) ";?>'});
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
            //alert(select.check_multi_select('fetch_country'))
            console.log($('#user_id').val());
        });
    });

    function editpro(pro_id){
        $('#proc').val('editpro');
        $('#project_id').val(pro_id);
    }
    function delfilepro(project_id,file_item_project){
        $('#proc').val('delfilepro');
        $('#file_item_project').val(file_item_project);
        $('#project_id').val(project_id);
        $('#form_data').submit();
        
    }
</script>
