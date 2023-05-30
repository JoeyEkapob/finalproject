<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
     /* $page= $_GET['page']; */
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css"  
<?php include "sidebar.php"?>
<?php /* include "funtion.php" */ ?>

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
<form action="reportpropdf.php" method="post" id="userlist" class="form-horizontal" enctype="multipart/form-data"  target="_blank">
                <input type="hidden" id="proc" name="proc" value="">
            <main class="content">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">รายงานหัวข้องาน</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label for="control-label" style="font-size: 14px;">ชื่อหัวข้องาน</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" class="form-control" name="nameproject"  id="nameproject" placeholder="ชิ่อหัวข้องาน">
                                            </div>
                                    </div>  
                                </div>      

                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label for="control-label" style="font-size: 14px;">ประเภทงาน</label>
                                            <div class="input-group input-group-sm mb-2">
                                           
                                                <select name="job" id="job" class="form-select">
                                                    <option value="">กรุณาเลือกประเภทงาน</option>
                                                        <?php
                                                        $stmt = $db->query("SELECT * FROM job_type WHERE status = 1 ");
                                                        $stmt->execute();
                                                        $result = $stmt->fetchAll();
                                                        foreach($result as $row) {
                                                        ?>
                                                    <option value="<?= $row['id_jobtype'];?>"><?= $row['name_jobtype'];?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                    </div>  
                                </div>
                            <div class="col-md-3">
                            </div>     
                            <div class="col-md-3">
                            </div>                                
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label for="control-label" style="font-size: 14px;">วันที่เริ่ม</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="date" class="form-control" name="startdate" id="startdate">
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-2">            
                                        <label for="control-label" style="font-size: 14px;">วันที่สิ้นสุด</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="date" class="form-control" name="enddate" id="enddate">
                                            </div>
                                    </div>
                                </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">
                            </div>          
                                <div class="col-md-3">
                                    <div class="mb-2"> 
                                        <label for="control-label" style="font-size: 14px;">สถานะงาน</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <select  name="status1"  id="status1" class="form-select" >
                                                    <option value="">กรุณาเลือกสถานะงาน</option>
                                                    <option value="1">รอดำเนินการ</option>
                                                    <option value="3">ปิดโปรเจค</option>
                                                </select>  
                                            </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-2">             
                                        <label for="control-label" style="font-size: 14px;">การเร่งของงาน</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <select  name="status2"  id="status2" class="form-select"  > 
                                                    <option value="">กรุณาเลือกความเร่งด่วน</option>
                                                    <option value="1">งานปกติ</option>
                                                    <option value="2">งานด่วน</option>
                                                    <option value="3">งานด่วนมาก</option>
                                                </select>  
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div> 
                                <div class="col-md-3">
                                </div> 
                                <?php if($level <= $maxlevel): ?>  
                                    <div class="col-md-3">
                                            <div class="mb-3">             
                                                <label for="control-label" style="font-size: 14px;">ตำเเหน่ง</label>
                                                    <div class="input-group input-group-sm mb-2">
                                                        <select name="role" id="role" class="form-select"  >
                                                        <option value="">ทั้งหมด</option>
                                                                <?php
                                                                $stmt = $db->query("SELECT * FROM position as p  WHERE position_status = 1 AND level > $level OR role_id = $role ");
                                                                $stmt->execute();
                                                                $result = $stmt->fetchAll();
                                                                foreach($result as $row) {
                                                                ?>
                                                        <option value="<?= $row['role_id'];?>"><?= $row['position_name'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3"> 
                                                    
                                                    <div class="mb-3">
                                                        <label for="" class="control-label" >ฝ่าย</label>
                                                        <div class="input-group input-group-sm mb-2">
                                                            <select name="department" id="department" class="form-select" >
                                                            <option value="">ทั้งหมด</option>

                                                                <?php
                                                                if($level > 2){
                                                                    $where = " AND department_id = $department_id  ";
                                                                }
                                                                $stmt = $db->query("SELECT * FROM department WHERE department_status = 1 AND department_id != 0  $where   ");
                                                                $stmt->execute();
                                                                $result = $stmt->fetchAll();
                                                                foreach($result as $row) {
                                                                ?>
                                                            <option value="<?= $row['department_id'];?>"><?= $row['department_name'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                            </div>
                                                    </div>
                                        
                                        </div>  
                                        <?php endif; ?>
                            <?php if($level <= $maxlevel): ?>  
                            <div class="col-md-3">
                            </div>    
                     
                            <div class="col-md-3">
                            </div>    
                            <?php endif; ?>              
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="control-label" >ประเภท</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <select name="jobtype" id="jobtype" class="form-select" >
                                                <option value="1">หัวข้องานที่มอบหมาย</option>
                                                <option value="2">หัวข้องานที่ต้องทำ</option>
                                            </select>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div> 
                            <div class="col-lg-12 text-right justify-content-center d-flex">
                                <a class="btn btn-primary" onclick="searchreport('<?php echo 1 ?>')" >ค้นหา</a> &nbsp;
                                <a class="btn btn-secondary" href="report.php" type="button" >ล้างค่า</a>
                               
            
                            </div>
                            <div class="mb-3">
                            </div>   
                            <hr>
                            <div class="d-flex flex-row-reverse">
            	                   <!--  <button class="btn btn-flat  btn-danger" id="print" onclick="printContent('Receipt');"><i class="fa fa-print"></i> Print</button> -->
                                   <button class="btn btn-flat  btn-danger" onclick="report()"  ><i class="fa fa-print"></i>PDF</button>
                             </div>
                            <div class="mb-3" id="Receipt">
                                <table class='table m-0 table-bordered' >
                                    <thead>
                                        <tr>
                                            <th class="id-col">
                                                ลำดับ
                                            </th>
                                            <th class="id-col">
                                                รหัสหัวข้องาน
                                            </th>
                                            <th  class="namepro-col" >
                                                ชื่อหัวข้องาน
                                            </th>
                                            <th  class="jobtype-col" >
                                                ประเภทงาน
                                            </th>
                                            <th  class="numtask-col">
                                                วันที่เริ่ม -  วันที่สิ้นสุด
                                            </th>
                                            <!-- <th  class="comptask-col">
                                                วันที่สิ้นสุด
                                            </th> -->
                                            <th  class="success-col">         
                                                สถานะ
                                            </th>
                                            <!--  <th>         
                                                สถานะเร่งของงาน
                                            </th> -->
                                             <th  class="mannager-col" >         
                                                คนที่มอบหมาย
                                            </th> 
                                            <th  class="action-col" id='action'>         
                                                Action
                                            </th> 
                                        </tr>
                                    </thead>
                                  
                                    <tbody id="test">
                                      
                                </table>
                            <div>
                              
                            </div>
                        </div>
                    </div>
                </div>
                            
            </main>
        
</form>
</body>

</html>
<script>

   function report() {
     $('#proc').val('report');
     console.log(proc);
    } 
   
  function searchreport(page){
    var proc = "searchreport"; 
    var nameproject = $('#nameproject').val();
    var job = $('#job').val();
    var startdate = $('#startdate').val();
    var enddate = $('#enddate').val();
    var status1 = $('#status1').val();
    var status2 = $('#status2').val();
    var department = $('#department').val();
    var role = $('#role').val();
    var jobtype = $('#jobtype').val();
    var page = page;
    
  /*   console.log(page) */
    $.ajax({
        url:"proc2.php",
        method:"post",
        datatype: "json",
        data:{proc:proc,nameproject:nameproject,job:job,startdate:startdate,enddate:enddate,status1:status1,status2:status2,department:department,role:role,jobtype:jobtype},
        success:function(response){
            console.log(response)
            var response = JSON.parse(response);
            var html = '';
            var rowsPerPage = 10; // กำหนดจำนวนแถวต่อหน้า
            var totalRows = response.result.length;
            var totalPages = Math.ceil(totalRows / rowsPerPage); // คำนวณหาจำนวนหน้าทั้งหมด
            var  num = 1;
          /*   console.log(response) */
            if(response.result.length == 0){
                    html += `
                        <tr>
                            <td colspan='9' style='text-align:center'>ไม่พบข้อมูล</td>
                        </tr>
                    `;
                    $("#test").html(html)
                    } else {
                        for (var i = (page - 1) * 10; i < response.result.length && i < page * 10; i++) {
                        html += `
                            <tr>
                            <td class="id-col">${num++}</td>
                            <td class="id-col">${response.result[i].project_id}</td>
                            <td>${response.result[i].name_project}</td>
                            <td>${response.result[i].name_jobtype}</td>
                            <td class="numtask-col">${thai_date_short(response.result[i].start_date)} - ${thai_date_short(response.result[i]['end_date'])}</td>
                            <td class="comptask-col">${showstatprotext1(response.result[i].status_1)} (${showstatprotext2(response.result[i].status_2)})</td>
                            <td class="mannager-col">${showshortname(response.result[i].shortname_id) + ' ' + response.result[i].firstname + ' ' + response.result[i].lastname}</td>
                            <td class="action-col" id='action'><a class='btn btn-bitbucket btn-sm' title="ดูรายละเอียด" href='reportpro.php?projectid=${response.result[i].project_id}'><i class="bi bi-search"></i></a></td>
                            </tr>
                        `;
                        }
                        if (totalPages > 1) {
                            html += `
                                <tr>
                                    <td colspan="8" style="text-align:center;">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination">`;
                            if (page > 1) {
                                html += `
                                        <li class="page-item">
                                            <a class="page-link" href="#" onclick="searchreport(${page - 1})">&laquo;</a>
                                        </li>
                                        `;
                            }
                            for (var i = 1; i <= totalPages; i++) {
                            if (i == page) {
                            html += `
                                <li class="page-item active">
                                    <a class="page-link" href="#" onclick="searchreport(${i})">${i}</a>
                                </li>
                            `;
                            } else {
                            html += `
                                <li class="page-item">
                                    <a class="page-link" href="#" onclick="searchreport(${i})">${i}</a>
                                </li>
                            `;
                            }
                        }
                        if (page < totalPages) {
                            html += `
                                    <li class="page-item">
                                        <a class="page-link" href="#" onclick="searchreport(${page + 1})">&raquo;</a>
                                    </li>`;
                        }
                        html += `
                                </ul>
                                </nav>
                            </td>
                            </tr>
                        `;
                    }

                    $("#test").html(html)
                    }
                
        }
    })
} 

</script>

<?php include "footer.php"?>