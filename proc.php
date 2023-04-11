
<?php
    session_start();
    include 'footer.php';
    require_once 'connect.php';
    include "funtion.php";
    date_default_timezone_set('asia/bangkok');
    $date = date('Y-m-d');
    $url_return = "";
    $user_id=$_SESSION['user_login'];

    if($_POST['proc'] == 'viewdetails'){
        $details_id = $_POST['detail_id'];
        $usersendid = $_POST['usersendid'];
        $sendstatus = $_POST['sendstatus'];
        $outp ="";
        $sql = "SELECT * FROM details NATURAL join user  NATURAL join task_list  NATURAL join project  where details_id = $details_id";
        $qry = $db->query($sql);
        $qry->execute();
        if($sendstatus == 1){
        while($row = $qry->fetch(PDO::FETCH_ASSOC)){ 
    
        $outp.=' 
        <div class="col-12  d-flex">
            <div class="card flex-fill">  
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">

                            <dl>                                   
                                <dt><b class="border-bottom border-primary">ชื่อโปรเจค</b></dt>
                                <dd>'.$row['name_project'].'</dd>

                                <dt><b class="border-bottom border-primary">ชื่องาน</b></dt>
                                <dd>'.$row['name_tasklist'] .'</dd>

                                <dt><b class="border-bottom border-primary">วันเเละเวลาที่ส่งงาน</b></dt>
                                <dd>'.thai_date_and_time($row['date_detalis']).'</dd>

                                <dt><b class="border-bottom border-primary">รายละเอียด</b></dt>
                                <dd>'.$row['comment'].'</dd>
                            </dl>';

        }
       
        $profileusersendsql = "SELECT * FROM details NATURAL JOIN user WHERE user_id = $usersendid";
        $profileusersendqry = $db->query($profileusersendsql);
        $profileusersendqry->execute(); 
        $profileusersendrow = $profileusersendqry->fetch(PDO::FETCH_ASSOC);

        $outp.=' <dt><b class="border-bottom border-primary">คนที่ส่งงาน</b></dt>
                    <dd> 
                        <div class="d-flex align-items-center mt-1">
                            <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/'. $profileusersendrow['avatar'].'" alt="Avatar" width="35"  height="35">
                            <b>'. $profileusersendrow['firstname']  .' '.$profileusersendrow['lastname'].'</b>
                        </div>
                    </dd>
                    <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>'; /* */
 
        $filedetailsql = "SELECT * FROM details  NATURAL JOIN file_item_details WHERE details_id = $details_id";
        $filedetailqry = $db->query($filedetailsql);
        $filedetailqry->execute();
        while ($filedetailqryrow = $filedetailqry->fetch(PDO::FETCH_ASSOC)) { 

        $outp.=' <div class="row">
                    <div class="col-sm">
                        <a href="img/file/file_details/' . $filedetailqryrow['newname_filedetails'] . '" download="' . $filedetailqryrow['filename_details'] . '">' . $filedetailqryrow['filename_details'] . '</a> 
                    </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
                '; 

            
              }  
        }else if($sendstatus == 2){
            while($row = $qry->fetch(PDO::FETCH_ASSOC)){ 
    
                $outp.='
                    <div class="col-12  d-flex">
                        <div class="card flex-fill">  
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12">
                
                                        <dl>                                   
                                            <dt><b class="border-bottom border-primary">ชื่อโปรเจค</b></dt>
                                            <dd>'.$row['name_project'].'</dd>
                        
                                            <dt><b class="border-bottom border-primary">ชื่องาน</b></dt>
                                            <dd>'.$row['name_tasklist'] .'</dd>
                        
                                            <dt><b class="border-bottom border-primary">วันเเละเวลาที่งานส่งกลับเเก้</b></dt>
                                            <dd>'.thai_date_and_time($row['date_detalis']).'</dd>
                        
                                            <dt><b class="border-bottom border-primary">รายละเอียด</b></dt>
                                            <dd>'.$row['comment'].'</dd>
                                        </dl>';
                }
               
                $profileusersendsql = "SELECT * FROM details NATURAL JOIN user WHERE user_id = $usersendid";
                $profileusersendqry = $db->query($profileusersendsql);
                $profileusersendqry->execute(); 
                $profileusersendrow = $profileusersendqry->fetch(PDO::FETCH_ASSOC);
        
                $outp.=' <dt><b class="border-bottom border-primary">คนที่ตรวจงาน</b></dt>
                            <dd> 
                                <div class="d-flex align-items-center mt-1">
                                    <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/'. $profileusersendrow['avatar'].'" alt="Avatar" width="35"  height="35">
                                    <b>'. $profileusersendrow['firstname']  .' '.$profileusersendrow['lastname'].'</b>
                                </div>
                            </dd>
                            <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>'; /* */
         
                $filedetailsql = "SELECT * FROM details  NATURAL JOIN file_item_details WHERE details_id = $details_id";
                $filedetailqry = $db->query($filedetailsql);
                $filedetailqry->execute();
                while ($filedetailqryrow = $filedetailqry->fetch(PDO::FETCH_ASSOC)) { 
        
                $outp.=' <div class="row">
                            <div class="col-sm">
                                <a href="img/file/file_details/' . $filedetailqryrow['newname_filedetails'] . '" download="' . $filedetailqryrow['filename_details'] . '">' . $filedetailqryrow['filename_details'] . '</a> 
                            </div>
                        </div> 
                    </div>
                </div>
            </div> 
        </div>
        </div>';  
                    
                      }  
        }
        
         echo  $outp;
         exit;
    }
    else if($_POST['proc'] == 'editdetails'){
   
       /*  $details_id = $_POST['detail_id'];
        $sql = "SELECT * FROM details natural join file_item_details  where details_id = $details_id";
        $qry = $db->query($sql);
        $qry->execute();
        while($row = $qry->fetch(PDO::FETCH_ASSOC)){;
        echo json_encode($row);
        } */
        $code ="ED";
        $details_id = $_POST['details_id'];
        $task_id = $_POST['task_id'];
        $project_id = $_POST['project_id'];
        $progressdetails = $_POST['progress'];
        $text_comment = $_POST['text_comment'];
        $files = $_FILES['files'];
        $progress =$_POST['progress'];

        foreach ($files['name'] as $i => $file_name) {
            $numrand = (mt_rand());
            $type = strrchr($file_name,".");
            $newname = $date.$code.$numrand.$type;
            $file_tmp = $files['tmp_name'][$i];
            $file_dest = $file_name; 
            $file_data = "img/file/file_details/";
            move_uploaded_file($file_tmp,$file_data.$newname);
            if (!empty(array_filter($_FILES['files']['name']))) {
                $inserfile_item_task = $db->prepare("INSERT INTO file_item_details(task_id,filename_details,project_id,details_id,newname_filedetails) 
                VALUES(:task_id,:filename_details,:project_id,:details_id,:newname_filedetails)");
                $inserfile_item_task->bindParam(":task_id",$task_id);
                $inserfile_item_task->bindParam(":project_id",$project_id);
                $inserfile_item_task->bindParam(":filename_details",$file_name);
                $inserfile_item_task->bindParam(":details_id",$details_id);
                $inserfile_item_task->bindParam(":newname_filedetails",$newname);
                $inserfile_item_task->execute(); 
            }
        }
        $updateeditdetails = $db->prepare("UPDATE details SET comment = :comment ,progress_details =:progress_details WHERE details_id = :details_id");
        $updateeditdetails->bindParam(":comment",$text_comment);
        $updateeditdetails->bindParam(":progress_details",$progressdetails);
        $updateeditdetails->bindParam(":details_id",$details_id);
        $updateeditdetails->execute(); 

        $updetatask = $db->prepare("UPDATE task_list SET progress_task =:progress_task WHERE  task_id = :task_id");
        $updetatask->bindParam(":progress_task",$progress);
        $updetatask->bindParam(":task_id",$task_id);
        $updetatask->execute(); 

        $_SESSION['success'] = "เเก้ไขรายละเอียดงานเเก้เรียบร้อยเเล้ว!";
        $url_return = "location:details_page.php?task_id=".$task_id."&project_id=".$project_id."";

    }
    else if($_POST['proc'] == 'delfileeditdetails'){

        $file_path = 'img/file/file_details/';

        $file_details_id = $_POST['file_details_id'];
        $task_id = $_POST['task_id'];
        $project_id = $_POST['project_id'];
        $details_id = $_POST['details_id'];

        $sql = "SELECT * from file_item_details  where file_details_id = $file_details_id ";
        $qry = $db->query($sql);
        $qry->execute();

        while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)){  
            unlink($file_path.$row2['newname_filedetails']); 
        }

        $stmt = $db->prepare("DELETE FROM file_item_details WHERE file_details_id = :file_details_id");
        $stmt->bindParam(":file_details_id", $file_details_id);
        $stmt->execute();

        $_SESSION['success'] = "ลบไฟล์เรียบร้อยแล้ว!";
        $url_return = "location:editdetails.php?details_id=".$details_id."&task_id=".$task_id."&project_id=".$project_id."";
    
    



    }
    else if($_POST['proc'] == 'add_task'){

        $pro_id= $_POST['pro_id'];
        $sql = "SELECT * FROM project  where project_id = $pro_id";
        $qry = $db->query($sql);
        $qry->execute();
        $row2 = $qry->fetch(PDO::FETCH_ASSOC);
        
        $datestartproject = $row2['start_date'];
        $dateendproject = $row2['end_date'];
        $manager_id = $row2['manager_id'];

        $yearMonth = substr(date("Y")+543, -2);
        $sql = "SELECT MAX(task_id) AS last_id FROM task_list ";
        $qry = $db->query($sql);
        $qry->execute();
        $row = $qry->fetch(PDO::FETCH_ASSOC);

        $code = "T";
        $maxId = $row['last_id'];

        if($maxId ==''){
            $maxId = 1;
        }else{
            $maxId = ($maxId + 1);
        }
        $nextId = substr($yearMonth."00".$maxId,-5);
 
        $stat = 1 ;
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $taskname =$_POST['taskname'];
        $user=$_POST['user'];
        $textarea=$_POST['textarea'];
        
        $files = $_FILES['files'];
        $progress_task = 0;

           /*   echo strtotime($datestartproject).'__________'.strtotime($dateendproject).'__________'.strtotime($start_date).'__________'.strtotime($end_date);
           exit; */
        if(empty($taskname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่องาน';
            $url_return = "location:view_project.php?view_id=".$pro_id;
        }else if(empty($end_date)){
            $_SESSION['error'] = 'กรุณากรอกวันสิ้นสุดงาน';
            $url_return = "location:view_project.php?view_id=".$pro_id;
        }else if(strtotime($start_date) > strtotime($end_date) || strtotime($start_date) > strtotime($dateendproject)){
            $_SESSION['error'] = 'วันที่เริ่มงานของงานไม่ถูกต้อง!!';
            $url_return = "location:view_project.php?view_id=".$pro_id;
            //strtotime($datestartproject) > strtotime($start_date) ||
           
        }else if( strtotime($end_date) < strtotime($start_date) || strtotime($end_date) >  strtotime($dateendproject) ){
            $_SESSION['error'] = 'วันที่สิ้นสุดงานของคุณไม่อยู่ระหว่างระยะเวลาของหัวข้องานโปรดกรอกใหม่อีกครั้ง!!';
            $url_return = "location:view_project.php?view_id=".$pro_id;
          
        } else {
            $stmtuser = "SELECT CONCAT(firstName, ' ', lastName) As FullName  FROM user where user_id = ".$manager_id."";
            $stmtuser = $db->prepare($stmtuser);
            $stmtuser ->execute();
            $stmtuserrow = $stmtuser->fetch(PDO::FETCH_ASSOC);

            $datauser = $db->prepare("SELECT line_token FROM user WHERE user_id = :userid");
            $datauser->bindParam(":userid",$user);
            $datauser ->execute();
            $datauserrow = $datauser->fetch(PDO::FETCH_ASSOC); 
            
            $sToken = $datauserrow['line_token'];
            $sMessage = "มีการเพิ่มงาน \n";
            $sMessage .= "ชื่อห้วงาน : ".$row2['name_project']." \n";
            $sMessage .= "ชื่องาน : ".$taskname." \n";
            $sMessage .= "วันที่สั่ง : ".thai_date_and_time_short($start_date)." \n";
            $sMessage .= "วันที่สิ้นสุด : ".thai_date_and_time_short($end_date)." \n";
            $sMessage .= "คนที่สั่งงาน : ".$stmtuserrow['FullName']." \n";
           // showstatprotext2($status2);
            //echo  $sMessage;
    
            $chOne = curl_init(); 
            curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
            curl_setopt( $chOne, CURLOPT_POST, 1); 
            curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
            $result = curl_exec( $chOne );   

        }
        
        
        if(!isset($_SESSION['error'])) {
            $stmttask = $db->prepare("INSERT INTO task_list(task_id,name_tasklist, description_task,status_task, strat_date_task,end_date_task,project_id,user_id,progress_task) 
            VALUES(:task_id,:taskname,:textarea,:status,:start_date,:end_date,:pro_id,:users_id,:progress_task)");
            $stmttask->bindParam(":task_id", $nextId);
            $stmttask->bindParam(":taskname", $taskname);
            $stmttask->bindParam(":textarea", $textarea);
            $stmttask->bindParam(":status", $stat);
            $stmttask->bindParam(":start_date", $start_date);
            $stmttask->bindParam(":end_date", $end_date);
            // $stmttask->bindParam(":file_task",$file_task);
            $stmttask->bindParam(":pro_id", $pro_id);
            $stmttask->bindParam(":users_id",$user );
            $stmttask->bindParam(":progress_task",$progress_task );
            $stmttask->execute();   
            //$lastId = $db->lastInsertId(); 
            foreach ($files['name'] as $i => $file_name) {
                $code = "AT";
                $numrand = (mt_rand());
                $type = strrchr($file_name,".");
                $newname = $date.$code.$numrand.$type;
                $file_tmp = $files['tmp_name'][$i];
                $file_dest = $file_name; 
                $file_data = "img/file/file_task/";
                move_uploaded_file($file_tmp,$file_data.$newname);
                if (!empty(array_filter($_FILES['files']['name']))) {
                    $inserfile_item_task = $db->prepare("INSERT INTO file_item_task(task_id,filename_task,project_id,newname_filetask) 
                    VALUES(:task_id,:filename_task,:project_id,:newname_filetask)");
                    $inserfile_item_task->bindParam(":task_id",$nextId);
                    $inserfile_item_task->bindParam(":project_id",$pro_id);
                    $inserfile_item_task->bindParam(":filename_task",$file_name);
                    $inserfile_item_task->bindParam(":newname_filetask",$newname);
                    $inserfile_item_task->execute(); 
                }
            }
            

          
           
              
            $_SESSION['success'] = "เพิ่มงานเรียบร้อย! ";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'เพิ่มงานเรียบร้อย!',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: true
                    });
                })
            </script>";
            $url_return = "refresh:2;view_project.php?view_id=".$pro_id;

        }
    

        /* if (!empty(array_filter($_FILES['files']['name']))) {
            $files = $_FILES['files'];
            foreach ($files['name'] as $i => $file_name) {
            $file_tmp = $files['tmp_name'][$i];
            $file_dest = $file_name; 
            $file_data = "img/file/file_task/";
            move_uploaded_file($file_tmp,$file_data.$file_dest);
            
            $inserfile_item_task = $db->prepare("INSERT INTO file_item_task(task_id,filename_task,project_id) 
            VALUES(:task_id,:filename_task,:project_id)");
            $inserfile_item_task->bindParam(":task_id",$nextId);
            $inserfile_item_task->bindParam(":project_id",$pro_id);
            $inserfile_item_task->bindParam(":filename_task",$file_dest);
            $inserfile_item_task->execute(); 
           
            }
        } */
           
    } 
    else if($_POST['proc'] == 'deltask'){
        
            $pro_id=$_POST['project_id']; 
            $taskid=$_POST['task_id'];
            
            $file_path_task = 'img/file/file_task/';

            $sql = "SELECT * from file_item_task  where task_id = $taskid";
            $qry = $db->query($sql);
            $qry->execute();
        
            while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)){  
                unlink($file_path_task.$row2['newname_filetask']); 
            }

        
            if(isset($taskid)){

                $delete_task = $db->prepare('DELETE FROM file_item_task WHERE task_id = :id');
                $delete_task->bindParam(':id', $taskid);
                $delete_task->execute();

                $delete_task_list = $db->prepare('DELETE FROM task_list WHERE task_id = :id');
                $delete_task_list->bindParam(':id', $taskid);
                $delete_task_list->execute();     

                $_SESSION['success'] = "ลบงานเรียบร้อยแล้ว!";
               // $url_return = "refresh:2;view_project.php?view_id=".$pro_id;

          
            } else {

                //$_SESSION['error'] = "มีบางอย่างผิดพลาด";
                //$url_return = "location:view_project.php?view_id=".$pro_id;
            }         
    }
    else if($_POST['proc'] == 'show'){
            echo "ttttttttttttttttttttttttttttttt";
            exit;
    }
    else if($_POST['proc'] == 'download'){
        

            $file_item_project = $_POST['file_item_project'];
            $file_item_task = $_POST['file_item_task'];
            $file_item_details = $_POST['file_item_details'];

            if(isset($file_item_project)){

                $stmt = $db->prepare("SELECT * FROM file_item_project WHERE file_item_project = :file_item_project");
                $stmt->bindParam(":file_item_project", $file_item_project);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $filename = $row['filename'];
                $original_filename = $row['newname_filepro'];
                $filepath = "img/file/file_project/".$original_filename;
                
              
                /* header('Content-Disposition: attachment; filename="' . $filename . '"');
                readfile($filepath); */

            }/* else if(isset($file_item_task)){

                $stmt = $db->prepare("SELECT * FROM file_item_task WHERE file_item_task = :file_item_task");
                $stmt->bindParam(":file_item_task", $file_item_task);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $filename = $row['filename_task'];
                $filepath = "img/file/file_task/".$filename;   

            }else if(isset($file_item_details)){

                $stmt = $db->prepare("SELECT * FROM file_item_details WHERE file_details_id = :file_details_id");
                $stmt->bindParam(":file_details_id", $file_item_details);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $filename = $row['filename_details'];
                $filepath = "img/file/file_details/".$filename;   
            } */
           
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            readfile($filepath);
        
    }
    else if($_POST['proc'] == 'delfilepro'){
        
        $file_item_project = $_POST['file_item_project'];
        $pro_id=$_POST['project_id']; 
      
    
        $file_path = 'img/file/file_project/';
        $sql = "SELECT * from file_item_project  where file_item_project = $file_item_project ";
        $qry = $db->query($sql);
        $qry->execute();

        while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)){  
            unlink($file_path.$row2['newname_filepro']); 
        }

        $stmt = $db->prepare("DELETE FROM file_item_project WHERE file_item_project = :file_item_project");
        $stmt->bindParam(":file_item_project", $file_item_project);
        $stmt->execute();

        $_SESSION['success'] = "ลบไฟล์เรียบร้อยแล้ว!";
            echo "
            <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'ลบไฟล์เรียบร้อยแล้ว!',
                    icon: 'success',
                    timer: 5000,
                    showConfirmButton: true
                });
            })
                </script>";
        $url_return = "refresh:2;editproject_page.php?update_id=".$pro_id;
    }
    else if($_POST['proc'] == 'delfiletask'){
        
      
        $taskid = $_POST['task_id'];
        $pro_id=$_POST['project_id']; 
        $file_item_task = $_POST['file_item_task'];
 
        $file_path = 'img/file/file_task/';
        $sql = "SELECT * from file_item_task  where file_item_task = $file_item_task ";
        $qry = $db->query($sql);
        $qry->execute();
        while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)){  

            unlink($file_path.$row2['newname_filetask']); 
        }

        $stmt = $db->prepare("DELETE FROM file_item_task WHERE file_item_task = :file_item_task");
        $stmt->bindParam(":file_item_task", $file_item_task);
        $stmt->execute();

        $_SESSION['success'] = "ลบไฟล์เรียบร้อยแล้ว!";
        echo "  <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'ลบไฟล์เรียบร้อยแล้ว!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: true
                        });
                    })
                </script>"; 
        $url_return = "refresh:1.5;edittask_page.php?updatetask_id=".$taskid."&project_id=".$pro_id;
    
    }
    else if($_POST['proc'] == 'edittask'){

        $pro_id =$_POST['project_id'];
        $sql = "SELECT * FROM project  where project_id = $pro_id";
        $qry = $db->query($sql);
        $qry->execute();
        $row2 = $qry->fetch(PDO::FETCH_ASSOC);
        
        $datestartproject = $row2['start_date'];
        $dateendproject = $row2['end_date'];
     
      
        $taskid = $_POST['task_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $taskname =$_POST['taskname'];
        $user=$_POST['user'];
        $textarea=trim($_POST['textarea']);
        $stat = 1 ;
        $files = $_FILES['files'];
        


        if(empty($taskname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่องาน';
            $url_return = "location:view_project.php?view_id=".$pro_id;
        }else if(empty($end_date)){
            $_SESSION['error'] = 'กรุณากรอกวันสิ้นสุดงาน';
            $url_return = "location:view_project.php?view_id=".$pro_id;
        }else if(strtotime($start_date) > strtotime($end_date) || strtotime($start_date) > strtotime($dateendproject)){
            $_SESSION['error'] = 'วันที่เริ่มงานของคุณไม่อยู่ระหว่างระยะเวลาของหัวข้องานโปรดกรอกใหม่อีกครั้ง!!!';
            $url_return = "location:view_project.php?view_id=".$pro_id;
            //strtotime($datestartproject) > strtotime($start_date) ||
            
        }else if( strtotime($end_date) < strtotime($start_date) || strtotime($end_date) >  strtotime($dateendproject) ){
            $_SESSION['error'] = 'วันที่สิ้นสุดงานของคุณไม่อยู่ระหว่างระยะเวลาของหัวข้องานโปรดกรอกใหม่อีกครั้ง!!';
            $url_return = "location:view_project.php?view_id=".$pro_id;
            
        }else if (!isset($_SESSION['error'])) {
        
            $updatestmttask = $db->prepare("UPDATE task_list SET name_tasklist=:taskname, description_task=:textarea, status_task=:status, strat_date_task=:start_date, end_date_task=:end_date,  user_id=:users_id WHERE task_id = :id ");
            $updatestmttask->bindParam(":taskname", $taskname);
            $updatestmttask->bindParam(":textarea", $textarea);
            $updatestmttask->bindParam(":status", $stat);
            $updatestmttask->bindParam(":start_date", $start_date);
            $updatestmttask->bindParam(":end_date", $end_date);
            //$updatestmttask->bindParam(":file_task",$file_task);
            //$stmttask->bindParam(":pro_id", $project_id);
            $updatestmttask->bindParam(":users_id",$user);
            $updatestmttask->bindParam(":id", $taskid);
            $updatestmttask->execute();   

            foreach ($files['name'] as $i => $file_name) {
                $code = "ET";
                $numrand = (mt_rand());
                $type = strrchr($file_name,".");
                $newname = $date.$code.$numrand.$type;
                $file_tmp = $files['tmp_name'][$i];
                $file_dest = $file_name; 
                $file_data = "img/file/file_task/";
                move_uploaded_file($file_tmp,$file_data.$newname);
                if(!empty(array_filter($_FILES['files']['name']))) {
                    $inserfile_item_task = $db->prepare("INSERT INTO file_item_task(task_id,filename_task,project_id,newname_filetask) 
                    VALUES(:task_id,:filename_task,:proid,:newname_filetask)");
                    $inserfile_item_task->bindParam(":task_id",$taskid);
                    $inserfile_item_task->bindParam(":filename_task",$file_dest);
                    $inserfile_item_task->bindParam(":proid",$pro_id );
                    $inserfile_item_task->bindParam(":newname_filetask",$newname);
                    $inserfile_item_task->execute(); 
                        }
                    }
        
            $_SESSION['success'] = "เเก้ไขงานเสร็จเรียบร้อย! ";
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'เเก้ไขงานเสร็จเรียบร้อย!',
                    icon: 'success',
                    timer: 5000,
                    showConfirmButton: true
                });
            })
        </script>";
            $url_return = "refresh:1.5;view_project.php?view_id=".$pro_id;
            
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาด";
            $url_return ="location:view_project.php?view_id=".$pro_id;
        
        }        
            
               
               
        /* if(!empty(array_filter($_FILES['files']['name']))) {
                $files = $_FILES['files'];
                foreach ($files['name'] as $i => $file_name) {
                $file_tmp = $files['tmp_name'][$i];
                $file_dest = $file_name; 
                $file_data = "img/file/file_task/";
                move_uploaded_file($file_tmp,$file_data.$file_dest);
                
                $inserfile_item_task = $db->prepare("INSERT INTO file_item_task(task_id,filename_task) 
                VALUES(:task_id,:filename_task)");
                $inserfile_item_task->bindParam(":task_id",$taskid);
                $inserfile_item_task->bindParam(":filename_task",$file_dest);
                $inserfile_item_task->execute(); 
                
                } 
                $_SESSION['success'] = "เพิ่มงานเรียบร้อย! ";
                $url_return = "location:view_project.php?view_id=".$pro_id;

            }else {
                $_SESSION['success'] = "เพิ่มงานเรียบร้อย! ";
                $url_return ="location:view_project.php?view_id=".$pro_id;
            
            }       */
              
    }
    else if($_POST['proc'] == 'addpro'){
        //print_r($_POST['users_id']); 
       
        $code = "P";
        $yearMonth = substr(date("Y")+543, -2);


        $sql = "SELECT MAX(project_id) AS last_id FROM project";
        $qry = $db->query($sql);
        $qry->execute();
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $maxId = $row['last_id'];

        if($maxId ==''){

            $maxId = 1;
        }else{

            $maxId = ($maxId + 1);
        }
        $nextId = substr($yearMonth."00".$maxId,-5);

        $status1 = 1;
        $manager_id=$_SESSION['user_login'];
        $proname = $_POST['proname'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $description =trim($_POST['description']);
        $status2=$_POST['status2'];
        $job = $_POST['job'];
        $users_id1=$_POST['users_id']; // รับค้ามาเป็น arery id เดียว
       //$numbers_string = implode(",", $users_id1); // implode ลูกน้ำเข้าไปเเล้วทำให้เป็น string
        $users_id = explode(",", $users_id1); // เเล้วก็นำ string มาทำเป็น array หลาย id 
        $progress_project = 0;
        $files = $_FILES['files']; 
  
       //echo $users_id1;
      //  print_r($users_id);

        
        //$type = strrchr($files['name'],".");                                      
        /*$type = strrchr($_FILES['files']['name'],".");
        print_r($type);
        exit; */
   
       //print_r($files['tmp_name'][$i]);
       //echo $file_tmp.$file_data.$file_dest;
       //echo $newname;
       //exit;

       $stmtuser = "SELECT CONCAT(firstName, ' ', lastName) As FullName  FROM user where user_id = ".$manager_id."";
       $stmtuser = $db->prepare($stmtuser);
       $stmtuser ->execute();
       $stmtuserrow = $stmtuser->fetch(PDO::FETCH_ASSOC);

       $stmtjobtype = "SELECT* FROM job_type where id_jobtype = ".$job."";
       $stmtjobtype = $db->prepare($stmtjobtype);
       $stmtjobtype ->execute();
       $stmtjobtyperow = $stmtjobtype->fetch(PDO::FETCH_ASSOC);
          // echo showstatpro2($status2);
   

       
        if (empty($proname)) {
          $_SESSION['error'] = 'กรุณากรอกชื่อหัวข้องาน';
          $url_return ="location:addproject_page.php";
          //header("location:addproject_page.php");
       } else if (empty($start_date)) {
          $_SESSION['error'] ='กรุณากรอกวันที่เริ่ม';
          $url_return ="location:addproject_page.php";
       }else if (empty($end_date)) {
          $_SESSION['error'] = 'กรุณากรอกวันที่สิ้นสุด';
          $url_return ="location:addproject_page.php";
       }else if (empty($users_id1)) {
          $_SESSION['error'] = 'กรุณากรอกชื่อสมาชิก';
          $url_return ="location:addproject_page.php";
       }else{
            foreach($users_id as $i => $userid ){
           
                $datauser = $db->prepare("SELECT line_token FROM user WHERE user_id = :userid");
                $datauser->bindParam(":userid",$userid);
                $datauser ->execute();
                $datauserrow = $datauser->fetch(PDO::FETCH_ASSOC); 
            
                $sToken = $datauserrow['line_token'];
                $sMessage = "มีการเพื่มโปรเจค \n";
                $sMessage .= "ชื่อห้วงาน : ".$proname." \n";
                $sMessage .= "ประเภทงาน : ".$stmtjobtyperow['name_jobtype']." \n";
                $sMessage .= "วันที่สั่ง : ".ThDate($start_date)." \n";
                $sMessage .= "วันที่สิ้นสุด : ".ThDate($end_date)." \n";
                $sMessage .= "คนที่สั่งงาน : ".$stmtuserrow['FullName']." \n";
        
                $chOne = curl_init(); 
                curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
                curl_setopt( $chOne, CURLOPT_POST, 1); 
                curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
                $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
                curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
                $result = curl_exec( $chOne );  
                
           }   
       }  
       if(!isset($_SESSION['error'])) {
           $inserstmtpro = $db->prepare("INSERT INTO project(project_id,name_project, description, status_1,start_date, end_date, manager_id,status_2,id_jobtype,progress_project) 
                                              VALUES(:project_id,:proname,:description,:status,:start_date,:end_date,:manager_id,:status_2,:id_job,:progress_project)");
           $inserstmtpro->bindParam(":project_id",$nextId);
           $inserstmtpro->bindParam(":proname", $proname);
           $inserstmtpro->bindParam(":description", $description);
           $inserstmtpro->bindParam(":status", $status1);
           $inserstmtpro->bindParam(":start_date", $start_date);
           $inserstmtpro->bindParam(":end_date", $end_date);
           $inserstmtpro->bindParam(":manager_id", $manager_id);
           $inserstmtpro->bindParam(":status_2", $status2);
           $inserstmtpro->bindParam(":id_job", $job);
           $inserstmtpro->bindParam(":progress_project", $progress_project);
           $inserstmtpro->execute(); 
          // $lastId = $db->lastInsertId();
      
            foreach ($users_id as $id => $user_id){
             $inserstmtprolist= $db->prepare("INSERT INTO project_list(project_id,user_id) VALUES(:project_id,:user_id)");
             $inserstmtprolist->bindParam(":project_id", $nextId);
             $inserstmtprolist->bindParam(":user_id", $user_id);
             $inserstmtprolist->execute(); 
            }
         
            foreach ($files['name'] as $i => $file_name) {
                $code = "P";
                $numrand = (mt_rand());
                $type = strrchr($file_name,".");
                $newname = $date.$code.$numrand.$type;
                $file_tmp = $files['tmp_name'][$i];
                $file_dest = $file_name; 
                $file_data = "img/file/file_project/";
                move_uploaded_file($file_tmp,$file_data.$newname);
                if (!empty(array_filter($_FILES['files']['name']))) {
                $inserfile_item_porject = $db->prepare("INSERT INTO file_item_project(project_id,filename,newname_filepro) 
                VALUES(:project_id,:filename,:newname_filepro)");
                $inserfile_item_porject->bindParam(":project_id",$nextId);
                $inserfile_item_porject->bindParam(":filename",$file_name);
                $inserfile_item_porject->bindParam(":newname_filepro",$newname);
                $inserfile_item_porject->execute();  
                }
            }

 
        $_SESSION['success'] = "เพิ่มโปรเจคเรียบร้อย! ";
        echo "  <script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'เพิ่มงานเรียบร้อย!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: true
                            });
                        })
                    </script>"; 
           $url_return ="refresh:2;project_list.php";
    
        }
       
        
         
    }      
    else if($_POST['proc'] == 'editpro'){
 
            $proid=$_POST['project_id'];
           // $status1 = 1;
            $proname = $_POST['proname'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $description =trim($_POST['description']);
            $manager_id=$_SESSION['user_login'];
            $status2=$_POST['status2'];
            $file_project = null;
            $job = $_POST['job'];
            $users_id1 = $_POST['users_id'];
            $users_id = explode(",", $users_id1);
            $status1 =$_POST['status1'];
 

        
           // $user_string = "(" . implode(",",$users_id) . ")";

            if (!empty($users_id1)) {
                $update_stmtpro = $db->prepare('UPDATE project SET name_project=:name_project,description= :description,status_1=:status_1,start_date= :start_date,end_date=:end_date
                ,status_2=:status_2,id_jobtype=:id_jobtype WHERE project_id =:id');
                $update_stmtpro->bindParam(":name_project", $proname);
                $update_stmtpro->bindParam(":description", $description);
                $update_stmtpro->bindParam(":status_1", $status1);
                $update_stmtpro->bindParam(":start_date", $start_date);
                $update_stmtpro->bindParam(":end_date", $end_date);
                //$update_stmtjob->bindParam(":file_project",$file_project);
                //$update_stmtjob->bindParam(":manager_id", $manager_id);
                $update_stmtpro->bindParam(":status_2", $status2);
                $update_stmtpro->bindParam(":id_jobtype", $job);
                $update_stmtpro->bindParam(":id", $proid);
                $update_stmtpro->execute(); 

                $sql = "DELETE FROM task_list WHERE project_id = :project_id AND user_id NOT IN ($users_id1)";
                $delete_stmttask = $db->prepare($sql);
                $delete_stmttask->bindParam(":project_id", $proid);
                $delete_stmttask->execute();

                $delete_stmtprojectlist = $db->prepare('DELETE FROM project_list WHERE project_id=:id');
                $delete_stmtprojectlist->bindParam(":id", $proid);
                $delete_stmtprojectlist->execute(); 
                
                foreach ($users_id as $id => $users_id){
                $inser_stmtprolist= $db->prepare("INSERT INTO project_list(project_id,user_id) VALUES(:project_id,:user_id)");
                $inser_stmtprolist->bindParam(":project_id", $proid );
                $inser_stmtprolist->bindParam(":user_id", $users_id );
                $inser_stmtprolist->execute(); 
                }
            } else {
                $_SESSION['error'] = "เกิดข้อผิดพลาด";
                header("location: project_list.php");
                    } 

            if (!empty(array_filter($_FILES['files']['name']))) {
                $files = $_FILES['files'];
                foreach ($files['name'] as $i => $file_name) {
                $code = "EP";
                $numrand = (mt_rand());
                $type = strrchr($file_name,".");
                $newname = $date.$code.$numrand.$type;    
                $file_tmp = $files['tmp_name'][$i];
                $file_dest = $file_name; 
                $file_data = "img/file/file_project/";
                move_uploaded_file($file_tmp,$file_data.$newname);
                
                $inserfile_item_porject = $db->prepare("INSERT INTO file_item_project(project_id,filename,newname_filepro) 
                VALUES(:project_id,:filename,:newname_filepro)");
                $inserfile_item_porject->bindParam(":project_id",$proid);
                $inserfile_item_porject->bindParam(":filename",$file_dest);
                $inserfile_item_porject->bindParam(":newname_filepro",$newname);
                $inserfile_item_porject->execute(); 
                }
            }

                $_SESSION['success'] = "เเก้ไขเรียบร้อย! ";
                echo "  <script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'เเก้ไขเรียบร้อย!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: true
                            });
                        })
                    </script>"; 
                $url_return = "refresh:2;project_list.php";

    }
    else if($_POST['proc'] == 'deleteproject'){
       
        $project_id= $_POST['project_id'];
       

        $check = "SELECT * from file_item_project  where project_id = $project_id";
	    $result  = $db->query($check);
		$num=$result->fetchColumn();

        if($num>0){

            $file_path1 = 'img/file/file_project/';
            $sql = "SELECT * from project  natural join file_item_project where project_id = $project_id ";
            $qry = $db->query($sql);
            $qry->execute();
            while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)){  
                unlink($file_path1.$row2['newname_filepro']);
            }  
            $delete_taskitem = $db->prepare('DELETE  FROM file_item_project  WHERE project_id=:id');
            $delete_taskitem->bindParam(':id', $project_id);
            $delete_taskitem->execute(); 
        }

        if($project_id){
            $delete_task = $db->prepare('DELETE project_list,project FROM project_list  natural join project WHERE project_id=:id');
            $delete_task->bindParam(':id', $project_id);
            $delete_task->execute();  

       /*  $delete_taskitem = $db->prepare('DELETE  FROM file_item_task  WHERE project_id=:id');
        $delete_taskitem->bindParam(':id', $project_id);
        $delete_taskitem->execute();  */

       
            $_SESSION['success'] = "ลบหัวข้องานเรียบร้อยแล้ว!";
        } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
      
        } 
    }
    else if($_POST['proc'] == 'sendtask'){
       
        $project_id= $_POST['project_id'];
        $taskid = $_POST['task_id'];
        $commenttask = trim($_POST['text_comment']);
        $progress_task = $_POST['progress_task'];
        $user_id = $_POST['user_id'];
        $senddate = $_POST['senddate'];
        $state_details = $_POST['state_details'];
        $status_task = "2";
        $send_status = "1";
        

        $files = $_FILES['files']; 

        
       $numfilesend =sizeof(array_filter($_FILES['files']['name']));

    

       if ($numfilesend != "0" OR $commenttask != ""){ 

            $inserstmtdetails = $db->prepare("INSERT INTO details(project_id,task_id,comment,date_detalis,state_details,progress_details,usersenddetails,send_status) 
                                                VALUES(:project_id,:task_id,:comment,:date_detalis,:state_details,:progress_details,:usersenddetails,:send_status)");
            $inserstmtdetails->bindParam(":project_id",$project_id);
            $inserstmtdetails->bindParam(":task_id", $taskid);
            $inserstmtdetails->bindParam(":comment", $commenttask);
            $inserstmtdetails->bindParam(":state_details", $state_details);
            $inserstmtdetails->bindParam(":date_detalis",$senddate);
            $inserstmtdetails->bindParam(":progress_details",$progress_task);
            $inserstmtdetails->bindParam(":usersenddetails",$user_id);
            $inserstmtdetails->bindParam(":send_status",$send_status);
            $inserstmtdetails->execute(); 
            $lastId = $db->lastInsertId(); 

            $updatestattask = $db->prepare("UPDATE task_list SET status_task = :status_task WHERE task_id = :task_id");
            $updatestattask->bindParam(":status_task",$status_task);
            $updatestattask->bindParam(":task_id",$taskid);
            $updatestattask->execute(); 
       
       
            foreach ($files['name'] as $i => $file_name) {
            $code = "ST";
            $numrand = (mt_rand());
            $type = strrchr($file_name,".");
            $newname = $date.$code.$numrand.$type;
            $file_tmp = $files['tmp_name'][$i];
            $file_dest = $file_name; 
            $file_data = "img/file/file_details/";
            move_uploaded_file($file_tmp,$file_data.$newname);
            if($numfilesend != "0" ){
            $inserfile_item_details = $db->prepare("INSERT INTO file_item_details(project_id,task_id,filename_details,details_id,newname_filedetails) 
            VALUES(:project_id,:task_id,:filename_details,:details_id,:newname_filedetails)");
            $inserfile_item_details->bindParam(":project_id",$project_id);
            $inserfile_item_details->bindParam(":task_id",$taskid);
            $inserfile_item_details->bindParam(":filename_details",$file_name);
            $inserfile_item_details->bindParam(":details_id",$lastId);
            $inserfile_item_details->bindParam(":newname_filedetails",$newname);
            $inserfile_item_details->execute();  
            }
       }
            /* $dataproject = "SELECT name_project,manager_id FROM project where project_id = ".$project_id."";
            $dataproject = $db->prepare($dataproject);
            $dataproject ->execute();
            $dataprojectrow = $dataproject->fetch(PDO::FETCH_ASSOC);
            $manager_id = $dataprojectrow['manager_id']; */
        
            

           $_SESSION['success'] = "ส่งงานเรียบร้อยแล้ว! ";
           echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'ส่งงานเรียบร้อยแล้ว!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: true
                        }).then(() => {
                            document.location.href = 'view_project.php?view_id=".$project_id."';
                        })
                    });
                </script>";
            $dataproject = "SELECT name_tasklist ,name_project,manager_id,  CONCAT(firstName, ' ', lastName) As FullName ,user_id FROM  user natural join  task_list natural join project where task_id = ".$taskid."";
            $dataproject = $db->prepare($dataproject);
            $dataproject ->execute();
            $dataprojectrow = $dataproject->fetch(PDO::FETCH_ASSOC);
            $manager_id = $dataprojectrow['manager_id'];  
        
            $datauser = $db->prepare("SELECT line_token  FROM user WHERE user_id = :userid");
            $datauser ->bindParam(":userid",$manager_id);
            $datauser ->execute();
            $datauserrow = $datauser->fetch(PDO::FETCH_ASSOC);   
        
            $sToken = $datauserrow['line_token'];
            $sMessage = "มีงานส่งมา \n";
            $sMessage .= "ชื่อห้วงาน : ".$dataprojectrow['name_project']." \n";
            $sMessage .= "ชื่องาน : ".$dataprojectrow['name_tasklist']." \n";
            $sMessage .= "วันที่ส่ง : ".thai_date_and_time_short($senddate)." \n";
            $sMessage .= "คนที่ส่งงาน : ".$dataprojectrow['FullName']." \n";
        
            $chOne = curl_init(); 
            curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
            curl_setopt( $chOne, CURLOPT_POST, 1); 
            curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
            $result = curl_exec( $chOne ); 
           //$url_return ="location:view_project.php?view_id=".$project_id;
     } else {
            $_SESSION['error'] = "กรุณากรอกข้อความ หรือ เเนบไฟล์ส่ง";
            $url_return ="location:send_task.php?task_id=".$taskid."&project_id=".$project_id."&user_id=".$user_id;
           }
    
        
      
       
      
    }
    else if($_POST['proc'] == 'deldetails'){

        $details_id = $_POST['details'];
        $project_id= $_POST['project_id'];
        $taskid = $_POST['task_id'];
        $status_task = 1;
      
        // echo $taskid.' '.$project_id.' '.$details_id;details
        
        $delete_fileitemdetails = $db->prepare('DELETE FROM file_item_details WHERE  details_id = :id');
        $delete_fileitemdetails->bindParam(':id',$details_id);
        $delete_fileitemdetails->execute();
        
        $delete_details= $db->prepare('DELETE FROM details WHERE details_id = :id');
        $delete_details->bindParam(':id',$details_id);
        $delete_details->execute();  

        $updatestattask = $db->prepare("UPDATE task_list SET status_task = :status_task WHERE task_id = :task_id");
        $updatestattask->bindParam(":status_task",$status_task);
        $updatestattask->bindParam(":task_id",$taskid);
        $updatestattask->execute(); 
       
        $_SESSION['success'] = "ยกเลิกงานเรียบร้อยแล้ว!";
        $url_return ="location:view_project.php?view_id=".$project_id;


   

       

   
        

  
    }   
    else if($_POST['proc'] == 'checktasksuccess'){

        $details_id = $_POST['details_id'];
        $task_id = $_POST['task_id'];
        $project_id = $_POST['project_id'];
        $statdetails= "N";
        $tasksuccess = 100;
        $status_task ="5";

        $updatetaskprogress = $db->prepare("UPDATE task_list SET progress_task = :tasksuccess , status_task = :status_task WHERE task_id = :task_id");
        $updatetaskprogress->bindParam(":tasksuccess",$tasksuccess);
        $updatetaskprogress->bindParam(":task_id", $task_id);
        $updatetaskprogress->bindParam(":status_task", $status_task);
        $updatetaskprogress->execute(); 

        $updatestatdetails = $db->prepare("UPDATE details SET state_details = :state_details ,progress_details = :progress WHERE details_id = :details_id");
        $updatestatdetails->bindParam(":state_details",$statdetails);
        $updatestatdetails->bindParam(":progress",$tasksuccess);
        $updatestatdetails->bindParam(":details_id", $details_id);
        $updatestatdetails->execute(); 

        $_SESSION['success'] = "ตรวจงานเรียบร้อยแล้ว!!! ";
        //$url_return ="location:checktask_list.php";
     
    }
    else if($_POST['proc'] == 'send_edittask'){

        $details_id = $_POST['details_id'];
        
        $task_id = $_POST['task_id'];
        $project_id = $_POST['project_id'];
        $state_details = $_POST['state_details'];
        $progress = $_POST['progress'];
        $senddate = $_POST['senddate'];
        $progress_task = $_POST['progress_task'];
        $commenttask = $_POST['text_comment'];
        $status_task = "3";
        $send_status = "2";
        $files = $_FILES['files'];

      
        $numfilesend =sizeof(array_filter($_FILES['files']['name']));

        $updatestatdetails = $db->prepare("UPDATE details SET state_details = :state_details, progress_details = :progress WHERE details_id = :details_id");
        $updatestatdetails->bindParam(":state_details", $state_details);
        $updatestatdetails->bindParam(":progress", $progress_task);
        $updatestatdetails->bindParam(":details_id", $details_id);
        $updatestatdetails->execute(); 
 
        $inserstmtdetails = $db->prepare("INSERT INTO details(project_id,task_id,comment,date_detalis,state_details,progress_details,usersenddetails,send_status) 
        VALUES(:project_id,:task_id,:comment,:date_detalis,:state_details,:progress,:usersenddetails,:send_status)");
        $inserstmtdetails->bindParam(":project_id",$project_id);
        $inserstmtdetails->bindParam(":task_id", $task_id);
        $inserstmtdetails->bindParam(":comment", $commenttask);
        $inserstmtdetails->bindParam(":date_detalis",$senddate);
        $inserstmtdetails->bindParam(":state_details",$state_details);
        $inserstmtdetails->bindParam(":progress",$progress);
        $inserstmtdetails->bindParam(":usersenddetails",$user_id);
        $inserstmtdetails->bindParam(":send_status",$send_status);
        $inserstmtdetails->execute();
        $lastId = $db->lastInsertId(); 

      
        $updatestattask = $db->prepare("UPDATE task_list SET status_task = :status_task ,progress_task = :progress WHERE task_id = :task_id");
        $updatestattask->bindParam(":status_task",$status_task);
        $updatestattask->bindParam(":progress",$progress);
        $updatestattask->bindParam(":task_id",$task_id);
        $updatestattask->execute(); 

       
        foreach ($files['name'] as $i => $file_name) {
            $code = "D";
            $numrand = (mt_rand());
            $type = strrchr($file_name,".");
            $newname = $date.$code.$numrand.$type;
            $file_tmp = $files['tmp_name'][$i];
            $file_dest = $file_name; 
            $file_data = "img/file/file_details/";
            move_uploaded_file($file_tmp,$file_data.$newname);
            if($numfilesend != "0" ){
            $inserfile_item_details = $db->prepare("INSERT INTO file_item_details(project_id,task_id,filename_details,details_id,newname_filedetails) 
            VALUES(:project_id,:task_id,:filename_details,:details_id,:newname_filedetails)");
            $inserfile_item_details->bindParam(":project_id",$project_id);
            $inserfile_item_details->bindParam(":task_id",$task_id);
            $inserfile_item_details->bindParam(":filename_details",$file_name);
            $inserfile_item_details->bindParam(":details_id",$lastId);
            $inserfile_item_details->bindParam(":newname_filedetails",$newname);
            $inserfile_item_details->execute();  
            }
       }

            $_SESSION['success'] = "ส่งงานกลับเเก้ไขเรียบร้อยแล้ว!!! ";
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'ส่งงานกลับเเก้ไขเรียบร้อยแล้ว!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: true
                }).then(() => {
                    document.location.href = 'checktask_list.php';
                })
            });
        </script>";

        $dataproject = "SELECT line_token ,name_project,name_tasklist, user_id FROM project natural join  task_list  natural join user where task_id = ".$task_id."";
        $dataproject = $db->prepare($dataproject);
        $dataproject ->execute();
        $dataprojectrow = $dataproject->fetch(PDO::FETCH_ASSOC);

        $datauser = $db->prepare("SELECT CONCAT(firstName, ' ', lastName) As FullName , line_token FROM user WHERE user_id = :userid");
        $datauser->bindParam(":userid",$user_id);
        $datauser ->execute();
        $datauserrow = $datauser->fetch(PDO::FETCH_ASSOC); 


        $sToken = $dataprojectrow['line_token'];
        $sMessage = "มีงานต้องเเก้ไข \n";
        $sMessage .= "ชื่อห้วงาน : ".$dataprojectrow['name_project']." \n";
        $sMessage .= "ชื่องาน : ".$dataprojectrow['name_tasklist']." \n";
        $sMessage .= "วันที่ส่งการเเก้ไข : ".thai_date_and_time_short($senddate)." \n";
        $sMessage .= "คนตรวจงาน : ".$datauserrow['FullName']." \n";

        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec( $chOne );  
            //$url_return ="location:checktask_list.php";

    }
    else if($_POST['proc'] == 'adduser'){
      //  echo 234234234234;
       
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $role = $_POST['role'];
        $phone = $_POST['phone'];
        $switch = $_POST['switch'];
        $tokenline = $_POST['tokenline'];
        $phone = $_POST['phone'];
        $idcard = trim($_POST['idcard']);
        if($switch == "on"){
            $switch = 1;
        }else{
            $switch = 0;
        }

        $file = $_FILES['file'];
        $filename = $file['name'];
        if($filename != "" ){
        $code = "U";
        $numrand = (mt_rand());
        $type = strrchr($filename,".");
        $newname = $date.$code.$numrand.$type;
        $file_tmp = $file['tmp_name'];
        $file_dest = $filename; 
        $file_data = "img/avatars/";
        move_uploaded_file($file_tmp,$file_data.$newname);
        }

         if (empty($firstname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            $url_return ="location:user_list.php";
          } else if (empty($lastname)) {
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            $url_return ="location:user_list.php";
        } else if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            $url_return ="location:user_list.php";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            $url_return ="location:user_list.php";
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            $url_return ="location:user_list.php";
        } else if (strlen($password) > 20 || strlen($password) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            $url_return ="location:user_list.php";
        } else if (preg_match('/[\p{Thai}]/u', $password)){
            $_SESSION['error'] = 'รหัสผ่านมีตัวอักษรภาษาไทย';
            $url_return ="location:user_list.php";
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            $url_return ="location:user_list.php";
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            $url_return ="location:user_list.php";
        }else if(empty($file)){
            $_SESSION['error'] = "กรุณาเเนบไฟล์รูปภาพ";
            $url_return ="location:user_list.php";
        }else if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $_SESSION['error'] = "รูปเเบบเบอร์โทรไม่ถูกต้อง";
            $url_return ="location:user_list.php";
        }else if (!preg_match("/^[0-9]{13}$/", $idcard)) {
            $_SESSION['error'] = "รูปเเบบบัตรประชาชนไม่ถูกต้อง";
            $url_return ="location:user_list.php";
        }else{
                $check_email = $db->prepare("SELECT email FROM user WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
               // print_r ($row);
               $email1 = $row['email'];   
                        if ($email1 == $email) {
                            $_SESSION['error'] = "มีอีเมลนี้อยู่ในระบบแล้ว ";
                            $url_return ="location:user_list.php";
                        } else if (!isset($_SESSION['error'])) {
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $db->prepare("INSERT INTO user(firstname, lastname, email, password, role_id,avatar,status_user,tel,line_token,idcard) 
                                                    VALUES(:firstname, :lastname, :email, :password, :role_id,:avatar,:status_user,:tel,:line_token,:idcard)");
                            $stmt->bindParam(":firstname", $firstname);
                            $stmt->bindParam(":lastname", $lastname);
                            $stmt->bindParam(":email", $email);
                            $stmt->bindParam(":password", $passwordHash);
                            $stmt->bindParam(":role_id", $role);
                            $stmt->bindParam(":avatar", $newname);
                            $stmt->bindParam(":status_user",$switch);
                            $stmt->bindParam(":tel", $phone);
                            $stmt->bindParam(":line_token",$tokenline);
                            $stmt->bindParam(":idcard",$idcard);
                            $stmt->execute();
                            $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! ";
                            echo "<script>
                                    $(document).ready(function() {
                                        Swal.fire({
                                            title: 'สมัครสมาชิกเรียบร้อยแล้ว!',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: true
                                        }).then(() => {
                                            document.location.href = 'user_list.php';
                                        })
                                    });
                                </script>";
                            //$url_return ="location:user_list.php";
                        } else {
                            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                            $url_return ="location:user_list.php";
                        } 
                    }
    }
    else if($_POST['proc'] == 'edituseradmin'){
        $userid = $_POST['userid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $phone = $_POST['phone'];
        $tokenline = $_POST['tokenline'];
        $switch = $_POST['switch'];
        $idcard = trim($_POST['idcard']);
        
        if($switch == "on"){
            $switch = 1;
        }else{
            $switch = 0;
        }

        $file = $_FILES['file'];
        $filename = $file['name'];

        if($filename != "" ){
            $code = "U";
            $numrand = (mt_rand());
            $type = strrchr($filename,".");
            $newname = $date.$code.$numrand.$type;
            $file_tmp = $file['tmp_name'];
            $file_dest = $filename; 
            $file_data = "img/avatars/";
            move_uploaded_file($file_tmp,$file_data.$newname);
            $check_img = $db->prepare("SELECT avatar FROM user WHERE user_id = :id");
            $check_img->bindParam(":id", $userid);
            $check_img->execute();
            $check_imgrow = $check_img->fetch(PDO::FETCH_ASSOC);
                unlink("img/avatars/".$check_imgrow['avatar']);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            $url_return ="location:edituser_page.php?update_id=".$userid."";    
        }else if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $_SESSION['error'] = "รูปเเบบเบอร์โทรไม่ถูกต้อง";
            $url_return ="location:edituser_page.php?update_id=".$userid."";    
        }else if (!preg_match("/^[0-9]{13}$/", $idcard)) {
            $_SESSION['error'] = "รูปเเบบบัตรประชาชนไม่ถูกต้อง";
            $url_return ="location:edituser_page.php?update_id=".$userid."";    

        }
            $check_email = $db->prepare("SELECT email FROM user WHERE email = :email AND user_id != :user_id");
            $check_email->bindParam(":email", $email);
            $check_email->bindParam(":user_id", $userid);
            $check_email->execute();
            $check_emailrow = $check_email->fetch(PDO::FETCH_ASSOC);

        if ($check_emailrow['email'] == $email) {
            $_SESSION['error'] = "มีอีเมลนี้อยู่ในระบบแล้ว ";
            $url_return ="location:edituser_page.php?update_id=".$userid."";    

        }else if($file['name'] == "" AND !isset($_SESSION['error'])){
            $update_stmt = $db->prepare('UPDATE user SET firstname = :firstname ,lastname = :lastname ,email =:email , role_id = :role_id,status_user = :status_user ,tel = :tel ,line_token = :line_token, idcard = :idcard  WHERE user_id = :id');
            $update_stmt->bindParam(':firstname', $firstname);
            $update_stmt->bindParam(":lastname", $lastname);
            $update_stmt->bindParam(":email", $email);
            //$update_stmt->bindParam(":avatar", $newname);
            $update_stmt->bindParam(":role_id", $role);
            $update_stmt->bindParam(":status_user", $switch);
            $update_stmt->bindParam(":tel", $phone);
            $update_stmt->bindParam(":line_token", $tokenline);
            $update_stmt->bindParam(":idcard", $idcard);
            $update_stmt->bindParam(':id', $userid);
            $update_stmt->execute();

            $_SESSION['success'] = "เเก้ไขเรียบร้อยแล้ว";
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'เเก้ไขเรียบร้อยแล้ว!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: true
                        }).then(() => {
                            document.location.href = 'user_list.php';
                        })
                    });
                </script>";
            //$url_return ="location:edituser_page.php?update_id=".$userid."";    

        }else if($file['name'] != "" AND !isset($_SESSION['error'])){  
            $update_stmt = $db->prepare('UPDATE user SET firstname = :firstname ,lastname = :lastname ,email =:email , role_id = :role_id ,avatar = :avatar, status_user = :status_user ,tel = :tel ,line_token = :line_token ,idcard = :idcard WHERE user_id = :id');
            $update_stmt->bindParam(':firstname', $firstname);
            $update_stmt->bindParam(":lastname", $lastname);
            $update_stmt->bindParam(":email", $email);
            $update_stmt->bindParam(":avatar", $newname);
            $update_stmt->bindParam(":role_id", $role);
            $update_stmt->bindParam(":status_user", $switch);
            $update_stmt->bindParam(":tel", $phone);
            $update_stmt->bindParam(":line_token", $tokenline);
            $update_stmt->bindParam(":idcard", $idcard);
            $update_stmt->bindParam(':id', $userid);
            $update_stmt->execute();

            $_SESSION['success'] = "เเก้ไขเรียบร้อยแล้ว";
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'เเก้ไขเรียบร้อยแล้ว!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: true
                }).then(() => {
                    document.location.href = 'user_list.php';
                })
            });
        </script>";
            $url_return ="location:user_list.php";    

        } else {
            $url_return ="location:edituser_page.php?update_id=".$userid."";     
        } 
           
            
                
    }
    else if($_POST['proc'] == 'edituser'){


        $userid = $_POST['userid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $tokenline = $_POST['tokenline'];
        $idcard = trim($_POST['idcard']);
        
        $file = $_FILES['file'];
        $filename = $file['name'];

        if($filename != "" ){
            $code = "U";
            $numrand = (mt_rand());
            $type = strrchr($filename,".");
            $newname = $date.$code.$numrand.$type;
            $file_tmp = $file['tmp_name'];
            $file_dest = $filename; 
            $file_data = "img/avatars/";
            move_uploaded_file($file_tmp,$file_data.$newname);
            $check_img = $db->prepare("SELECT avatar FROM user WHERE user_id = :id");
            $check_img->bindParam(":id", $userid);
            $check_img->execute();
            $check_imgrow = $check_img->fetch(PDO::FETCH_ASSOC);
                unlink("img/avatars/".$check_imgrow['avatar']);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            $url_return ="location:edituser.php?user_id=".$userid."";    
        }else if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $_SESSION['error'] = "รูปเเบบเบอร์โทรไม่ถูกต้อง";
            $url_return ="location:edituser.php?user_id=".$userid."";    
        }else if (!preg_match("/^[0-9]{13}$/", $idcard)) {
            $_SESSION['error'] = "รูปเเบบบัตรประชาชนไม่ถูกต้อง";
            $url_return ="location:edituser.php?user_id=".$userid."";    

        }
            $check_email = $db->prepare("SELECT email FROM user WHERE email = :email AND user_id != :user_id");
            $check_email->bindParam(":email", $email);
            $check_email->bindParam(":user_id", $userid);
            $check_email->execute();
            $check_emailrow = $check_email->fetch(PDO::FETCH_ASSOC);
            $check_email == $check_emailrow['email'];
            
        if ($check_email == $email) {
            $_SESSION['error'] = "มีอีเมลนี้อยู่ในระบบแล้ว ";
            $url_return ="location:edituser.php?user_id=".$userid."";    

        }else if($file['name'] == "" AND !isset($_SESSION['error'])){
            $update_stmt = $db->prepare('UPDATE user SET firstname = :firstname ,lastname = :lastname ,email =:email , tel = :tel ,line_token = :line_token, idcard = :idcard  WHERE user_id = :id');
            $update_stmt->bindParam(':firstname', $firstname);
            $update_stmt->bindParam(":lastname", $lastname);
            $update_stmt->bindParam(":email", $email);
            //$update_stmt->bindParam(":avatar", $newname);
           /*  $update_stmt->bindParam(":role_id", $role);
            $update_stmt->bindParam(":status_user", $switch); */
            $update_stmt->bindParam(":tel", $phone);
            $update_stmt->bindParam(":line_token", $tokenline);
            $update_stmt->bindParam(":idcard", $idcard);
            $update_stmt->bindParam(':id', $userid);
            $update_stmt->execute();

            $_SESSION['success'] = "เเก้ไขเรียบร้อยแล้ว";
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'เเก้ไขเรียบร้อยแล้ว!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: true
                        }).then(() => {
                            document.location.href = 'index.php';
                        })
                    });
                </script>";
            //$url_return ="location:edituser_page.php?update_id=".$userid."";    

        }else if($file['name'] != "" AND !isset($_SESSION['error'])){  
            $update_stmt = $db->prepare('UPDATE user SET firstname = :firstname ,lastname = :lastname ,email =:email ,avatar = :avatar, tel = :tel ,line_token = :line_token ,idcard = :idcard WHERE user_id = :id');
            $update_stmt->bindParam(':firstname', $firstname);
            $update_stmt->bindParam(":lastname", $lastname);
            $update_stmt->bindParam(":email", $email);
            $update_stmt->bindParam(":avatar", $newname);
           /*  $update_stmt->bindParam(":role_id", $role);
            $update_stmt->bindParam(":status_user", $switch); */
            $update_stmt->bindParam(":tel", $phone);
            $update_stmt->bindParam(":line_token", $tokenline);
            $update_stmt->bindParam(":idcard", $idcard);
            $update_stmt->bindParam(':id', $userid);
            $update_stmt->execute();

            $_SESSION['success'] = "เเก้ไขเรียบร้อยแล้ว";
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'เเก้ไขเรียบร้อยแล้ว!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: true
                }).then(() => {
                    document.location.href = 'user_list.php';
                })
            });
        </script>";
            $url_return ="location:user_list.php";    
        }
    }
    else if($_POST['proc'] == 'login'){
       

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email)) {
            $_SESSION['error'] = '<center>กรุณากรอกอีเมล</center>';
            $url_return ="location:sign-in.php";   
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = '<center>แบบอีเมลไม่ถูกต้อง</center>';
            $url_return ="location:sign-in.php";   
        } else if (empty($password)) {
            $_SESSION['error'] = '<center>กรุณากรอกรหัสผ่าน</center>';
            $url_return ="location:sign-in.php";    
        } else {
                $check_data = $db->prepare("SELECT * FROM user WHERE email = :uemail");
                $check_data->bindParam(":uemail", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                //print_r ($row);
                if ($check_data->rowCount() > 0) {
                    if ($email == $row['email'] ){
                        if ($row['status_user'] == 1 ){
                            if(password_verify($password ,$row['password'])){
                                if($password == $row['tel']){
                                    $_SESSION['user_login'] = $row['user_id'];
                                    $_SESSION['error'] = '<center>กรุณาตั้งค่ารหัสผ่านใหม่</center>';
                                    $url_return ="location:editnewpass.php";
                                }else{
                                    $_SESSION['user_login'] = $row['user_id'];
                                    $url_return ="location:index.php";

                                }   
                            }else{
                                $_SESSION['error'] = '<center>รหัสผ่านผิด</center>';
                                $url_return ="location:sign-in.php";
                            }   
                        }else{
                            $_SESSION['error'] = '<center>สถานะของคุณยังไม่เปิดใช้งาน</center>';
                            $url_return ="location:sign-in.php";
                        }
                    }else{
                            $_SESSION['error'] = '<center>อีเมลผิด</center>';
                            $url_return ="location:sign-in.php";
                    }  
                }else{
                    $_SESSION['error'] = "<center>ไม่มีข้อมูลในระบบ</center>";
                    $url_return ="location:sign-in.php";
                }  

        }
    }
    else if($_POST['proc'] == 'editpass'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_c = $_POST['password_c'];
        $userid = $_POST['userid'];

        $datauser = $db->prepare("SELECT email FROM user WHERE email = :uemail");
        $datauser->bindParam(":uemail", $email);
        $datauser->execute();
        $datauserrow = $datauser->fetch(PDO::FETCH_ASSOC);

        if(empty($password)){
            $_SESSION['error'] = '<center>กรุณากรอกอีเมล</center>';
            $url_return ="location:editnewpass.php";
        }else if ($email != $datauserrow['email'] ){
            $_SESSION['error'] = '<center>อีเมลไม่มีในระบบ</center>';
            $url_return ="location:editnewpass.php";
        }else if(empty($password)){
            $_SESSION['error'] = '<center>กรุณากรอกรหัสผ่าน</center>';
            $url_return ="location:editnewpass.php";
        } else if (preg_match('/[\p{Thai}]/u', $password)){
            $_SESSION['error'] = 'รหัสผ่านมีตัวอักษรภาษาไทย';
            $url_return ="location:editnewpass.php";
        }else if($password != $password_c){
            $_SESSION['error'] = '<center>Password ที่คุณใส่ไม่ตรงกัน</center>';
            $url_return ="location:editnewpass.php";
        }else{
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $update_datauser = $db->prepare("UPDATE user SET password = :password WHERE email = :uemail");
            $update_datauser->bindParam(":uemail",$email);
            $update_datauser->bindParam(":password",$passwordHash);
            $update_datauser->execute();

            $_SESSION['success'] = 'เเก้ไข Password ของคุณเเล้ว ';
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'เเก้ไข Password ของคุณเเล้ว!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: true
                        }).then(() => {
                            document.location.href = 'index.php';
                        })
                    });
                </script>";
            $url_return ="location:index.php";
        }
            
    }
    else if($_POST['proc'] == 'editpassuser'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_c = $_POST['password_c'];
        $userid = $_POST['userid'];

        $datauser = $db->prepare("SELECT email FROM user WHERE email = :uemail");
        $datauser->bindParam(":uemail", $email);
        $datauser->execute();
        $datauserrow = $datauser->fetch(PDO::FETCH_ASSOC);

        if(empty($password)){
            $_SESSION['error'] = '<center>กรุณากรอกอีเมล</center>';
            $url_return ="location:editnewpassuser.php";
        }else if ($email != $datauserrow['email'] ){
            $_SESSION['error'] = '<center>อีเมลไม่มีในระบบ</center>';
            $url_return ="location:editnewpassuser.php";
        }else if(empty($password)){
            $_SESSION['error'] = '<center>กรุณากรอกรหัสผ่าน</center>';
            $url_return ="location:editnewpassuser.php";
        }else if (preg_match('/[\p{Thai}]/u', $password)){
            $_SESSION['error'] = 'รหัสผ่านมีตัวอักษรภาษาไทย';
            $url_return ="location:editnewpassuser.php";
        }else if($password != $password_c){
            $_SESSION['error'] = '<center>Password ที่คุณใส่ไม่ตรงกัน</center>';
            $url_return ="location:editnewpassuser.php";
        }else{
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $update_datauser = $db->prepare("UPDATE user SET password = :password WHERE email = :uemail");
            $update_datauser->bindParam(":uemail",$email);
            $update_datauser->bindParam(":password",$passwordHash);
            $update_datauser->execute();

            $_SESSION['success'] = 'เเก้ไข Password ของคุณเเล้ว ';
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'เเก้ไข Password ของคุณเเล้ว!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: true
                }).then(() => {
                    document.location.href = 'index.php';
                })
            });
        </script>";
            $url_return ="location:index.php";
        }
            
    }
    else if($_POST['proc'] == 'resetpass'){

        $userid = $_POST['user_id'];

        $datauser = $db->prepare("SELECT tel from user where user_id = :userid");
        $datauser->bindParam(":userid", $userid);
        $datauser->execute();
        $datauserrow = $datauser->fetch(PDO::FETCH_ASSOC);

        $password = $datauserrow['tel'];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $updatauserdata = $db->prepare("UPDATE user SET password =:password where user_id = :userid");
        $updatauserdata->bindParam(":password", $passwordHash);
        $updatauserdata->bindParam(":userid", $userid);
        $updatauserdata->execute();

        $_SESSION['success'] = 'reset Password สมาชิกท่านนี้เเล้ว ';
        //$url_return ="location:user_list.php";

    }
    else if($_POST['proc'] == 'deluserbtn'){

        $user_id=$_POST['user_id'];

        $select_stmt = $db->prepare('SELECT * FROM user WHERE user_id = :id');
        $select_stmt->bindParam(':id', $user_id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        unlink("img/avatars/".$row['avatar']); 

        
        $delete_stmt = $db->prepare('DELETE FROM user WHERE user_id = :id');
        $delete_stmt->bindParam(':id', $user_id);
        $delete_stmt->execute();
        $_SESSION['success'] = "ลบสมาชิกเรียบร้อยเเล้ว";
        header("Location: user_list.php");

    }
    else if($_POST['proc'] == 'addjob'){
        
        $namejob = $_POST['namejob'];
        $status = 1;
        if (empty($namejob)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อประเภทงาน';
            $url_return ="location: addjobtype.php";
        }else if (!isset($_SESSION['error'])) {
            $stmtjob = $db->prepare("INSERT INTO job_type(name_jobtype,status) 
                                VALUES(:namejob, :status)");
            $stmtjob->bindParam(":namejob", $namejob);
            $stmtjob->bindParam(":status", $status);
            $stmtjob->execute();
            $_SESSION['success'] = "เพิ่มประเภทงานเรียบร้อยเเล้ว! ";
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'เพิ่มประเภทงานเรียบร้อยเเล้ว!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: true
                        }).then(() => {
                            document.location.href = 'jobtype_list.php';
                        })
                    });
                </script>";
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            $url_return ="location: jobtype_list.php";
        } 
    }
    else if($_POST['proc'] == 'editjob'){

        $namejob = $_POST['namejob'];
        $id_jobtype = $_POST['id_jobtype'];
        $status = 1;
    
        if (empty($namejob)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อประเภทงาน';
            $url_return ="location: addjobtype.php";
    
        }else if (!isset($_SESSION['error'])) {
            $update_stmtjob = $db->prepare('UPDATE job_type SET name_jobtype = :namejob WHERE id_jobtype = :id');
            $update_stmtjob->bindParam(':namejob', $namejob);
            $update_stmtjob->bindParam(':id', $id_jobtype);
            $update_stmtjob->execute();
            $_SESSION['success'] = "เเก้ไขเประเภทงานเรียบร้อย! ";
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'เเก้ไขเประเภทงานเรียบร้อย!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: true
                }).then(() => {
                    document.location.href = 'jobtype_list.php';
                })
            });
        </script>";
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            $url_return ="location: jobtype_list.php";
        } 
    }
    else if($_POST['proc'] == 'deljob'){

        $status = 2;
        $id_jobtype=$_POST['id_jobtype'];

            if(isset($id_jobtype)){
            $delete_stmtjob = $db->prepare('UPDATE job_type SET status = :status WHERE id_jobtype = :id');
            $delete_stmtjob->bindParam(':status', $status);
            $delete_stmtjob->bindParam(':id', $id_jobtype);
            $delete_stmtjob->execute();
            $_SESSION['success'] = "ลบประเภทงานเรียบร้อยแล้ว! ";
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'ลบประเภทงานเรียบร้อยแล้ว!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: true
                }).then(() => {
                    document.location.href = 'jobtype_list.php';
                })
            });
        </script>";
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            header("location: jobtype_list.php");
        } 
    }
        header($url_return);

    
?>
