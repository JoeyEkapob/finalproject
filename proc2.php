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

    
}
else if($_POST['proc'] == 'searchreportuser'){

    $item_arr['result'] = array();

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $role = $_POST["role"];
    $startdate =  $_POST["startdate"];
    $enddate = $_POST["enddate"];


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

        $sql2 = "SELECT manager_id FROM project WHERE manager_id =  '$user_id'";
        $sql3 = "SELECT user_id FROM project_list as pl left join project as p ON pl.project_id  =  p.project_id where user_id = '$user_id'";
        $sql4 = "SELECT user_id FROM task_list where user_id = '$user_id' ";
    $sql5 = "SELECT * FROM details as d  left join task_list as t ON d.task_id = t.task_id  where user_id = '$user_id'  AND send_status ='2'";
        $sql6 = "SELECT * FROM task_list  where user_id = '$user_id ' AND status_timetask = '2'";  
        if (!empty($startdate)) {
            $sql2 .= "AND start_date >= '$startdate' ";
            $sql3 .= "AND start_date >= '$startdate' ";
            $sql4 .= "AND strat_date_task >= '$startdate' ";
            $sql5 .= "AND t.strat_date_task >= '$startdate' ";
            $sql6 .= "AND strat_date_task >= '$startdate' ";
        }
        if (!empty($enddate)) {
            $sql2 .= "AND end_date <= '$enddate' ";
            $sql3 .= "AND end_date <= '$enddate' ";
            $sql4 .= "AND end_date_task <= '$enddate' ";
          /*   $sql5 .= "AND end_date_task <= '$enddate' ";
            $sql6 .= "AND end_date_task <= '$enddate' ";  */
        }
       
        $sql2 = $db->query($sql2); 
        $nummannagerpro = $sql2->rowCount(); 
        $sql3 = $db->query($sql3); 
        $numuserpro = $sql3->rowCount(); 
        $sql4 = $db->query($sql4); 
        $numusertask = $sql4->rowCount(); 
        $sql5 = $db->query($sql5); 
        $numdetails= $sql5->rowCount(); 
        $sql6 = $db->query($sql6); 
        $numdela = $sql6->rowCount();   

        /* echo  $nummannagerpro.$numuserpro. $numusertask.  $numdetails. $numdela; */
        /* $sql2 = $db->query("SELECT manager_id FROM project WHERE manager_id =  $user_id");
        $nummannagerpro = $sql2->rowCount(); 
        $sql3 = $db->query("SELECT user_id FROM project_list where user_id = $user_id");
        $numuserpro = $sql3->rowCount(); 
        $sql4 = $db->query("SELECT user_id FROM task_list where user_id = $user_id ");
        $numusertask = $sql4->rowCount(); 
        $sql5 = $db->query("SELECT * FROM details as d  left join task_list as t ON d.task_id = t.task_id  where user_id = $user_id  AND send_status = 2");
        $numdetails= $sql5->rowCount(); 
        $sql6 = $db->query("SELECT * FROM task_list  where user_id = $user_id  AND status_timetask = 2");
        $numdela = $sql6->rowCount();   */

        array_push($row, $nummannagerpro  ,$numuserpro,$numusertask , $numdetails,$numdela  );
        $row['nummannagerpro'] =  $row['0']; 
        $row['numuserpro'] =  $row['1']; 
        $row['numusertask'] =  $row['2']; 
       $row['numdetails'] =  $row['3']; 
        $row['numdela'] =  $row['4'];   
        unset($row['0'] ,$row['1'],$row['2'] ,$row['3'],$row['4']);
    


        array_push($item_arr['result'], $row);    
         //print_r($item_arr['result']); 
     }
      echo json_encode($item_arr);
        http_response_code(200);  
    

    }else{
        echo json_encode($item_arr);
    }
}

else if($_POST['proc'] == 'closeproject'){

    $status = 3;
    $project_id=$_POST['project_id'];


        if(isset($project_id)){
        $updatestatuspro = $db->prepare('UPDATE project SET status_1 = :status WHERE project_id = :project_id');
        $updatestatuspro->bindParam(':status', $status);
        $updatestatuspro->bindParam(':project_id', $project_id);
        $updatestatuspro->execute();

       $_SESSION['success'] = "ปิดหัวข้องานเรียบร้อยแล้ว! ";
      /*   echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'ปิดหัวข้องานเรียบร้อยแล้ว!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: true
                        }).then(() => {
                            document.location.href = 'editproject_page.php?update_id=$project_id';
                        })
                    });
            </script>";  */
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: editproject_page.php?update_id=$project_id");
    } 
}

 else if($_POST['proc'] == 'openproject'){ 

    
   $status = 1;
    $project_id = $_POST['project_id'];

    $chkproject = "SELECT end_date FROM project WHERE project_id = $project_id ";
    $chkproject = $db->query($chkproject);
    $chkprojectrow = $chkproject->fetch(PDO::FETCH_ASSOC);

    if (strtotime($chkprojectrow['end_date']) < strtotime($date)) {
        $_SESSION['error'] = "เวลาของหัวข้อนี้ได้หมดลงเเล้วไม่สามารถเปิดหัวข้องานเเล้ว";
        echo 1;
       /*  header("location: editproject_page.php?update_id=$project_id"); */
    } 
    else if(!isset($_SESSION['error'])){
        $updatestatuspro = $db->prepare('UPDATE project SET status_1 = :status WHERE project_id = :project_id');
        $updatestatuspro->bindParam(':status', $status);
        $updatestatuspro->bindParam(':project_id', $project_id);
        $updatestatuspro->execute();

        $_SESSION['success'] = "เปิดหัวข้องานเรียบร้อยแล้ว! ";
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: editproject_page.php?update_id=$project_id");
        exit; // จบการทำงาน
    } 
 } 

    ?>