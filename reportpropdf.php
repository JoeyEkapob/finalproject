<?php
 session_start();
    require_once 'connect.php';
    require  'fpdf/fpdf.php';
    include "funtion.php";
    date_default_timezone_set('asia/bangkok');
    $date = date ("Y-m-d");
    $us=$_SESSION['user_login'];

if($_POST['proc'] == 'report'){

    $nameproject = $_POST["nameproject"];
    $job = $_POST["job"];
    $start_date = $_POST["startdate"];
    $end_date = $_POST["enddate"];
    $status1 = $_POST["status1"];
    $status2 = $_POST["status2"];

    /*     $username = $db->query("SELECT CONCAT(FirstName, ' ', LastName) As fullName FROM user WHERE project_id =  ".$array['project_id']." "); */

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


    class PDF extends FPDF {
    // Page header
        function Header() {
            // กำหนดขนาดฟอนต์ให้กับหัวตาราง
        /*  $this->AddFont('THSarabunb','B','THSarabun Bold.php');
            $this->AddFont('THSarabun','','THSarabun.php');
            $this->SetFont('THSarabunb','B',14);
            
            // กำหนดช่องว่างด้านบนของหัวตาราง
            $this->Cell(10,10,'',0,0);

            // เขียนข้อความลงใน cell ของหัวตาราง
            $this->Cell(22,10,iconv('UTF-8','cp874','รหัสหัวข้องาน'),1,0,"C");
            $this->Cell(40,10,iconv('UTF-8','cp874','ชื่อหัวข้องาน'),1,0,"C");
            $this->Cell(35,10,iconv('UTF-8','cp874','ประเภทงาน'),1,0,"C");
            $this->Cell(50,10,iconv('UTF-8','cp874','วันที่เรื่ม - วันที่สิ้นสุด'),1,0,"C");
            $this->Cell(20,10,iconv('UTF-8','cp874','สถานะ'),1,0,"C");
            $this->Cell(25,10,iconv('UTF-8','cp874','คนที่มอบหมาย'),1,1,"C"); */
        }
    
        // Page footer
        function Footer() {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('THSarabun','',12);
            // Page number
            $this->Cell(0,10,iconv('UTF-8','cp874','หน้า').$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    // Instanciation of inherited class
    $pdf = new PDF();
    $title = "รายงาน";
    $pdf->SetTitle($title,true); // ให้แสดง title ไทย
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->AddFont('THSarabunb','B','THSarabun Bold.php');
    $pdf->AddFont('THSarabun','','THSarabun.php');
    $pdf->SetFont('THSarabunb','B',16); 
    $pdf->Image('pic/LOGORMUTK.png', 86, 2, 40);
    $pdf->Cell(193,70,iconv('UTF-8','cp874','รายงาน'),0,0,"C");
    
   
    if (!empty($start_date)) {
    $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
    $pdf->Cell(50,15,iconv('UTF-8','cp874','ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)) ),0,0,"");
    }else{
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
        $pdf->Cell(50,15,iconv('UTF-8','cp874','ตั้งเเต่วันที่ : - ' ),0,0,"");
    }
    if (!empty($end_date)) {
    $pdf->Cell(50,15,iconv('UTF-8','cp874','จนถึงวันที่ : '. thai_date_short(strtotime($end_date)) ),0,0,"L");
    $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,"");  
    }else{
        $pdf->Cell(50,15,iconv('UTF-8','cp874','จนถึงวันที่ : - '),0,0,"L");
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,"");  
    }
 
   /*  if (!empty($status1)) {
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,""); 
    $pdf->Cell(50,13,iconv('UTF-8','cp874','สถานะงาน : '. showstatprotext1($status1) ),0,0,"");
    }else{
        $pdf->Cell(50,13,iconv('UTF-8','cp874','สถานะงาน :  - ' ),0,0,"");
    }

    $pdf->Cell(50,13,iconv('UTF-8','cp874','การเร่งของงาน : '. showstatprotext2($status2) ),0,0,"");
    $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,"");  */

    
    /* if (!empty($start_date)) {
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
        $pdf->Cell(50,15,iconv('UTF-8','cp874','ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)) ),0,0,"");
        
    }
    if (!empty($end_date)) {
       
        $pdf->Cell(50,15,iconv('UTF-8','cp874','จนถึงวันที่ : '. thai_date_short(strtotime($end_date)) ),0,0,"L");
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,"");  
 
      
    }
    if (!empty($status1)) {
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,""); 
        $pdf->Cell(50,13,iconv('UTF-8','cp874','สถานะงาน : '. showstatprotext1($status1) ),0,0,"");
    }
    if (!empty($status2)) {
    
        $pdf->Cell(50,13,iconv('UTF-8','cp874','การเร่งของงาน : '. showstatprotext2($status2) ),0,0,"");
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,""); 
    
    } 
 */
    /*   $pdf->SetY(50);  */
    $pdf->Ln();
    /* $pdf->SetFont('THSarabun','',14); */
    
    $pdf->Cell(70,1,iconv('UTF-8','cp874','หัวข้องานทั้งหมด :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',' '),0,0,"L");
    /*  $pdf->Cell(30,8,iconv('UTF-8','cp874','เเก้ไขทั้งหมด :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874','' ),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ส่ง (ล่าช้า) :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', ''),0,0,"L");
     */
    $pdf->Ln();
    /* $pdf->SetFillColor(100,0,0); */
    $pdf->setDrawColor(100,100,100); 
    $pdf->SetFont('THSarabunb','B',14); 
    $pdf->Cell(22,8,iconv('UTF-8','cp874','รหัสหัวข้องาน'),1,0,"C");
    $pdf->Cell(40,8,iconv('UTF-8','cp874','ชื่อหัวข้องาน'),1,0,"C");
    $pdf->Cell(35,8,iconv('UTF-8','cp874','ประเภทงาน'),1,0,"C");
    $pdf->Cell(50,8,iconv('UTF-8','cp874','วันที่เรื่ม - วันที่สิ้นสุด'),1,0,"C");
    $pdf->Cell(20,8,iconv('UTF-8','cp874','สถานะ'),1,0,"C");
    $pdf->Cell(25,8,iconv('UTF-8','cp874','คนที่มอบหมาย'),1,0,"C");
    $pdf->Ln();




    $stmt = $db->query($sql);
    $stmt->execute();
    $pdf->SetFont('THSarabun','',14); 
    $stmtrow = $stmt->rowCount();  
        if($stmtrow > 0){
            while($array = $stmt->fetch(PDO::FETCH_ASSOC)){

            $sql2 = $db->query("SELECT * FROM task_list WHERE project_id =  ".$array['project_id']." ");
            $numtask = $sql2->rowCount(); 
            $comptask = $db->query("SELECT * FROM task_list where project_id =".$array['project_id']."  and status_task = 5");
            $comptask2 = $comptask->rowCount(); 
            
            $pdf->Cell(22,10,iconv('UTF-8','cp874',$array['project_id']),1,0,"C");
            $pdf->Cell(40,10,iconv('UTF-8','cp874',$array['name_project']),1,0,"c");
            $pdf->Cell(35,10,iconv('UTF-8','cp874',$array['name_jobtype']),1,0,"c");
            $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', thai_date_short(strtotime($array['start_date']))) . ' - ' . iconv('UTF-8', 'cp874', thai_date_short(strtotime($array['end_date']))), 1, 0, "C");
        /*  $pdf->Cell(17,10,iconv('UTF-8','cp874',showstatprotext1($array['status_1'])). ' - '.iconv('UTF-8','cp874',showstatprotext1($array['status_1'])),1,0,"C"); */
            $pdf->Cell(20,10,iconv('UTF-8','cp874',showstatprotext1($array['status_1']))/* .'('.iconv('UTF-8','cp874',showstatprotext2($array['status_2'])).')' */, 1, 0, "C");
    /* 
            $pdf->Cell(17,10,iconv('UTF-8','cp874',$array['progress_project'].' '.'%'),1,0,"C"); */
        $pdf->Cell(25,10,iconv('UTF-8','cp874',$array['firstname'].' '.$array['lastname']),1,1,"c"); 
        /*    $pdf->Cell(25,10,iconv('UTF-8','cp874','sdfsdfsdfsdfsdfsdfsdf'),1,1,"c"); */

            } 
    /*  $pdf->Ln(); */
        } else{

            $pdf->Cell(192,10,iconv('UTF-8','cp874','ไม่พอข้อมูล'),1,1,"C");
        }
        
        $nameuser ="SELECT concat(firstname,' ',lastname) as name From user WHERE user_id = $us";
        $nameuser = $db->query($nameuser);
        $nameuser->execute();  
        $nameuser = $nameuser->fetch(PDO::FETCH_ASSOC);

    $pdf->SetFont('THSarabun','',10); 
    $pdf->Cell(193,8,iconv('UTF-8','cp874','ผู้พิมพ์ '.$nameuser['name']),0,1,"R");
    $pdf->Cell(193,3,iconv('UTF-8','cp874','วันที่พิมพ์ '.ThDate($date).''),0,0,"R");


    $pdf->Output();
    ob_end_flush();

}
else if($_POST['proc']== 'reportpro'){

    $id = $_POST['projectid'];

    $select_project = $db->prepare("SELECT * FROM project  natural JOIN job_type  WHERE project_id = :id");
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
    $numtask = $db->query("SELECT * FROM task_list where project_id = $id ");
    $numtask = $numtask->rowCount(); 

    $stmt2 = $db->query("SELECT * FROM task_list WHERE project_id =  $id AND status_timetask = 2   ");
    $numchktime = $stmt2->rowCount();

    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);


    class PDF extends FPDF {
        // Page header
            function Header() {
        /*       global $title;
                $this->AddFont('THSarabun','','THSarabun.php');
                $this->SetFont('THSarabun','',16); 
                // Move to the right
                // Title
                $this->Image('pic/LOGORMUTK.png',86,2,40);
                $this->Ln(30);
                $this->Cell(0,10,iconv('UTF-8','cp874',$title),2,1,'C');
                // Line break
                $this->Ln(15);  */
             
            }
         
            // Page footer
            function Footer() {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('THSarabun','',12);
                // Page number
                $this->Cell(0,10,iconv('UTF-8','cp874','หน้า').$this->PageNo().'/{nb}',0,0,'C');
            }
        }

    $pdf = new PDF();
    $title = "รายงาน";
    $pdf->SetTitle($title,true); // ให้แสดง title ไทย
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->AddFont('THSarabunb','B','THSarabun Bold.php');
    $pdf->AddFont('THSarabun','','THSarabun.php');
    $pdf->SetFont('THSarabunb','B',14); 
    $pdf->Image('pic/LOGORMUTK.png', 86, 2, 40);

    $pdf->Ln(35);
    $pdf->Cell(30,8,iconv('UTF-8','cp874','รหัสหัวข้องาน :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$project_id),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ชื่อโปรเจค :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $name_project),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ประเภทงาน :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$name_jobtype),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ผู้สร้างโปรเจค :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$manager['name']),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','วันที่เริ่ม :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',ThDate($start_date)),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','วันที่สิ้นสุด :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',ThDate($end_date) ),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ความคืบหน้า :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$progress_project. ' % '),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','สถานะ :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', showstatprotext1($status_1).' (' .showstatprotext2($status_2).')' ),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','สมาชิก :'),0,0,"R");

    $sql = "SELECT * FROM project_list  natural join user  where project_id = $id ";
    $qry = $db->query($sql);
    $qry->execute();
    $numpsuer = $qry->rowcount();
    $i = 0;
    $name_list = "";
    while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
        $name_list .= $row['firstname']." ".$row['lastname'];
        if(++$i != $numpsuer){
            $name_list .= " , ";
        }
        if($i % 3 == 0) {
            $name_list .= "\n";
        }
    }

    $pdf->MultiCell(160,7,iconv('UTF-8','cp874',$name_list),0,"L");
    $pdf->Ln();

    $pdf->Cell(30,8,iconv('UTF-8','cp874','จำนวนงาน :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $numtask),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','จำนวนงานที่ล่าช้า :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$numchktime ),0,0,"L");

    $pdf->Ln();
    $pdf->setDrawColor(100,100,100); 
    $pdf->SetFont('THSarabunb','B',14); 
    $pdf->Cell(22,8,iconv('UTF-8','cp874','รหัสหัวข้องาน'),1,0,"C");
    $pdf->Cell(40,8,iconv('UTF-8','cp874','ชื่องาน'),1,0,"C");
    $pdf->Cell(45,8,iconv('UTF-8','cp874','วันที่เรื่ม - วันที่สิ้นสุด'),1,0,"C");
    $pdf->Cell(25,8,iconv('UTF-8','cp874','ความสำเร็จ'),1,0,"C");
    $pdf->Cell(35,8,iconv('UTF-8','cp874','มอบหมาย'),1,0,"C");
    $pdf->Cell(25,8,iconv('UTF-8','cp874','สถานะ'),1,0,"C");
    $pdf->Ln();

    
    $stmttasklist = "SELECT *
    FROM task_list 
    NATURAL JOIN user 
    WHERE project_id = $id";
    $stmttasklist = $db->query($stmttasklist);
    $stmttasklist->execute();  
    $pdf->SetFont('THSarabun','',14); 
    $stmttasklistrow = $stmttasklist->rowCount();  
        if($stmttasklistrow > 0){
            while($stmttasklistrow2 = $stmttasklist->fetch(PDO::FETCH_ASSOC)){

        /*    $sql2 = $db->query("SELECT * FROM task_list WHERE project_id =  ".$array['project_id']." ");
            $numtask = $sql2->rowCount(); 
            $comptask = $db->query("SELECT * FROM task_list where project_id =".$array['project_id']."  and status_task = 5");
            $comptask2 = $comptask->rowCount();  */
            
            $pdf->Cell(22,10,iconv('UTF-8','cp874',$stmttasklistrow2['task_id']),1,0,"C");
            $pdf->Cell(40,10,iconv('UTF-8','cp874',$stmttasklistrow2['name_tasklist']),1,0,"c");
            $pdf->Cell(45, 10, iconv('UTF-8', 'cp874', thai_date_short(strtotime($stmttasklistrow2['strat_date_task']))) . ' - ' . iconv('UTF-8', 'cp874', thai_date_short(strtotime($stmttasklistrow2['end_date_task']))), 1, 0, "C");
            $pdf->Cell(25,10,iconv('UTF-8','cp874',$stmttasklistrow2['progress_task'].' '.'%'),1,0,"C"); 
        $pdf->Cell(35,10,iconv('UTF-8','cp874',$stmttasklistrow2['firstname'].' '.$stmttasklistrow2['lastname']),1,0,"c"); 
        $pdf->Cell(25,10,iconv('UTF-8','cp874',showstattaskreport($stmttasklistrow2['status_task'])) .iconv('UTF-8','cp874',showstatustimepdf($stmttasklistrow2['status_timetask'])) , 1, 1, "C");

            } 
        /*  $pdf->Ln();  */
        } else{

            $pdf->Cell(192,10,iconv('UTF-8','cp874','ไม่พอข้อมูล'),1,1,"C");
        }

        $nameuser ="SELECT concat(firstname,' ',lastname) as name From user WHERE user_id = $us";
        $nameuser = $db->query($nameuser);
        $nameuser->execute();  
        $nameuser = $nameuser->fetch(PDO::FETCH_ASSOC);

    $pdf->SetFont('THSarabun','',10); 
    $pdf->Cell(193,8,iconv('UTF-8','cp874','ผู้พิมพ์ '.$nameuser['name']),0,1,"R");
    $pdf->Cell(193,3,iconv('UTF-8','cp874','วันที่พิมพ์ '.ThDate($date).''),0,0,"R");

        $pdf->SetY(50);
        $pdf->Output();
        ob_end_flush();
}
else if($_POST['proc']== 'reporttaskdetails'){

    $taskid = $_POST['taskid'];
    $projectid = $_POST['projectid'];

    
    $select_project = $db->prepare("SELECT * FROM project as p 
    left join task_list as t ON p.project_id = t.project_id  
    left join user as u ON t.user_id = u.user_id  
    WHERE task_id = :id");
    $select_project->bindParam(":id",  $taskid);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);
  
 /*    $numtask = $db->query("SELECT * FROM task_list where project_id = $id ");
    $numtask = $numtask->rowCount(); */

    $manager = $db->query("SELECT *,concat(firstname,' ',lastname) as name FROM user where user_id = $manager_id");
    $manager = $manager->fetch(PDO::FETCH_ASSOC);  

    
    $stmt = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 1   ");
    $numsenddetails = $stmt->rowCount();
    $stmt2 = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 2   ");
    $numchkdetails = $stmt2->rowCount(); 
    $stmt3 = $db->query("SELECT * FROM details WHERE task_id =  $task_id AND send_status = 1  AND status_timedetails = 2 ");
    $chktimesend = $stmt3->rowCount();

    class PDF extends FPDF {
        // Page header
            function Header() {
        /*       global $title;
                $this->AddFont('THSarabun','','THSarabun.php');
                $this->SetFont('THSarabun','',16); 
                // Move to the right
                // Title
                $this->Image('pic/LOGORMUTK.png',86,2,40);
                $this->Ln(30);
                $this->Cell(0,10,iconv('UTF-8','cp874',$title),2,1,'C');
                // Line break
                $this->Ln(15);  */
             
            }
         
            // Page footer
            function Footer() {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('THSarabun','',12);
                // Page number
                $this->Cell(0,10,iconv('UTF-8','cp874','หน้า').$this->PageNo().'/{nb}',0,0,'C');
            }
        }

    $pdf = new PDF();
    $title = "รายงาน";
    $pdf->SetTitle($title,true); // ให้แสดง title ไทย
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->AddFont('THSarabunb','B','THSarabun Bold.php');
    $pdf->AddFont('THSarabun','','THSarabun.php');
    $pdf->SetFont('THSarabunb','B',14); 
    $pdf->Image('pic/LOGORMUTK.png', 86, 2, 40);

    $pdf->Ln(35);
    $pdf->Cell(30,8,iconv('UTF-8','cp874','รหัสงาน :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$task_id),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ชื่องาน :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $name_tasklist),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ผู้สร้างงาน :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $manager['name']),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ความคืบหน้า :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$progress_task.' %'),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','วันที่เริ่ม :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', ThDate($strat_date_task)),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','วันที่สิ้นสุด :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',ThDate($end_date_task) ),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ผู้รับผิดชอบ :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$firstname.' '.$lastname),0,0,"L");
    
    
    $pdf->Ln();

    $pdf->Cell(30,8,iconv('UTF-8','cp874','ส่งทั้งหมด :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $numsenddetails),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','เเก้ไขทั้งหมด :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$numchkdetails ),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ส่ง (ล่าช้า) :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $chktimesend),0,0,"L");

    $pdf->Ln();
    $pdf->setDrawColor(100,100,100); 
    $pdf->SetFont('THSarabunb','B',14); 
    $pdf->Cell(22,8,iconv('UTF-8','cp874','ครั้งที่'),1,0,"C");
    $pdf->Cell(60,8,iconv('UTF-8','cp874','ชื่องาน'),1,0,"C");
    $pdf->Cell(50,8,iconv('UTF-8','cp874','วันที่ส่ง'),1,0,"C");
    $pdf->Cell(25,8,iconv('UTF-8','cp874','ความคืบหน้า'),1,0,"C");
    $pdf->Cell(35,8,iconv('UTF-8','cp874','สถานะ'),1,0,"C");
    $pdf->Ln();



    $i = 1;
    $send_status =1;
    $sqldetailsuser = $db->prepare('SELECT * FROM details  NATURAL JOIN task_list  NATURAL JOIN project where task_id = :task_id AND send_status = :send_status');
    $sqldetailsuser->bindParam(":task_id", $task_id);
    $sqldetailsuser->bindParam(":send_status", $send_status);
    $sqldetailsuser->execute();
    $pdf->SetFont('THSarabun','',14); 
    $sqldetailsuserrow = $sqldetailsuser->rowCount();  
    if($sqldetailsuserrow > 0){
    while ($sqldetailsuser2 = $sqldetailsuser->fetch(PDO::FETCH_ASSOC)) {

        $pdf->Cell(22,10,iconv('UTF-8','cp874',$i++),1,0,"C");
        $pdf->Cell(60,10,iconv('UTF-8','cp874',$sqldetailsuser2['name_tasklist']),1,0,"c");
        $pdf->Cell(50, 10, iconv('UTF-8', 'cp874',thai_date_and_time_short($sqldetailsuser2['date_detalis'])), 1, 0, "C");
        $pdf->Cell(25,10,iconv('UTF-8','cp874',$sqldetailsuser2['progress_task'].' '.'%'),1,0,"C"); 
        $pdf->Cell(35,10,iconv('UTF-8','cp874',showstatdetail($sqldetailsuser2['state_details'])) .iconv('UTF-8','cp874',showstatustimepdf($sqldetailsuser2['status_timedetails'])) , 1, 1, "C"); 
       
    }
    }else{
        $pdf->Cell(192,10,iconv('UTF-8','cp874','ไม่พอข้อมูล'),1,1,"C");
    }   
 
        $nameuser ="SELECT concat(firstname,' ',lastname) as name From user WHERE user_id = $us";
        $nameuser = $db->query($nameuser);
        $nameuser->execute();  
        $nameuser = $nameuser->fetch(PDO::FETCH_ASSOC);

    $pdf->SetFont('THSarabun','',10); 
    $pdf->Cell(193,8,iconv('UTF-8','cp874','ผู้พิมพ์ '.$nameuser['name']),0,1,"R");
    $pdf->Cell(193,3,iconv('UTF-8','cp874','วันที่พิมพ์ '.ThDate($date).''),0,0,"R");

        $pdf->SetY(50); 
        $pdf->Output();
        ob_end_flush();
}
else if($_POST['proc']== 'reportuser'){


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
    $rowrole = $stmt->fetch(PDO::FETCH_ASSOC);
    class PDF extends FPDF {
        // Page header
            function Header() {
                // กำหนดขนาดฟอนต์ให้กับหัวตาราง
            /*  $this->AddFont('THSarabunb','B','THSarabun Bold.php');
                $this->AddFont('THSarabun','','THSarabun.php');
                $this->SetFont('THSarabunb','B',14);
                
                // กำหนดช่องว่างด้านบนของหัวตาราง
                $this->Cell(10,10,'',0,0);
    
                // เขียนข้อความลงใน cell ของหัวตาราง
                $this->Cell(22,10,iconv('UTF-8','cp874','รหัสหัวข้องาน'),1,0,"C");
                $this->Cell(40,10,iconv('UTF-8','cp874','ชื่อหัวข้องาน'),1,0,"C");
                $this->Cell(35,10,iconv('UTF-8','cp874','ประเภทงาน'),1,0,"C");
                $this->Cell(50,10,iconv('UTF-8','cp874','วันที่เรื่ม - วันที่สิ้นสุด'),1,0,"C");
                $this->Cell(20,10,iconv('UTF-8','cp874','สถานะ'),1,0,"C");
                $this->Cell(25,10,iconv('UTF-8','cp874','คนที่มอบหมาย'),1,1,"C"); */
            }
        
            // Page footer
            function Footer() {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('THSarabun','',12);
                // Page number
                $this->Cell(0,10,iconv('UTF-8','cp874','หน้า').$this->PageNo().'/{nb}',0,0,'C');
            }
        }
    
        // Instanciation of inherited class
        $pdf = new PDF();
        $title = "รายงาน";
        $pdf->SetTitle($title,true); // ให้แสดง title ไทย
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->AddFont('THSarabunb','B','THSarabun Bold.php');
        $pdf->AddFont('THSarabun','','THSarabun.php');
        $pdf->SetFont('THSarabunb','B',16); 
        $pdf->Image('pic/LOGORMUTK.png', 86, 2, 40);
        $pdf->Cell(193,70,iconv('UTF-8','cp874','รายงาน'),0,0,"C");
    
        $pdf->Ln(35);
        if (!empty($startdate)) {
        $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
        $pdf->Cell(50,15,iconv('UTF-8','cp874','ตั้งเเต่วันที่ : '. thai_date_short(strtotime($startdate)) ),0,0,"");
        }else{
            $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
            $pdf->Cell(50,15,iconv('UTF-8','cp874','ตั้งเเต่วันที่ : - ' ),0,0,"");
        }
        if (!empty($enddate)) {
            $pdf->Cell(50,15,iconv('UTF-8','cp874','จนถึงวันที่ : '. thai_date_short(strtotime($enddate)) ),0,0,"L");
            $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,"");  
        }else{
            $pdf->Cell(50,15,iconv('UTF-8','cp874','จนถึงวันที่ : - '),0,0,"L");
            $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,"");  
        }
        if (!empty($role)) {
                $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
                $pdf->Cell(50,15,iconv('UTF-8','cp874','ตำเเหน่ง : '. $rowrole['position_name'] ),0,0,"");
            }else{
                $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
                $pdf->Cell(50,15,iconv('UTF-8','cp874','ตำเเหน่ง : - ' ),0,0,"");
            }
            $pdf->Cell(50,15,iconv('UTF-8','cp874','จำนวนสมาชิก : '. $numuser .' คน  ' ),0,0,"L");
            $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,1,"");  
     /*    $pdf->Cell(70,8,iconv('UTF-8','cp874','จำนวนสมาชิก :'),0,0,"R");
        $pdf->Cell(65,8,iconv('UTF-8','cp874',$numuser),0,0,"L");  */
    
        /* $pdf->SetFont('THSarabun','',14); */
        $pdf->Ln();
       
        /*  $pdf->Cell(30,8,iconv('UTF-8','cp874','เเก้ไขทั้งหมด :'),0,0,"R");
        $pdf->Cell(65,8,iconv('UTF-8','cp874','' ),0,1,"L");
        $pdf->Cell(30,8,iconv('UTF-8','cp874','ส่ง (ล่าช้า) :'),0,0,"R");
        $pdf->Cell(65,8,iconv('UTF-8','cp874', ''),0,0,"L");
         */
      
        /* $pdf->SetFillColor(100,0,0); */
        $pdf->setDrawColor(100,100,100); 
        $pdf->SetFont('THSarabunb','B',14); 
        $pdf->Cell(10,8,iconv('UTF-8','cp874','ลำดับ'),1,0,"C");
        $pdf->Cell(40,8,iconv('UTF-8','cp874','ชื่อ-นามสกุล'),1,0,"C");
        $pdf->Cell(30,8,iconv('UTF-8','cp874','ตำเเหน่ง'),1,0,"C");
        $pdf->Cell(25,8,iconv('UTF-8','cp874','หัวข้องานที่สร้าง'),1,0,"C");
        $pdf->Cell(25,8,iconv('UTF-8','cp874','หัวข้องานที่ถูกสั่ง'),1,0,"C");
        $pdf->Cell(20,8,iconv('UTF-8','cp874','จำนวนงาน'),1,0,"C");
        $pdf->Cell(20,8,iconv('UTF-8','cp874','งานที่ล่าช้า'),1,0,"C");
        $pdf->Cell(22,8,iconv('UTF-8','cp874','ครั้งที่ถูกสั่งเเก้'),1,1,"C");
     
     
        $i = 1;
        $pdf->SetFont('THSarabun','',14); 
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

                $pdf->Cell(10,8,iconv('UTF-8','cp874',$i++ ),1,0,"C");
                $pdf->Cell(40,8,iconv('UTF-8','cp874',$row['firstname'].' '.$row['lastname']),1,0,"c");
                $pdf->Cell(30,8,iconv('UTF-8','cp874',$row['position_name']),1,0,"c");
                $pdf->Cell(25,8,iconv('UTF-8','cp874',$nummannagerpro),1,0,"C");
                $pdf->Cell(25,8,iconv('UTF-8','cp874',$numuserpro),1,0,"C");
                $pdf->Cell(20,8,iconv('UTF-8','cp874',$numusertask),1,0,"C");
                $pdf->Cell(20,8,iconv('UTF-8','cp874',$numdela),1,0,"C");
                $pdf->Cell(22,8,iconv('UTF-8','cp874',$numdetails),1,1,"C");
             

            }
        }else{

            $pdf->Cell(192,10,iconv('UTF-8','cp874','ไม่พอข้อมูล'),1,1,"C");
        }
        
        $nameuser ="SELECT concat(firstname,' ',lastname) as name From user WHERE user_id = $us";
        $nameuser = $db->query($nameuser);
        $nameuser->execute();  
        $nameuser = $nameuser->fetch(PDO::FETCH_ASSOC);

    $pdf->SetFont('THSarabun','',10); 
    $pdf->Cell(193,8,iconv('UTF-8','cp874','ผู้พิมพ์ '.$nameuser['name']),0,1,"R");
    $pdf->Cell(193,3,iconv('UTF-8','cp874','วันที่พิมพ์ '.ThDate($date).''),0,0,"R");


    $pdf->Output();
    ob_end_flush();
    
}