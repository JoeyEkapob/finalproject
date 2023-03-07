<?php

    session_start();
    require_once 'connect.php';
    date_default_timezone_set('asia/bangkok');
    $date = date('Y-m-d');
    $url_return = "";
    if($_POST['proc'] == 'add_task'){

        $pro_id= $_POST['pro_id'];
        $sql = "SELECT * FROM project  where project_id = $pro_id";
        $qry = $db->query($sql);
        $qry->execute();
        $row2 = $qry->fetch(PDO::FETCH_ASSOC);
        
         $datestartproject = $row2['start_date'];
         $dateendproject = $row2['end_date'];
     
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
        foreach ($files['name'] as $i => $file_name) {
        $file_tmp = $files['tmp_name'][$i];
        $file_dest = $file_name; 
        $file_data = "img/file/file_task/";
        move_uploaded_file($file_tmp,$file_data.$file_dest);
        }

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
          
        } else if(!isset($_SESSION['error'])) {
            $stmttask = $db->prepare("INSERT INTO task_list(task_id,name_tasklist, description_task,status_task, strat_date_task,end_date_task,project_id,user_id) 
            VALUES(:task_id,:taskname,:textarea,:status,:start_date,:end_date,:pro_id,:users_id)");
            $stmttask->bindParam(":task_id", $nextId);
            $stmttask->bindParam(":taskname", $taskname);
            $stmttask->bindParam(":textarea", $textarea);
            $stmttask->bindParam(":status", $stat);
            $stmttask->bindParam(":start_date", $start_date);
            $stmttask->bindParam(":end_date", $end_date);
            // $stmttask->bindParam(":file_task",$file_task);
            $stmttask->bindParam(":pro_id", $pro_id);
            $stmttask->bindParam(":users_id",$user );
            $stmttask->execute();   
            //$lastId = $db->lastInsertId(); 
                if (!empty(array_filter($_FILES['files']['name']))) {
                foreach($files['name'] as $id => $filename_task){
                $inserfile_item_task = $db->prepare("INSERT INTO file_item_task(task_id,filename_task,project_id) 
                VALUES(:task_id,:filename_task,:project_id)");
                $inserfile_item_task->bindParam(":task_id",$nextId);
                $inserfile_item_task->bindParam(":project_id",$pro_id);
                $inserfile_item_task->bindParam(":filename_task",$filename_task);
                $inserfile_item_task->execute(); 
                }
            }
            $_SESSION['success'] = "เพิ่มงานเรียบร้อย! ";
            $url_return = "location:view_project.php?view_id=".$pro_id;


        }else{
            $_SESSION['error']= "มีบางอย่างผิดพลาด";
            $url_return ="location:addproject_page.php";
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
                unlink($file_path_task.$row2['filename_task']); 
            }

        
            if(isset($taskid)){

                $delete_task = $db->prepare('DELETE FROM file_item_task WHERE task_id = :id');
                $delete_task->bindParam(':id', $taskid);
                $delete_task->execute();

                $delete_task_list = $db->prepare('DELETE FROM task_list WHERE task_id = :id');
                $delete_task_list->bindParam(':id', $taskid);
                $delete_task_list->execute();     

                $_SESSION['success'] = "ลบงานเรียบร้อยแล้ว!";
                $url_return = "location:view_project.php?view_id=".$pro_id;

            } else {

                $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                $url_return = "location:view_project.php?view_id=".$pro_id;
            }         
    }
    else if($_POST['proc'] == 'show'){
            echo "ttttttttttttttttttttttttttttttt";
            exit;
    }
    else if($_GET['proc'] == 'download'){
        

            $file_item_project = $_GET['file_item_project'];
            $file_item_task = $_GET['file_item_task'];
            $file_item_details = $_GET ['file_item_details'];

            if(isset($file_item_project)){

                $stmt = $db->prepare("SELECT * FROM file_item_project WHERE file_item_project = :file_item_project");
                $stmt->bindParam(":file_item_project", $file_item_project);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $filename = $row['filename'];
                $filepath = "img/file/file_project/".$filename;

            }else if(isset($file_item_task)){

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
            }
           
                header('Content-Disposition: attachment; filename=' . basename($filepath));
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
            unlink($file_path.$row2['filename']); 
        }

        $stmt = $db->prepare("DELETE FROM file_item_project WHERE file_item_project = :file_item_project");
        $stmt->bindParam(":file_item_project", $file_item_project);
        $stmt->execute();

        $_SESSION['success'] = "ลบไฟล์เรียบร้อยแล้ว!";
        $url_return = "location:editproject_page.php?update_id=".$pro_id;
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
            unlink($file_path.$row2['filename_task']); 
        }

        $stmt = $db->prepare("DELETE FROM file_item_task WHERE file_item_task = :file_item_task");
        $stmt->bindParam(":file_item_task", $file_item_task);
        $stmt->execute();

        $_SESSION['success'] = "ลบไฟล์เรียบร้อยแล้ว!";
        $url_return = "location:edittask_page.php?updatetask_id=".$taskid."&project_id=".$pro_id;
    
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
        $textarea=$_POST['textarea'];
        $stat = 1 ;
        $files = $_FILES['files'];
        foreach ($files['name'] as $i => $file_name) {
        $file_tmp = $files['tmp_name'][$i];
        $file_dest = $file_name; 
        $file_data = "img/file/file_task/";
        move_uploaded_file($file_tmp,$file_data.$file_dest);
        }


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

            if(!empty(array_filter($_FILES['files']['name']))) {
            foreach($files['name']  as $id =>$file_name){
            $inserfile_item_task = $db->prepare("INSERT INTO file_item_task(task_id,filename_task,project_id) 
            VALUES(:task_id,:filename_task,:proid)");
            $inserfile_item_task->bindParam(":task_id",$taskid);
            $inserfile_item_task->bindParam(":filename_task",$file_dest);
            $inserfile_item_task->bindParam(":proid",$pro_id );
            $inserfile_item_task->execute(); 
                }
            }
            $_SESSION['success'] = "เพิ่มงานเรียบร้อย! ";
            $url_return = "location:view_project.php?view_id=".$pro_id;
            
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
       $description =$_POST['description'];
       $status2=$_POST['status2'];
       $job = $_POST['job'];
       $users_id1=$_POST['users_id']; // รับค้ามาเป็น arery id เดียว
       //$numbers_string = implode(",", $users_id1); // implode ลูกน้ำเข้าไปเเล้วทำให้เป็น string
       $users_id = explode(",", $users_id1); // เเล้วก็นำ string มาทำเป็น array หลาย id 
       
        $files = $_FILES['files']; 
        foreach ($files['name'] as $i => $file_name) {
        $file_tmp = $files['tmp_name'][$i];
        $file_dest = $file_name; 
        $file_data = "img/file/file_project/";
        move_uploaded_file($file_tmp,$file_data.$file_dest);
       }   
   
     
          if (empty($proname)) {
          $_SESSION['error'] = 'กรุณากรอกชื่อโปรเจค';
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
       }else  if(!isset($_SESSION['error'])) {
           $inserstmtpro = $db->prepare("INSERT INTO project(project_id,name_project, description, status_1,start_date, end_date, manager_id,status_2,id_jobtype) 
                                              VALUES(:project_id,:proname,:description,:status,:start_date,:end_date,:manager_id,:status_2,:id_job)");
           $inserstmtpro->bindParam(":project_id",$nextId);
           $inserstmtpro->bindParam(":proname", $proname);
           $inserstmtpro->bindParam(":description", $description);
           $inserstmtpro->bindParam(":status", $status1);
           $inserstmtpro->bindParam(":start_date", $start_date);
           $inserstmtpro->bindParam(":end_date", $end_date);
           $inserstmtpro->bindParam(":manager_id", $manager_id);
           $inserstmtpro->bindParam(":status_2", $status2);
           $inserstmtpro->bindParam(":id_job", $job);
           $inserstmtpro->execute(); 
          // $lastId = $db->lastInsertId();
        
            foreach ($users_id as $id => $users_id){
             $inserstmtprolist= $db->prepare("INSERT INTO project_list(project_id,user_id) VALUES(:project_id,:user_id)");
             $inserstmtprolist->bindParam(":project_id", $nextId);
             $inserstmtprolist->bindParam(":user_id", $users_id);
             $inserstmtprolist->execute(); 
            }

            foreach ($files['name'] as $id => $filesname){
            $inserfile_item_porject = $db->prepare("INSERT INTO file_item_project(project_id,filename) 
            VALUES(:project_id,:filename)");
            $inserfile_item_porject->bindParam(":project_id",$nextId);
            $inserfile_item_porject->bindParam(":filename",$filesname);
            $inserfile_item_porject->execute();  
       }
             
            $_SESSION['success'] = "เพิ่มโปรเจคเรียบร้อยแล้ว! ";
            $url_return="location:project_list.php"; 
    
        }else {
            $_SESSION['error']= "มีบางอย่างผิดพลาด";
            $url_return ="location:addproject_page.php";
        }   
       
    
        
         
    }      
    else if($_POST['proc'] == 'editpro'){
 
            $proid=$_POST['project_id'];
            $status1 = 1;
            $proname = $_POST['proname'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $description =$_POST['description'];
            $manager_id=$_SESSION['user_login'];
            $status2=$_POST['status2'];
            $file_project = null;
            $job = $_POST['job'];
            $users_id1 = $_POST['users_id'];
            $users_id = explode(",", $users_id1);
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
                $file_tmp = $files['tmp_name'][$i];
                $file_dest = $file_name; 
                $file_data = "img/file/file_project/";
                move_uploaded_file($file_tmp,$file_data.$file_dest);
                
                $inserfile_item_porject = $db->prepare("INSERT INTO file_item_project(project_id,filename) 
                VALUES(:project_id,:filename)");
                $inserfile_item_porject->bindParam(":project_id",$proid);
                $inserfile_item_porject->bindParam(":filename",$file_dest);
                $inserfile_item_porject->execute(); 
                }
            }

                $_SESSION['success'] = "เเก้ไขเรียบร้อย! ";
                $url_return = "location: project_list.php";

    }
    else if($_POST['proc'] == 'deleteproject'){
       
        $project_id= $_POST['project_id'];

       
        if(isset($project_id)){
        $file_path1 = 'img/file/file_project/';
        $file_path2 = 'img/file/file_task/';
        $sql = "SELECT * from project  natural join file_item_project natural join  file_item_task where project_id = $project_id ";
        $qry = $db->query($sql);
        $qry->execute();
        while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)){  
            unlink($file_path1.$row2['filename']); 
            unlink($file_path2.$row2['filename_task']); 
        }  
        $delete_taskitem = $db->prepare('DELETE  FROM file_item_task  WHERE project_id=:id');
        $delete_taskitem->bindParam(':id', $project_id);
        $delete_taskitem->execute(); 

        $delete_tasklist = $db->prepare('DELETE  FROM task_list  WHERE project_id=:id');
        $delete_tasklist->bindParam(':id', $project_id);
        $delete_tasklist->execute(); 

        $delete_task = $db->prepare('DELETE project_list,file_item_project,project FROM project_list natural join file_item_project natural join project WHERE project_id=:id');
        $delete_task->bindParam(':id', $project_id);
        $delete_task->execute();  
        
        $_SESSION['success'] = "ลบหัวข้องานเรียบร้อยแล้ว!";
        header('location:project_list.php');
        
        } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header('location:project_list.php');
        } 
    }
    else if($_POST['proc'] == 'sendtask'){
       
        $project_id= $_POST['project_id'];
        $taskid = $_POST['task_id'];
        $commenttask = $_POST['text_comment'];
        $senddate = $_POST['senddate'];
        $state_details = $_POST['state_details'];
        $status_task = "3";

        $files = $_FILES['files']; 

        foreach ($files['name'] as $i => $file_name) {
        $file_tmp = $files['tmp_name'][$i];
        $file_dest = $file_name; 
        $file_data = "img/file/file_details/";
        move_uploaded_file($file_tmp,$file_data.$file_dest);
       }   

        $inserstmtdetails = $db->prepare("INSERT INTO details(project_id,task_id,comment,date_detalis,state_details) 
                                              VALUES(:project_id,:task_id,:comment,:date_detalis,:state_details)");
        $inserstmtdetails->bindParam(":project_id",$project_id);
        $inserstmtdetails->bindParam(":task_id", $taskid);
        $inserstmtdetails->bindParam(":comment", $commenttask);
        $inserstmtdetails->bindParam(":state_details", $state_details);
        $inserstmtdetails->bindParam(":date_detalis",$senddate);
        $inserstmtdetails->execute(); 
        $lastId = $db->lastInsertId(); 

        $updatestattask = $db->prepare("UPDATE task_list SET status_task = :status_task WHERE task_id = :task_id");
        $updatestattask->bindParam(":status_task",$status_task);
        $updatestattask->bindParam(":task_id",$taskid);
        $updatestattask->execute(); 

        foreach ($files['name'] as $id => $filesname){
        $inserfile_item_details = $db->prepare("INSERT INTO file_item_details(project_id,task_id,filename_details,details_id) 
        VALUES(:project_id,:task_id,:filename_details,:details_id)");
        $inserfile_item_details->bindParam(":project_id",$project_id);
        $inserfile_item_details->bindParam(":task_id",$taskid);
        $inserfile_item_details->bindParam(":filename_details",$filesname);
        $inserfile_item_details->bindParam(":details_id",$lastId);
        $inserfile_item_details->execute();  
       }

      

           $_SESSION['success'] = "ส่งงานเรียบร้อยแล้ว! ";
           $url_return ="location:view_project.php?view_id=".$project_id;
        
      
       
      
    }
    else if($_POST['proc'] == 'deldetails'){
        echo "ไม่เข้า";
        exit;
    }   
    else if($_POST['proc'] == 'checktasksuccess'){

        $details_id = $_POST['details_id'];
        $task_id = $_POST['task_id'];
        $project_id = $_POST['project_id'];
        $statdetails= "N";
        $tasksuccess = 100;
        $status_task ="6";

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
        $url_return ="location:checktask_list.php";
     
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
        $status_task = "4";
        $files = $_FILES['files']; 
        
        foreach ($files['name'] as $i => $file_name) {
        $file_tmp = $files['tmp_name'][$i];
        $file_dest = $file_name; 
        $file_data = "img/file/file_details/";
        move_uploaded_file($file_tmp,$file_data.$file_dest);
        }   
     
        $updatestatdetails = $db->prepare("UPDATE details SET state_details = :state_details ,progress_details = :progress WHERE details_id = :details_id");
        $updatestatdetails->bindParam(":state_details",$state_details);
        $updatestatdetails->bindParam(":progress",$progress_task);
        $updatestatdetails->bindParam(":details_id",$details_id);
        $updatestatdetails->execute(); 
 
        $inserstmtdetails = $db->prepare("INSERT INTO details(project_id,task_id,comment,date_detalis,state_details,progress_details) 
        VALUES(:project_id,:task_id,:comment,:date_detalis,:state_details,:progress)");
        $inserstmtdetails->bindParam(":project_id",$project_id);
        $inserstmtdetails->bindParam(":task_id", $task_id);
        $inserstmtdetails->bindParam(":comment", $commenttask);
        $inserstmtdetails->bindParam(":date_detalis",$senddate);
        $inserstmtdetails->bindParam(":state_details",$state_details);
        $inserstmtdetails->bindParam(":progress",$progress);
        $inserstmtdetails->execute();
        $lastId = $db->lastInsertId(); 

      
        $updatestattask = $db->prepare("UPDATE task_list SET status_task = :status_task ,progress_task = :progress WHERE task_id = :task_id");
        $updatestattask->bindParam(":status_task",$status_task);
        $updatestattask->bindParam(":progress",$progress);
        $updatestattask->bindParam(":task_id",$task_id);
        $updatestattask->execute(); 

       
        /* foreach ($files['name'] as $id => $filesname){
        $inserfile_item_details = $db->prepare("INSERT INTO file_item_details(project_id,task_id,filename_details,details_id) 
        VALUES(:project_id,:task_id,:filename_details,:details_id)");
        $inserfile_item_details->bindParam(":project_id",$project_id);
        $inserfile_item_details->bindParam(":task_id",$task_id);
        $inserfile_item_details->bindParam(":filename_details",$filesname);
        $inserfile_item_details->bindParam(":details_id",$lastId);
        $inserfile_item_details->execute();  
        } */

        $_SESSION['success'] = "ส่งงานกลับเเก้ไขเรียบร้อยแล้ว!!! ";
        $url_return ="location:checktask_list.php";

    }
    echo "ไม่เข้าไอ้โง่";
    
        header($url_return);

?>  