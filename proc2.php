<?php
 session_start();
 require_once 'connect.php';
 include "funtion.php";
 include 'notify.php';
 date_default_timezone_set('asia/bangkok');
 $date = date('Y-m-d');
 $url_return = "";
 $user_id=$_SESSION['user_login'];

    $levelsql = "SELECT MAX(level) as maxlevel , MIN(level) as minlevel FROM  position WHERE position_status = 1 ";
    $stmt2 = $db->prepare($levelsql);
    $stmt2->execute();
    $levelsqlrow = $stmt2->fetch(PDO::FETCH_ASSOC);
    $maxlevel = $levelsqlrow['maxlevel'];
    $minlevel = $levelsqlrow['minlevel'];

    $nameuser ="SELECT concat(firstname,' ',lastname) as name , u.role_id ,u.user_id  ,p.role_id , p.level ,d.department_id From user as u 
    left join position as p on u.role_id = p.role_id 
    left join department as d on d.department_id = u.department_id 
    WHERE user_id = $user_id";
    $nameuser = $db->query($nameuser);
    $nameuser->execute();  
    $nameuser = $nameuser->fetch(PDO::FETCH_ASSOC);
  
    $level = $nameuser['level'];
  /*   echo $level. ' '. $maxlevel; */
    $department =$nameuser['department_id'];
    $role =$nameuser['role_id'];
    $roleuser =$nameuser['role_id'];

