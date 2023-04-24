<?php
 session_start();
 require_once 'connect.php';
 include "funtion.php";
 include 'notify.php';
 date_default_timezone_set('asia/bangkok');
 $date = date('Y-m-d');
 $url_return = "";
 $user_id=$_SESSION['user_login'];
    if($_POST['proc'] == 'searchreport'){

        $item_arr['result'] = array();

        $nameproject = $_POST["nameproject"];
        $job = $_POST["job"];
        $start_date = $_POST["startdate"];
        $end_date = $_POST["enddate"];
        $status1 = $_POST["status1"];
        $status2 = $_POST["status2"];



        $sql = "SELECT * FROM project as p 
        LEFT JOIN job_type as j ON p.id_jobtype = j.id_jobtype 
        LEFT JOIN user as u ON p.manager_id = u.user_id
        WHERE 1=1 ";
        if (!empty($nameproject)) {
            $sql .= "AND name_project LIKE '%$nameproject%' ";
        }
        if (!empty($job)) {
            $sql .= "AND p.id_jobtype = '$job' ";
        }
        if (!empty($start_date)) {
            $sql .= "AND start_date >= '$start_date' ";
        }
        if (!empty($end_date)) {
            $sql .= "AND end_date <= '$end_date' ";
        }
        if (!empty($status1)) {
            $sql .= "AND status_1 = '$status1' ";
        }
        if (!empty($status2)) {
            $sql .= "AND status_2 = '$status2' ";
        }

        // ส่ง query ไปยังฐานข้อมูล
        $stmt = $db->query($sql);
        $stmt->execute();
        $numproject = $stmt->rowCount();
        if ($numproject > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $sql2 = $db->query("SELECT * FROM task_list WHERE project_id =  $project_id ");
            $comptask = $db->query("SELECT * FROM task_list where project_id = $project_id  and status_task = 5");
            $comptask2 = $comptask->rowCount(); 
            $sql2->execute();
            $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
            $numtask = $sql2->rowCount(); 
            array_push($row, $numtask,$comptask2);
            $row['numtask'] =  $row['0']; 
            $row['comptask'] =  $row['1']; 
            unset($row['0'],$row['1']);
           //print_r ($row);



           array_push($item_arr['result'], $row);    
           /*  print_r($item_arr['result']);  */
     

        }

    

         echo json_encode($item_arr);
        http_response_code(200);  
              
        } else {
            echo json_encode($item_arr);
            http_response_code(200);
        }

      
    }else if($_POST['proc'] == 'searchreportuser'){

        $item_arr['result'] = array();

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $role = $_POST["role"];
  

        $sql = "SELECT * FROM user as u
        LEFT JOIN position as p ON p.role_id = u.role_id 
        WHERE 1=1 ";
        if (!empty($firstname)) {
            $sql .= "AND firstname LIKE '%$firstname%' ";
        }
        if (!empty($lastname)) {
            $sql .= "AND lastname LIKE '%$lastname%' ";
        }
        if (!empty($role)) {
            $sql .= "AND u.role_id = '$role' ";
        }
        $stmt = $db->query($sql);
        $stmt->execute();
        $numuser= $stmt->rowCount();
        if ($numuser > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $sql2 = $db->query("SELECT * FROM project WHERE manager_id =  $user_id"); 
            $nummannagerpro = $sql2->rowCount(); 
            $sql3 = $db->query("SELECT * FROM project_list where user_id = $user_id");
            $numuserpro = $sql3->rowCount(); 
            $sql4 = $db->query("SELECT * FROM task_list where user_id = $user_id ");
            $numusertask = $sql4->rowCount(); 
            $sql5 = $db->query("SELECT * FROM details as d  left join task_list as t ON d.task_id = t.task_id  where user_id = $user_id  AND send_status = 2");
            $numdetails= $sql5->rowCount(); 
          array_push($row, $nummannagerpro,$numuserpro,$numusertask, $numdetails);
          $row['nummannagerpro'] =  $row['0']; 
          $row['numuserpro'] =  $row['1']; 
          $row['numusertask'] =  $row['2']; 
          $row['numdetails'] =  $row['3']; 
          unset($row['0'],$row['1'],$row['2'],$row['3']);
      


           array_push($item_arr['result'], $row);    
            /* print_r($item_arr['result']); 
      */ }
            echo json_encode($item_arr);
            http_response_code(200);  
       

    }
}
    ?>