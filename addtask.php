<?php

session_start();
require_once 'connect.php';
if(isset($_POST['addtask_btn'])){
 

      $stat = 1 ;
      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
      $taskname =$_POST['taskname'];
      $user=$_POST['user'];
      $textarea=$_POST['textarea'];
      $pro_id= $_POST['pro_id'];
      $file_task = null;
      /* echo $start_date." ".$end_date." ".$taskname." ".$user." ".$textarea." ".$pro_id." ".$file_task." ". $stat;
      exit; */
    
     if (empty($taskname)) {
        $_SESSION['error'] = 'กรุณากรอกชื่องาน';
        header('location:view_project.php?view_id='.$pro_id);

     }else if (!isset($_SESSION['error'])) {
 
      $stmttask = $db->prepare("INSERT INTO task_list(name_tasklist, description_task,status_task, strat_date_task,end_date_task,file_task,project_id,user_id) 
      VALUES(:taskname,:textarea,:status,:start_date,:end_date,:file_task,:pro_id,:users_id)");
       $stmttask->bindParam(":taskname", $taskname);
       $stmttask->bindParam(":textarea", $textarea);
       $stmttask->bindParam(":status", $stat);
       $stmttask->bindParam(":start_date", $start_date);
       $stmttask->bindParam(":end_date", $end_date);
       $stmttask->bindParam(":file_task",$file_task);
       $stmttask->bindParam(":pro_id", $pro_id);
       $stmttask->bindParam(":users_id",$user );
       $stmttask->execute();   
       
     $_SESSION['success'] = "เพิ่มงานเรียบร้อย! ";
     header('location:view_project.php?view_id='.$pro_id);
  
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด";
        header('location:view_project.php?view_id='.$pro_id);
    
    } 
}
    ?>