if($_POST['proc'] == 'searchreport'){

    $item_arr['result'] = array();

    $nameproject = $_POST["nameproject"];
    $job = $_POST["job"];
    $start_date = $_POST["startdate"];
    $end_date = $_POST["enddate"];
    $status1 = $_POST["status1"];
    $status2 = $_POST["status2"];
   /*  $role = $_POST["role"]; */
    $jobtype = $_POST["jobtype"];
  /*   echo  $jobtype;
    exit;  */
    if(isset($_POST["department"])){
        $department = $_POST["department"];
    }
    if(isset($_POST["role"])){
        $role = $_POST["role"];
    }
   
    /*     echo $role;
    exit; */
    /* AND p.manager_id = $user_id */ 
    if($jobtype == 1){
        $sql = "SELECT * FROM project as p 
        LEFT JOIN job_type as j ON p.id_jobtype = j.id_jobtype 
        LEFT JOIN user as u ON p.manager_id = u.user_id
        LEFT JOIN position as po ON po.role_id  = u.role_id
        LEFT JOIN department as d ON d.department_id  = u.department_id
        WHERE 1=1 ";
        if ($level > 2) {
            $sql .= "AND $level <= po.level AND d.department_id = $department "; 
        } 
        if(!empty($department)){
            $sql .= "AND d.department_id = $department ";
        }
        if(!empty($role)){
            $sql .= "AND po.role_id = $role ";
        }
        
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

    }elseif($jobtype == 2){
        /* SELECT pl.* ,p.* ,j.* ,u.*,po.*,d.* ,u2.firstname as firstname2  ,u2.lastname as lastname2 ,u2.shortname_id as name  FROM project_list as pl
        LEFT JOIN project as p ON pl.project_id = p.project_id 
        LEFT JOIN job_type as j ON p.id_jobtype = j.id_jobtype 
        LEFT JOIN user as u ON pl.user_id = u.user_id
        LEFT JOIN user as u2 ON p.manager_id = u.user_id
        LEFT JOIN position as po ON po.role_id  = u.role_id
        LEFT JOIN department as d ON d.department_id  = u.department_id
        WHERE 1=1  */
   
        $sql = "SELECT DISTINCT pl.project_id, pl.user_id, p.project_id, p.name_project, p.description, p.status_1, p.create_project, p.start_date, p.end_date, p.manager_id, p.status_2, p.id_jobtype, p.progress_project, j.id_jobtype, j.name_jobtype, j.status, u.user_id, u.role_id, u.department_id, u2.firstname, u2.lastname, u2.shortname_id, po.role_id, po.position_name, po.level, po.position_status, d.department_id, d.department_name, d.department_status
        FROM project_list AS pl
        LEFT JOIN project AS p ON pl.project_id = p.project_id 
        LEFT JOIN job_type AS j ON p.id_jobtype = j.id_jobtype 
        LEFT JOIN user AS u ON pl.user_id = u.user_id
        LEFT JOIN user AS u2 ON p.manager_id = u2.user_id
        LEFT JOIN position AS po ON po.role_id = u.role_id
        LEFT JOIN department AS d ON d.department_id = u.department_id
        where 1=1 ";
        if ($level > 2) {
            $sql .= "AND $level <= po.level AND d.department_id = $department   ";
        } 
        if(!empty($department)){
            $sql .= "AND d.department_id = $department ";
        }
        if(!empty($role)){
            $sql .= "AND po.role_id = $role ";
        }
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
            $sql .=" GROUP BY pl.project_id, pl.user_id, p.project_id, p.name_project, p.description, p.status_1, p.create_project, p.start_date, p.end_date, p.manager_id, p.status_2, p.id_jobtype, p.progress_project, j.id_jobtype, j.name_jobtype, j.status, u.user_id, u.role_id, u.department_id, u2.firstname, u2.lastname, u2.shortname_id, po.role_id, po.position_name, po.level, po.position_status, d.department_id, d.department_name, d.department_status ORDER BY pl.project_id ASC; ";
        
    }
    /* if($role = $roleuser){
        $sql .= "AND p.manager_id = $user_id ";

    } */
 /*  print_r($sql);
        exit;   */ 
    // ส่ง query ไปยังฐานข้อมูล
    $stmt = $db->query($sql);
    $stmt->execute();
    $numproject = $stmt->rowCount();
    if ($numproject > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       /*  print_r($row);
        exit; */
        extract($row);
      /*   echo $manager_id; */
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
    $startdate =  $_POST["startdate"];
    $enddate = $_POST["enddate"];

    if(isset($_POST["role"])){
    $role = $_POST["role"];
    }
    if(isset($_POST["department"])){
        $department = $_POST["department"];
    }
    $sql = "SELECT * FROM user as u
    LEFT JOIN position as po ON po.role_id = u.role_id 
    LEFT JOIN department as d ON d.department_id = u.department_id 
    WHERE 1=1 ";
     if ($level > 2) {
        $sql .= "AND  $level <= po.level  AND d.department_id = $department ";
        //$sql .= "AND u.user_id = $user_id  OR $level < po.level  AND d.department_id = $department ";
    } 
    if($level == $maxlevel){
        $sql .= " AND u.user_id = $user_id ";
    }
    if(!empty($department)){
        $sql .= " AND d.department_id = $department ";
    }
    if (!empty($firstname)) {
        $sql .= " AND firstname LIKE '%$firstname%' ";
    }
    if (!empty($lastname)) {
        $sql .= " AND lastname LIKE '%$lastname%' ";
    }
     if (!empty($role)) {
        $sql .= " AND u.role_id = '$role' ";
    } 
 /*  print_r($sql);
   exit; */
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
            $sql5 .= "AND end_date_task <= '$enddate' ";
            $sql6 .= "AND end_date_task <= '$enddate' "; 
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
 else if($_POST['proc'] == 'viewdatauser'){

    $user_id = $_POST['userid'];
	$where = "";
    $outp = '';
    $sql = "SELECT  * FROM user as u 
    left join position as p on u.role_id = p.role_id  
    left join department as d on u.department_id = d.department_id  
    where user_id = $user_id";
    $qry = $db->query($sql);
    $qry->execute();
    while($row = $qry->fetch(PDO::FETCH_ASSOC)){ 

       /*  $outp .= ' <div class="card">		
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">';
    
                                        if ($row['avatar'] != "") {
                                            $outp .= '<img class="rounded-circle rounded me-5 mb-2" src="img/avatars/' . $row['avatar'] . '" alt="Avatar" width="200" height="200">';
                                        } else {
                                            $outp .= '<img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="200" height="200">';
                                        }
    
    $outp .= '                      </div>
                                </div>
                <div class="col-md-1"></div> 
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="control-label"><b>ชื่อ :</b></label>
                        ' .showshortname($row['shortname_id']) .' '. $row['firstname'] . ' ' . $row['lastname'] . ' 
                    </div>
                    <div class="mb-3">
                        <label for="" class="control-label"><b>อีเมล :</b></label>
                        ' . $row['email'] . '
                    </div>
                    <div class="mb-3">
                        <label for="" class="control-label"><b>ตำเเหน่ง :</b></label>
                        ' . $row['position_name'] . '
                    </div>
                    <div class="mb-3">
                        <label for="" class="control-label"><b>ฝ่าย :</b></label>
                        ' . $row['department_name'] . '
                    </div>
                </div> 
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="" class="control-label"><b>สถานะ :</b></label>';
                        if ($row['status_user'] == 1) {
                            $outp .= 'เปิดใช้งาน';
                        } else {
                            $outp .= 'ปิดใช้งาน';
                        }
        $outp .= '  </div>
                        <div class="mb-3">
                            <label for="" class="control-label"><b>เบอร์ :</b></label>
                               '.$row['tel'] .'
                        </div>
                        <div class="mb-3">
                            <label for="" class="control-label"><b>เลขบัตรประชาชน :</b></label>
                            '. $row['idcard'] .'
                        </div>
                            
                </div> 
                    <hr>';
                    
                        $outp .= '<div class="col-md-12">';

                         if($level >= 2){
                            $where = "  and  manager_id = $user_id ";
                         } 
                        $sql2 = $db->query("SELECT project_id  FROM project  where  start_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)  $where  "); 
                        $nummannagerpro = $sql2->rowCount(); 
                        //$sql3 = $db->query("SELECT user_id FROM project_list as pl left join project as p on pl.project_id = p.project_id WHERE user_id = $user_id AND start_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)" );
                        if($level >= 2){
                            $where = "   and user_id  = $user_id ";
                         }
                        $sql3 = $db->query("SELECT pl.project_id FROM project_list as pl  left join  project as p on pl.project_id = p.project_id WHERE  status_1 !=3  $where   AND start_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ");
                        $numuserpro = $sql3->rowCount(); 
                        //$sql4 = $db->query("SELECT user_id FROM task_list WHERE user_id = $user_id AND strat_date_task >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ");
                       
                        if($level >= 2){
                            $where = "   and user_id = $user_id    ";
                        }
                        $sql4 = $db->query("SELECT task_id  FROM task_list as t left join project as p on t.project_id = p.project_id WHERE  1=1 $where ");
                        $numusertask = $sql4->rowCount(); 

                        $sql5 = $db->query("SELECT * FROM task_list WHERE user_id = $user_id AND status_task != 5 AND progress_task != 100 AND strat_date_task >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                        $numtaskonp = $sql5->rowCount(); 
                        $sql6 = $db->query("SELECT * FROM task_list WHERE user_id = $user_id AND status_timetask = 2 AND status_task != 5 AND progress_task != 100 AND strat_date_task >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                        $numtimede = $sql6->rowCount();
    $outp .= '                              <div class="containeruser">
                                        <div class="itemuser1">หัวข้องานที่สร้าง</div>
                                        <div class="itemuser1">หัวข้องานที่ถูกสั่ง</div>
                                        <div class="itemuser1">งานทั้งหมด</div>
                                        <div class="itemuser1">งานที่ยังไม่เสร็จ</div>
                                        <div class="itemuser1">งานที่ล่าช้า</div>
                                    </div>
                                    <div class="containeruser">
                                        <div class="itemuser1">'. $nummannagerpro .'</div>
                                        <div class="itemuser1">'. $numuserpro .'</div>
                                        <div class="itemuser1">'. $numusertask .'</div>
                                        <div class="itemuser1">'. $numtaskonp .'</div>
                                        <div class="itemuser1">'. $numtimede .'</div>
                                    </div>
                            </div> 
                        </div>
                    </div>
                </div> '; */
                if($level >= 2){
                    $where = "  and  manager_id = $user_id ";
                 } 
                $sql2 = $db->query("SELECT project_id  FROM project  where  start_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)  $where  "); 
                $nummannagerpro = $sql2->rowCount(); 
                //$sql3 = $db->query("SELECT user_id FROM project_list as pl left join project as p on pl.project_id = p.project_id WHERE user_id = $user_id AND start_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)" );
                if($level >= 2){
                    $where = "   and user_id  = $user_id ";
                 }
                $sql3 = $db->query("SELECT pl.project_id FROM project_list as pl  left join  project as p on pl.project_id = p.project_id WHERE  status_1 !=3  $where   AND start_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ");
                $numuserpro = $sql3->rowCount(); 
                //$sql4 = $db->query("SELECT user_id FROM task_list WHERE user_id = $user_id AND strat_date_task >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ");
               
                if($level >= 2){
                    $where = "   and user_id = $user_id    ";
                }
                $sql4 = $db->query("SELECT task_id  FROM task_list as t left join project as p on t.project_id = p.project_id WHERE  1=1 $where ");
                $numusertask = $sql4->rowCount(); 

                $sql5 = $db->query("SELECT * FROM task_list WHERE user_id = $user_id AND status_task != 5 AND progress_task != 100 AND strat_date_task >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                $numtaskonp = $sql5->rowCount(); 
                $sql6 = $db->query("SELECT * FROM task_list WHERE user_id = $user_id AND status_timetask = 2 AND status_task != 5 AND progress_task != 100 AND strat_date_task >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                $numtimede = $sql6->rowCount();
    $outp .= '<div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-around text-center">
                                <div class="col-md box_amount">
                                    <div class="row">
                                        <div class="col">
                                            <p class="display-2">'.$numtimede.'</p>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col">งานที่ล่าช้า</div>
                                    </div>
                                </div>
                                <div class="col-md box_amount">
                                    <div class="row">
                                        <div class="col">
                                            <p class="display-2">'.$numtaskonp.'</p>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col">งานที่ยังไม่เสร็จ</div>
                                    </div>
                                </div>
                                <div class="col-md box_amount">
                                    <div class="row">
                                        <div class="col">
                                            <p class="display-2">'.$numusertask.'</p>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col">งานทั้งหมด</div>
                                    </div>
                                </div>
                                <div class="col-md box_amount">
                                    <div class="row">
                                        <div class="col">
                                            <p class="display-2">'.$numuserpro.'</p>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col">หัวข้องานที่ถูกสั่ง</div>
                                    </div>
                                </div>
                                <div class="col-md box_amount">
                                    <div class="row">
                                        <div class="col">
                                            <p class="display-2">'.$nummannagerpro.'</p>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col">หัวข้องานที่สร้าง</div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4 py-4 px-4">';
                                if ($row['avatar'] != "") {
                                    $outp .= '<img class="rounded-circle rounded me-2 mb-2" src="img/avatars/' . $row['avatar'] . '" alt="Avatar" width="200" height="200">';
                                } else {
                                    $outp .= '<img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="200" height="200">';
                                }
                                $outp .= ' </div>
                                <div class="col-sm py-3 px-3 d-flex align-items-center">
                                        <h1 class="text-uppercase fs-1 fw-bold"> ' .showshortname($row['shortname_id']) .' '. $row['firstname'] . ' ' . $row['lastname'] . ' </h1>
                                </div>
                            </div>
                                 
                            
                        <!-- ข้อมูลผู้ใช้งาน -->
                        <div class="container py-1">
                            <div class="row">
                                <div class="col-sm my-3">
                                    <div>ตำแหน่ง :   ' . $row['position_name'] . '</div>
                                </div>
                                <div class="col-sm my-3">
                                    <div>ฝ่าย :  ' . $row['department_name'] . '</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm my-3">
                                    <div>อีเมล : '. $row['email'] . '</div>
                                </div>
                                <div class="col-sm my-3">
                                    <div>เบอร์โทร :   '.$row['tel'] .'</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm my-3">
                                    <div>เลขบัตรประชาชน :   '. $row['idcard'] .'</div>
                                </div>
                                <div class="col-sm my-3">
                                    <div>สถานะ :';
                                     if ($row['status_user'] == 1) {
                                        $outp .= 'เปิดใช้งาน';
                                    } else {
                                        $outp .= 'ปิดใช้งาน';
                                    }
                                 $outp .=' </div>
                                </div>
                            </div>
                        </div>
                     </div>
                        <!-- ปุ่ม -->
                        


                    </div>
                </div> ';
    }
    echo $outp;
    exit;
}
else if($_POST['proc'] == 'viewdetails'){
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
                            <dt><b class="border-bottom border-primary">ชื่อโปรเจค</b> '.  showstatustime($row['status_timedetails']) .' </dt>
                            <dd>'.$row['name_project'].'</dd>

                            <dt><b class="border-bottom border-primary">ชื่องาน</b></dt>
                            <dd>'.$row['name_tasklist'] .'</dd>

                            <dt><b class="border-bottom border-primary">วันที่สิ้นสุดงาน</b></dt>
                            <dd>'.thai_date_and_time($row['end_date_task']).'</dd>

                            <dt><b class="border-bottom border-primary">วันเเละเวลาที่ส่งงาน</b></dt>
                            <dd>'.thai_date_and_time($row['date_detalis']).'</dd>

                            <dt><b class="border-bottom border-primary">รายละเอียด</b></dt>
                            <dd>'.$row['comment'].'</dd>
                            ';
                            if($row['detail'] > 0){
                $outp.='     <dt><b class="border-bottom border-primary">เหตุผลที่ส่งล่าช้า</b></dt>
                            <dd>'.showtdetailtext($row['detail']).'</dd>
                        </dl>';
                            }

    }

    $profileusersendsql = "SELECT * FROM details NATURAL JOIN user WHERE user_id = $usersendid";
    $profileusersendqry = $db->query($profileusersendsql);
    $profileusersendqry->execute(); 
    $profileusersendrow = $profileusersendqry->fetch(PDO::FETCH_ASSOC);

    $outp.=' <dt><b class="border-bottom border-primary">คนที่ส่งงาน</b></dt>
                <dd> 
                    <div class="d-flex align-items-center mt-1">';
            if($profileusersendrow['avatar'] !=""){ 
    $outp.='   <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/'. $profileusersendrow['avatar'].'" alt="Avatar" width="35"  height="35">
                <b>'.showshortname($profileusersendrow['shortname_id']).' '.  $profileusersendrow['firstname']  .' '.$profileusersendrow['lastname'].'</b>';
            }else{ 
    $outp.='<img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                <b>'.showshortname($profileusersendrow['shortname_id']).' '.  $profileusersendrow['firstname']  .' '.$profileusersendrow['lastname'].'</b>';
            } 
    $outp.=' </div>
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
                </div>';
                        }  
        $outp.= '</div>
        </div> 
    </div>
    </div>'; 

    
      
    }else if($sendstatus == 2){
    while($row = $qry->fetch(PDO::FETCH_ASSOC)){ 

        $outp.='
            <div class="col-12  d-flex">
                <div class="card flex-fill">  
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
        
                                <dl>                                   
                                    <dt><b class="border-bottom border-primary">ชื่อโปรเจค</b> '.  showstatustime($row['status_timedetails']) .'</dt>
                                    <dd>'.$row['name_project'].'</dd>
                
                                    <dt><b class="border-bottom border-primary">ชื่องาน</b></dt>
                                    <dd>'.$row['name_tasklist'] .'</dd>

                                    
                                    <dt><b class="border-bottom border-primary">วันที่สิ้นสุดงาน</b></dt>
                                    <dd>'.thai_date_and_time($row['end_date_task']).'</dd>

                
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
                        <div class="d-flex align-items-center mt-1">';
        if($profileusersendrow['avatar'] !=""){ 
        $outp.='   <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/'. $profileusersendrow['avatar'].'" alt="Avatar" width="35"  height="35">
                        <b>'.showshortname($profileusersendrow['shortname_id']).' '.  $profileusersendrow['firstname']  .' '.$profileusersendrow['lastname'].'</b>';
                    }else{ 
        $outp.='<img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                        <b>'.showshortname($profileusersendrow['shortname_id']).' '.  $profileusersendrow['firstname']  .' '.$profileusersendrow['lastname'].'</b>';
                } 
        $outp.='</div>
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
                </div> ';
            }  

        $outp.='</div>
        </div>
    </div> 
        </div>
        </div>';  
            
             
    }

    echo  $outp;
 exit;
}
else if($_POST['proc'] == 'opentask'){ 

    
    $status = 0;
    $project_id = $_POST['project_id'];
    $taskid = $_POST['taskid'];
    
     $chktask = "SELECT end_date_task FROM task_list WHERE task_id = $taskid ";
     $chktask = $db->query($chktask);
     $chktaskrow = $chktask->fetch(PDO::FETCH_ASSOC);

     /* if (strtotime($chktaskrow['end_date_task']) > strtotime($date)) {
         $_SESSION['error'] = "เวลาของงานนี้ได้หมดลงเเล้วไม่สามารถเปิดหัวข้องานเเล้ว";
         echo 1;
        /*  header("location: editproject_page.php?update_id=$project_id"); 
     } 
    else  */if(!isset($_SESSION['error'])){
         $updatestatuspro = $db->prepare('UPDATE task_list SET status_task2 = :status WHERE task_id = :task_id');
         $updatestatuspro->bindParam(':status', $status);
         $updatestatuspro->bindParam(':task_id', $taskid);
         $updatestatuspro->execute();
 
         $_SESSION['success'] = "เปิดงานเรียบร้อยแล้ว! ";
     } else {
         $_SESSION['error'] = "มีบางอย่างผิดพลาด";
         header("location: edittask_page.php?updatetask_id=$taskid&project_id=$project_id");
         exit; // จบการทำงาน
     } 
} 
else if($_POST['proc'] == 'closetask'){

    $status = 1;
    $project_id=$_POST['project_id'];
    $taskid = $_POST['taskid'];

        if(isset($project_id)){
        $updatestatuspro = $db->prepare('UPDATE task_list SET status_task2 = :status WHERE task_id = :task_id');
        $updatestatuspro->bindParam(':status', $status);
        $updatestatuspro->bindParam(':task_id', $taskid);
        $updatestatuspro->execute();

       $_SESSION['success'] = "ปิดงานเรียบร้อยแล้ว! ";
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
        header("location: edittask_page.php?updatetask_id=$taskid&project_id=$project_id");
    } 
}
else if($_POST['proc'] == 'viewdatatask'){

   
    $taskid = $_POST['task_id'];
    $projectid = $_POST['project_id'];

    $select_project = $db->prepare("SELECT * FROM project  natural JOIN job_type  WHERE project_id = :id");
    $select_project->bindParam(":id",$projectid);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);

    $stmttasklist = "SELECT *
    FROM task_list 
    NATURAL JOIN user 
    WHERE project_id = $projectid";
    $stmttasklist = $db->query($stmttasklist);
    $stmttasklist->execute();  
    while ($row2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){

    $outp = '';

     $outp .=' <div class="col-12  d-flex">
                         <div class="card flex-fill">  
                             <div class="card-header">
                                 <div class="row">
                                    <div class="col-md-6">
                                   
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">ชื่องาน </b> <b>'. showstatustime($row2['status_timetask']) .'</b></dt>
                                                    <dd>'. $row2['name_tasklist'] .'  </dd>

                                                    <dt><b class="border-bottom border-primary">คำอธิบาย</b></dt>
                                                    <dd>'. trim($row2['description_task'])  .'</dd>

                                                 <dt><b class="border-bottom border-primary mb-3">ความคืบหน้า</b></dt>
                                                    <dd>
                                                        <div class="mb-3">     
                                                        </div>
                                                            <div class="progress" style="height: 20px;width:200px;" >
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:'.$row2['progress_task'] .' %" >'. $row2['progress_task'] .'</div>
                                                            </div>
                                                       
                                                    </dd> 


                                                </dl>
                                                <dl>
                                                        <dt>
                                                            <b class="border-bottom border-primary">ผู้สร้างงาน</b>
                                                        </dt>
                                                        <dd> 
                                                            <div class="d-flex align-items-center mt-1">';
                                                           if($manager['avatar'] !=""){
                                                        $outp .=' <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/'.$manager['avatar'].'" alt="Avatar" width="35"  height="35">
                                                                <b>'. showshortname($manager['shortname_id']).' '.$manager['name'] .' </b>';
                                                                 }else{
                                                        $outp .=' <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                                                                <b>'.showshortname($manager['shortname_id']).' '.$manager['name'] .' </b>';
                                                               }

                                                    $outp .=' </div>
                                                    </dd>
                                                </dl> 
                                        </div>

                                            <div class="col-md-6">
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันที่เริ่มเเละเวลาเริ่ม</b></dt>
                                                    <dd>'. thai_date_and_time($row2['strat_date_task']) .'</dd>
                                                </dl>
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">วันสิ้นสุดเเละเวลาสิ้นสุด</b></dt>
                                                    <dd>'. thai_date_and_time($row2['end_date_task']) .'</dd>
                                                </dl>
                                                <dl>
                                                   <dt><b class="border-bottom border-primary">สถานะ</b></dt>
                                                        <dd>'. showstattask($row2['status_task']) .'</dd>
                                                </dl>
                                                
                                                <dl>
                                                    <dt><b class="border-bottom border-primary">สมาชิก</b></dt>
                                                    <dd>';
                                                    if($row2['avatar'] !=""){
                                                        $outp .='  <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/'. $row2['avatar'].'" alt="Avatar" width="35"  height="35">
                                                        <b>'.showshortname($row2['shortname_id']).' '.$row2['firstname']." ".$row2['lastname'] .'</b>';
                                                    }else{
                                                        $outp .=' <img class="rounded-circle rounded me-2 mb-2" src="img/avatars/09.jpg" alt="Avatar" width="35"  height="35">
                                                        <b>'. showshortname($row2['shortname_id']).' '.$row2['firstname']." ".$row2['lastname'] .'</b>';
                                                     }
                                                   
                                            
                                                     $outp .=' </dd>
                                                </dl> 
                                            </div>
                                            
                                            <div class="col-md-12">
                                            <dt><b class="border-bottom border-primary">ไฟล์เเนบ</b></dt>';
                                           
                                               // $task_id=$row2['task_id'];
                                                    $sql = "SELECT * FROM project NATURAL JOIN file_item_task WHERE task_id = $taskid";
                                                    $qry = $db->query($sql);
                                                    $qry->execute();
                                                    while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)) {  
                                 $outp .='      <div class="row">
                                                    <div class="col-sm">
                                                        
                                                    <a href="img/file/file_task/'. $row2['newname_filetask'] .' " download="'. $row2['filename_task'] .'">'. $row2['filename_task'].'</a> 
                                                    
                                                    </div>
                                                </div>';
                                            } 
                             $outp .='  </div>
                                </div>
                            </div>
                        </div>
            </div> 	'; 
        }
        echo $outp;
        exit;
}

    ?>