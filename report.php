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
<form action="" method="post" id="userlist" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" id="proc" name="proc" value="">
            <main class="content">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">รายงาน</h5>
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
                                                    <option value="2">กำลังดำเนินการ</option>
                                                    <option value="3">เลยระยะเวลาที่กำหนด</option>
                                                    <option value="4">ปิดโปรเจค</option>
                                                </select>  
                                            </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">             
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
                            <div class="col-lg-12 text-right justify-content-center d-flex">
                                <a class="btn btn-primary" onclick="searchreport()" >ค้นหา</a> 
                                <a class="btn btn-secondary" href="" type="button" >ล้างค่า</a>
                               
            
                            </div>
                            <div class="mb-3">
                            </div>   
                            <hr>
                            <div class="d-flex flex-row-reverse">
            	                    <button class="btn btn-flat  btn-danger" id="print" onclick="printContent('Receipt');"><i class="fa fa-print"></i> Print</button>
                             </div>
                            <div class="mb-3" id="Receipt">
                                <table class='table m-0 table-bordered' >
                                    <thead>
                                        <tr>
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
                                                จำนวนงาน
                                            </th>
                                            <th  class="comptask-col">
                                                งานที่เสร็จ
                                            </th>
                                            <th  class="success-col">         
                                                ความสำเร็จ
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
                            </div>
                        </div>
                    </div>
                </div>
                            
            </main>
        
</form>
</body>

</html>
<script>

    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#Receipt').clone();
        printcontent.find('#action').remove();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }

  function searchreport(){
    var proc = "searchreport"; 
    var nameproject = $('#nameproject').val();
    var job = $('#job').val();
    var startdate = $('#startdate').val();
    var enddate = $('#enddate').val();
    var status1 = $('#status1').val();
    var status2 = $('#status2').val();
    $.ajax({
        url:"proc2.php",
        method:"post",
        datatype: "json",
        data:{proc:proc,nameproject:nameproject,job:job,startdate:startdate,enddate:enddate,status1:status1,status2:status2},
        success:function(response){
            var response = JSON.parse(response);
            console.log(response)
            var html = '';
            if(response.result.length == 0){
                    html += `
                        <tr>
                            <td colspan='9' style='text-align:center'>ไม่พอข้อมูล</td>
                        </tr>
                    `;
                    $("#test").html(html)
                    } else {
                        for(var i=0; i<response.result.length; i++) {
                        html += `
                        
                        <tr>
                            <td class="id-col" >${response.result[i].project_id}</td>
                            <td >${response.result[i].name_project}</td>
                            <td >${response.result[i].name_jobtype}</td>
                            <td class="numtask-col">${response.result[i].numtask}</td>
                            <td class="comptask-col">${response.result[i].comptask}</td>
                            <td class="success-col">${response.result[i]['progress_project'] + '%'}</td>
                            <td class="mannager-col" > ${response.result[i].firstname + ' ' + response.result[i].lastname}</td>
                            <td class="action-col"  id='action' ><a class='btn btn-bitbucket btn-sm' href='reportpro.php?projectid=${response.result[i].project_id}'>รายละเอียด</a></td>
                        </tr>
                        `;
                        }
                    }
                    $("#test").html(html)
        }
    })
} 

</script>

<?php include "footer.php"?>