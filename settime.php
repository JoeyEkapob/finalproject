<?php

header('Content-Type: application/json'); 
include 'notify.php';
include 'connect.php';
require_once 'funtion.php';

$current_time = time();
$formatted_time = date('Y-m-d H:i:s', $current_time);
/* echo $current_time .' '.  $formatted_time ; */
 $chktimetask = "SELECT t.task_id, t.end_date_task, u.user_id, u.line_token, p.name_project, t.name_tasklist, p.manager_id,  p.status_1, CONCAT(u2.firstname, ' ', u2.lastname) AS manager_name ,t.status_task ,t.progress_task 
                FROM task_list AS t 
                LEFT JOIN project AS p ON t.project_id = p.project_id 
                LEFT JOIN user AS u ON t.user_id = u.user_id 
                LEFT JOIN user AS u2 ON p.manager_id = u2.user_id
                WHERE TIMESTAMPDIFF(HOUR, NOW(), end_date_task) <= 24 AND status_timetask = 0  AND status_task2 != 1 AND  t.status_task != 5 AND t.progress_task != 100   AND p.status_1 != 3 ";
    $chktimetask = $db->query($chktimetask);
    $chktimetask->execute();  
    while ($row2 = $chktimetask->fetch(PDO::FETCH_ASSOC)){

       /*  print_r($row2);  */
    $task_id = $row2['task_id'];
        $update_stmt = $db->prepare("UPDATE task_list SET status_timetask = 1 WHERE task_id = :task_id");
        $update_stmt->bindParam(':task_id', $task_id);
        $update_stmt->execute();

       $sToken = $row2['line_token'];
       $sMessage = "ใกล้ถึงวันที่สิ้นสุดการส่งงานของท่านแล้ว \n";
       $sMessage .= "ชื่อห้วงาน : ".$row2['name_project']." \n";
       $sMessage .= "ชื่องาน : ".$row2['name_tasklist']." \n";
       $sMessage .= "วันที่สิ้นสุด : ".thai_date_and_time_short($row2['end_date_task'])." \n";
       $sMessage .= "คนที่สั่งงาน : ".$row2['manager_name']." \n";
   
       sentNotify($sToken , $sMessage); 

    }  
    
    $chktimetaskend ="UPDATE task_list as t 
    LEFT JOIN project as p on t.project_id = p.project_id
    SET status_timetask = 2 
    WHERE end_date_task < NOW() 
    AND status_timetask != 2 
    AND status_task2 != 1
    AND status_task != 5 
    AND progress_task != 100 
    AND p.status_1 != 3 " ;
    $chktimetaskend = $db->query($chktimetaskend);
    $chktimetaskend->execute();  
  

  



/* $l_token = "";
$l_msg = 'Hello from PHP!' . "\n" . 'Sent From: ' . $formatted_time;

if($res = sentNotify($l_token, $l_msg)){
    $data = array(
        'status' => 1,
        'msg' => 'Line Notify Sent Successful!',
    );
    http_response_code(200);
    echo json_encode($data);
} else {
    $data = array(
        'status' => 0,
        'msg' => 'Line Notify Sent Not Successful!',
    );
    http_response_code(401);
    echo json_encode($data);
} */
