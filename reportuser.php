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
    <form action="reportpropdf.php" method="post" id="userlist" class="form-horizontal" enctype="multipart/form-data"  target="_blank">
    <input type="hidden" id="proc" name="proc" value="">
        <main class="content">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">รายงานสมาชิก</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3">
                        </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="control-label" style="font-size: 14px;">ชื่อ</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="firstname" id ="firstname" class="form-control" placeholder="ชิ่อ">
                                        </div>
                                </div>  
                            </div>      

                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="control-label" style="font-size: 14px;">นามสกุล</label>
                                        <div class="input-group input-group-sm mb-2">
                                        <input type="text" name="lastname" id ="lastname" class="form-control" placeholder="นามสกุล">
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
                            <div class="col-lg-12 text-right justify-content-center d-flex">
                            <a class="btn btn-primary" onclick="searchreportuser('<?php echo 1 ?>')" >ค้นหา</a> 
                            &nbsp;  <a class="btn btn-secondary" href="" type="button" >ล้างค่า</a>
                            </div>
                            <div class="mb-3">
                            </div>   
                            <hr>
                            <div class="d-flex flex-row-reverse">
            	                  <!--   <button class="btn btn-flat  btn-danger" id="print" onclick="printContent('Receipt');"><i class="fa fa-print"></i> Print</button> -->
                                  <button class="btn btn-flat  btn-danger" id="print" onclick="report()"  ><i class="fa fa-print"></i> Print</button>
                             </div>
                            <div class="mb-3" id="Receipt">
                                <table class='table m-0 table-bordered' >
                                    <thead>
                                        <tr>
                                            <th class="id-col">
                                                ลำดับ
                                            </th>
                                            <th  class="namepro-col" >
                                                ชื่อ-นามสกุล
                                            </th>
                                            <th  class="jobtype-col" >
                                                ตำเเหน่ง
                                            </th>
                                            <th  class="numtask-col">
                                                หัวข้องานที่สร้าง 
                                            </th>
                                            <th  class="comptask-col">
                                                หัวข้องานที่ถูกสั่ง 
                                            </th>
                                            <th  class="success-col">         
                                                จำนวนงาน
                                            </th>
                                             <th class="success-col">         
                                               งานที่ล่าช้า
                                            </th> 
                                             <th  class="mannager-col" >         
                                                ครั้งที่ถูกสั่งเเก้
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
        /* function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#Receipt').clone();
        printcontent.find('#action').remove();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    } */

    function report() {
     $('#proc').val('reportuser');
     console.log(proc);
    } 

function searchreportuser(page){
    var proc = "searchreportuser"; 
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var startdate = $('#startdate').val();
    var enddate = $('#enddate').val();
    var role = $('#role').val();
    var department = $('#department').val();
    var page = page;
    $.ajax({
        url:"proc2.php",
        method:"post",
        datatype: "json",
        data:{proc:proc,firstname:firstname,lastname:lastname,startdate:startdate,enddate:enddate,role:role,department:department},
        success:function(response){
          /*   console.log(response) */
         var response = JSON.parse(response); 
            console.log(page)
            var html = '';
            var rowsPerPage = 10; // กำหนดจำนวนแถวต่อหน้า
            var totalRows = response.result.length;
            var totalPages = Math.ceil(totalRows / rowsPerPage); // คำนวณหาจำนวนหน้าทั้งหมด
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
                            <td class="id-col" >${i+1}</td>
                            <td >${showshortname(response.result[i].shortname_id) + ' ' + response.result[i].firstname + ' ' + response.result[i].lastname}</td>
                            <td  >${response.result[i].position_name}</td>
                            <td class="numtask-col">${response.result[i].nummannagerpro}</td>
                            <td class="comptask-col">${response.result[i].numuserpro}</td>
                            <td class="mannager-col" > ${response.result[i].numusertask}</td>
                            <td class="success-col">${response.result[i].numdela}</td>
                            <td class="mannager-col" > ${response.result[i].numdetails}</td>
                            <td class="action-col"  id='action' ><a class='btn btn-bitbucket btn-sm' title="งานที่มอบหมาย" href='reportuserpro.php?userid=${response.result[i].user_id}&startdate=${startdate}&enddate=${enddate}'><i class="bi bi-search"></i></a>
                            <a class='btn btn-danger btn-sm'  title="งานที่ได้รับมอบหมาย"  href='reportuserprocreate.php?userid=${response.result[i].user_id}&startdate=${startdate}&enddate=${enddate}'><i class="bi bi-search"></i></a>
                            </td>
                        </tr>
                        `;
                        }
                        if (totalPages > 1) {
                            html += `
                                <tr>
                                    <td colspan="9" style="text-align:center;">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination">`;
                            if (page > 1) {
                                html += `
                                        <li class="page-item">
                                            <a class="page-link" href="#" onclick="searchreportuser(${page - 1})">&laquo;</a>
                                        </li>
                                        `;
                            }
                            for (var i = 1; i <= totalPages; i++) {
                            if (i == page) {
                            html += `
                                <li class="page-item active">
                                    <a class="page-link" href="#" onclick="searchreportuser(${i})">${i}</a>
                                </li>
                            `;
                            } else {
                            html += `
                                <li class="page-item">
                                    <a class="page-link" href="#" onclick="searchreportuser(${i})">${i}</a>
                                </li>
                            `;
                            }
                        }
                        if (page < totalPages) {
                            html += `
                                    <li class="page-item">
                                        <a class="page-link" href="#" onclick="searchreportuser(${page + 1})">&raquo;</a>
                                    </li>`;
                        }
                        html += `
                                </ul>
                                </nav>
                            </td>
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