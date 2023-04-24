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
    <form action="proc2.php" method="post" id="userlist" class="form-horizontal" enctype="multipart/form-data">

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
                                <div class="mb-3">             
                                    <label for="control-label" style="font-size: 14px;">ตำเเหน่ง</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <select name="role" id="role" class="form-select"  >
                                            <option value="">กรุณาเลือกตำเเหน่ง</option>
                                                    <?php
                                                    $stmt = $db->query("SELECT * FROM position ");
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
                            </div>                         
                            <div class="col-lg-12 text-right justify-content-center d-flex">
                            <a class="btn btn-primary" onclick="searchreportuser()" >ค้นหา</a> 
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
                                            <!--  <th>         
                                                สถานะเร่งของงาน
                                            </th> -->
                                             <th  class="mannager-col" >         
                                                จำนวนครั้งที่ถูกสั่งเเก้
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
function searchreportuser(){
    var proc = "searchreportuser"; 
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var role = $('#role').val();
    $.ajax({
        url:"proc2.php",
        method:"post",
        datatype: "json",
        data:{proc:proc,firstname:firstname,lastname:lastname,role:role},
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
                            <td class="id-col" >${i+1}</td>
                            <td >${response.result[i].firstname + ' ' + response.result[i].lastname}</td>
                            <td  >${response.result[i].position_name}</td>
                            <td class="numtask-col">${response.result[i].nummannagerpro}</td>
                            <td class="comptask-col">${response.result[i].numuserpro}</td>
                            <td class="success-col">${response.result[i].numusertask}</td>
                            <td class="mannager-col" > ${response.result[i].numdetails}</td>
                            <td class="action-col"  id='action' ><a class='btn btn-bitbucket btn-sm' href='reportuserpro.php?userid=${response.result[i].user_id}'>รายละเอียด</a></td>
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