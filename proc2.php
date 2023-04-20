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
            array_push($item_arr['result'], $row);
        }

    

        echo json_encode($item_arr);
        http_response_code(200);
             
        } else {
            echo json_encode($item_arr);
            http_response_code(200);
        }

      
    }
    ?>