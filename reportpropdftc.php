<?php
 session_start();
    require_once 'connect.php';
    require_once('vendor/autoload.php');
    require_once 'funtionpdf.php';
  date_default_timezone_set('asia/bangkok');
    $date = date ("Y-m-d");
    $us=$_SESSION['user_login'];

    $nameuser ="SELECT concat(firstname,' ',lastname) as name , u.role_id ,u.user_id  ,p.role_id , p.level ,d.department_id From user as u 
    left join position as p on u.role_id = p.role_id 
    left join department as d on d.department_id = u.department_id 
    WHERE user_id = $us";
    $nameuser = $db->query($nameuser);
    $nameuser->execute();  
    $nameuser = $nameuser->fetch(PDO::FETCH_ASSOC);
  
    $level = $nameuser['level'];
    $department =$nameuser['department_id'];

if($_POST['proc'] == 'report'){

    $nameproject = $_POST["nameproject"];
    $job = $_POST["job"];
    $start_date = $_POST["startdate"];
    $end_date = $_POST["enddate"];
    $status1 = $_POST["status1"];
    $status2 = $_POST["status2"];
   /*  $role = $_POST["role"]; */

    if(isset($_POST["department"])){
        $department = $_POST["department"];
    }
    if(isset($_POST["role"])){
        $role = $_POST["role"];
    }

  /*   $username = $db->query("SELECT CONCAT(FirstName, ' ', LastName) As fullName FROM user WHERE project_id =  ".$array['project_id']." ");  */
    $where = '';
    if ($level > 2) {
        $where .= "AND $level <= po.level AND d.department_id = $department ";
    } 
    if(!empty($department)){
        $where .= "AND d.department_id = $department ";
    }
    if(!empty($role)){
        $where .= "AND po.role_id = $role ";
    }
    if (!empty($nameproject)) {
        $where .= "AND name_project LIKE '%$nameproject%' ";
    }
    if (!empty($job)) {
        $where .= "AND p.id_jobtype = '$job' ";
    }
    if (!empty($start_date)) {
        $where .= "AND start_date >= '$start_date' ";
    }
    if (!empty($end_date)) {
        $where .= "AND end_date <= '$end_date' ";
    }
    if (!empty($status1)) {
        $where .= "AND status_1 = '$status1' ";
    }
    if (!empty($status2)) {
        $where .= "AND status_2 = '$status2' ";
    }
    
    $numtask = $db->query("SELECT task_id FROM task_list as t 
    left join project as p on t.project_id = p.project_id  
    left join job_type as j on p.id_jobtype = j.id_jobtype 
    LEFT JOIN user as u ON p.manager_id = u.user_id
    LEFT JOIN position as po ON po.role_id  = u.role_id
    LEFT JOIN department as d ON d.department_id  = u.department_id
    WHERE 1=1 $where  ");
    $numtask = $numtask->rowCount(); 


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
 
    $stmt = $db->query($sql);
    $stmt->execute();
    $stmtrow = $stmt->rowCount();  
    

    // Instanciation of inherited class
    
    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

    define('THSarabun', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts/font.ttf/THSarabun.ttf', 'TrueTypeUnicode'));
    define('THSarabunBold', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts/font.ttf/THSarabun Bold.ttf', 'TrueTypeUnicode'));
    define('THSarabunBoldItalic', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts/font.ttf/THSarabun Bold Italic.ttf', 'TrueTypeUnicode'));
    define('THSarabunItalic', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts/font.ttf/THSarabun Italic.ttf', 'TrueTypeUnicode'));
    
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 005');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    
    
    $pdf->setPrintHeader(false);
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->SetFont(THSarabunBold, '', 16);
    
    // add a page
    $pdf->AddPage();
    $pdf->Image('pic/LOGORMUTK2.jpg', '85', '5', 40, 40, '', '', '', false, 300, '', false, false, 0, false, false, false);
    $pdf->Ln(20);
    $title = "รายงานหัวข้องาน";
    $pdf->MultiCell(180, 5,$title, 0, 'C', 0, 1, '', '', true);
    
    
    
    
    $pdf->SetFont(THSarabunBold, '', 14);
    
    // set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);
    // set cell margins
    $pdf->setCellMargins(0, 0, 0, 0);
    // set color for background
    $pdf->SetFillColor(255, 255, 255);
    
    if (!empty($start_date)) {
        $pdf->MultiCell(47, 5,'', 1, 'R', 0, 1, '', '', true);
        $pdf->MultiCell(47, 5,'ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)), 1, 'L', 0, 1, '', '', true);
      
    }else{ 
        $pdf->MultiCell(45, 5,'', 1, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(45, 5,'ตั้งเเต่วันที่ : - ', 1, 'C', 0, 0, '', '', true);
    
    } 
    if (!empty($end_date)) {
        $pdf->MultiCell(45, 5,'ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)), 1, 'L', 0, 1, '', '', true);
        $pdf->MultiCell(45, 5,'', 1, 'R', 0, 1, '', '', true);
    }else{ 
        $pdf->MultiCell(45, 5,'ถึงวันที่ : - ', 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(45, 5,'', 1, 'R', 0, 1, '', '', true);
    
    } 
    if (!empty($start_date)) {
        $pdf->MultiCell(47, 5,'', 1, 'R', 0, 1, '', '', true);
        $pdf->MultiCell(47, 5,'ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)), 1, 'L', 0, 1, '', '', true);
      
    }else{ 
        $pdf->MultiCell(45, 5,'', 1, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(45, 5,'ตำเเหน่ง : - ', 1, 'C', 0, 0, '', '', true);
    
    } 
    if (!empty($end_date)) {
        $pdf->MultiCell(45, 5,'ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)), 1, 'L', 0, 1, '', '', true);
        $pdf->MultiCell(45, 5,'', 1, 'R', 0, 1, '', '', true);
    }else{ 
        $pdf->MultiCell(45, 5,'ฝ่าย : - ', 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(45, 5,'', 0, 'R', 0, 1, '', '', true);
    
    } 
    
    
    
    if (!empty($start_date)) {
        $pdf->MultiCell(50, 5,'', 1, 'R', 0, 1, '', '', true);
        $pdf->MultiCell(30, 5,'ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)), 1, 'C', 0, 1, '', '', true);
      
    }else{ 
        $pdf->MultiCell(35, 5,'', 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(48, 5,'ประเภทงาน : - ', 0, 'L', 0, 0, '', '', true);
    
    } 
    if (!empty($end_date)) {
        $pdf->MultiCell(30, 5,'ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)), 1, 'L', 0, 1, '', '', true);
        $pdf->MultiCell(30, 5,'', 1, 'R', 0, 1, '', '', true);
    }else{ 
        $pdf->MultiCell(35, 5,'สถานะงาน : - ', 0, 'L', 0, 0, '', '', true);
    
    } 
    if (!empty($end_date)) {
        $pdf->MultiCell(30, 5,'ตั้งเเต่วันที่ : '. thai_date_short(strtotime($start_date)), 1, 'L', 0, 1, '', '', true);
        $pdf->MultiCell(30, 5,'', 1, 'R', 0, 1, '', '', true);
    }else{ 
        $pdf->MultiCell(45, 5,'การเร่งของงาน : - ', 0, 'C', 0, 0, '', '', true);
        /* $pdf->MultiCell(30, 5,'', 1, 'R', 0, 1, '', '', true); */
    
    } 
    $pdf->Ln(10);
    
        $pdf->MultiCell(45, 5,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(45, 5,'จำนวนหัวข้องาน : - ', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(45, 5,'จำนวนงานทั้งหมด : - ', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(45, 5,'', 0, 'C', 0, 0, '', '', true);
    
        $pdf->Ln(10);
    
    $txt = '';
    $pdf->SetFont('THSarabun','B',14); 
    // Multicell test
    $pdf->MultiCell(22, 5, 'รหัสหัวข้องาน', 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(35, 5, 'ชื่อหัวข้องาน', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(28, 5, 'ประเภทงาน', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(45, 5, 'วันที่เรื่ม - วันที่สิ้นสุด', 1, 'C', 1, 0, '' ,'', true);
    $pdf->MultiCell(20, 5, 'สถานะ', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(30, 5, 'คนที่มอบหมาย', 1, 'C', 0, 1, '', '', true);
    
    /* $pdf->Ln(4); */
    if($stmtrow > 0){
        while($array = $stmt->fetch(PDO::FETCH_ASSOC)){

        $sql2 = $db->query("SELECT * FROM task_list WHERE project_id =  ".$array['project_id']." ");
        $numtask = $sql2->rowCount(); 
        $comptask = $db->query("SELECT * FROM task_list where project_id =".$array['project_id']."  and status_task = 5");
        $comptask2 = $comptask->rowCount(); 


        $txt = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';


   /*  echo strlen(thai_date_short(strtotime($array['start_date'])))/* .thai_date_short(strtotime($array['end_date']))) ;
     exit; */ 
     $widthname = $pdf->GetStringWidth($array['name_project']);
    $widthnamejob = $pdf->GetStringWidth($array['name_jobtype'].'sdfgsdfgsdfgsdfgsdfgsdfgsdfg');
    $widthdate = $pdf->GetStringWidth(thai_date_short(strtotime($array['start_date'])) .' - '.thai_date_short(strtotime($array['end_date'])));
    $widthnameuser = $pdf->GetStringWidth(showshortname($array['shortname_id']).' '.$array['firstname'] . ' ' . $array['lastname']); 
    /* echo $widthname.' '. $widthnamejob.' '.$widthdate.' '.$widthnameuser 
    exit;   */
   $y = 9;
   /*  $pdf->SetFont('THSarabunb','B',13);
  
        if ($widthname OR $widthnamejob OR  $widthnameuser > 60){
             $y = 20; 
        }else if($widthname OR $widthnamejob OR  $widthnameuser > 30){
            $y = 15; 
        } */
        $pdf->MultiCell(22, $y , $array['project_id']."\n", 1, 'C', 1, 0, '', '', true, 0, false, true, 40, '');
        $pdf->MultiCell(35, $y , $array['name_project'], 1, 'L', 1, 0, '', '', true, 0, false, true, 35, '');
        $pdf->MultiCell(28, $y , $array['name_jobtype'], 1, 'L', 1, 0, '', '', true, 0, false, true, 28, '');
        $pdf->MultiCell(45, $y , thai_date_short(strtotime($array['start_date'])) .' - '.thai_date_short(strtotime($array['end_date'])), 1, 'C', 1, 0, '', '', true, 0, false, true,45, '');
        $pdf->MultiCell(20, $y , showstatprotext1($array['status_1']), 1, 'C', 1, 0, '', '', true, 0, false, true, 20, '');
        $pdf->MultiCell(30, $y ,showshortname($array['shortname_id']).' '.$array['firstname'] . ' ' . $array['lastname'], 1, 'L', 1, 1, '', '', true, 0, false, true, 30, ''); 
        
    
   
    
   /*  $pdf->Ln(); */
        }
        
    } else{

    $pdf->Cell(192,10,iconv('UTF-8','cp874','ไม่พอข้อมูล'),1,1,"C");
    }
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    // set color for background
    
    // move pointer to last page
    $pdf->lastPage();
    
    // ---------------------------------------------------------
    
    //Close and output PDF document
    $pdf->Output('example_005.pdf', 'I');
    

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
    $pdf->Cell(50,8,iconv('UTF-8','cp874','ชื่องาน'),1,0,"C");
    $pdf->Cell(45,8,iconv('UTF-8','cp874','วันที่ส่ง'),1,0,"C");
    $pdf->Cell(23,8,iconv('UTF-8','cp874','ความคืบหน้า'),1,0,"C");
    $pdf->Cell(27,8,iconv('UTF-8','cp874','สถานะ'),1,0,"C");
    $pdf->Cell(25,8,iconv('UTF-8','cp874','หมายเหตุ'),1,0,"C");
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

        $pdf->MultiCell(22,10,iconv('UTF-8','cp874',$i++),1,0,"C");
        $pdf->MultiCell(50,10,iconv('UTF-8','cp874',$sqldetailsuser2['name_tasklist']),1,0,"c");
        $pdf->MultiCell(45, 10, iconv('UTF-8', 'cp874',thai_date_and_time_short($sqldetailsuser2['date_detalis'])), 1, 0, "C");
        $pdf->MultiCell(23,10,iconv('UTF-8','cp874',$sqldetailsuser2['progress_task'].' '.'%'),1,0,"C"); 
        $pdf->MultiCell(27,10,iconv('UTF-8','cp874',showstatdetail($sqldetailsuser2['state_details'])) .iconv('UTF-8','cp874',showstatustimepdf($sqldetailsuser2['status_timedetails'])) , 1,0, "C"); 
        $pdf->MultiCell(25,10,iconv('UTF-8','cp874',showtdetailtext($sqldetailsuser2['detail'])),1,1,"C"); 
       
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
                $nameposition = "SELECT * FROM position WHERE role_id = $role";
                $nameposition = $db->query($nameposition);
                $nameposition->execute();
                $nameposition = $nameposition->fetch(PDO::FETCH_ASSOC);
                $pdf->Cell(50,8,iconv('UTF-8','cp874',''),0,0,"");
                $pdf->Cell(50,15,iconv('UTF-8','cp874','ตำเเหน่ง : '. $nameposition['position_name'] ),0,0,"");
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
        $pdf->Cell(22,8,iconv('UTF-8','cp874','ครั้งที่ถูกสั่งเเก้'),1,0,"C");
     
        $pdf->Ln();
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
else if($_POST['proc']== 'reportuserpro'){

    $id = $_POST['userid'];

    $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","ส่งเรียบร้อยเเล้ว","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
    $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    
    $select_project = $db->prepare("SELECT * FROM user as u left join position as p on u.role_id = p.role_id  WHERE user_id = :id");
    $select_project->bindParam(":id", $id);
    $select_project->execute();
    $row = $select_project->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $sql2 = $db->query("SELECT * FROM project WHERE manager_id =  $user_id"); 
    $nummannagerpro = $sql2->rowCount(); 
    $sql3 = $db->query("SELECT * FROM project_list where user_id = $user_id");
    $numuserpro = $sql3->rowCount(); 
    $sql4 = $db->query("SELECT * FROM task_list where user_id = $user_id ");
    $numusertask = $sql4->rowCount(); 
    $sql5 = $db->query("SELECT * FROM details as d  left join task_list as t ON d.task_id = t.task_id  where user_id = $user_id  AND send_status = 2");
    $numdetails= $sql5->rowCount(); 

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
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ชื่อ-นามสกุล :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$firstname.' '.$lastname),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','ตำเเหน่ง :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $position_name),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','หัวข้องานที่สร้าง :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874', $nummannagerpro),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','หัวข้องานที่ถูกสั่ง :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$numuserpro),0,1,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','จำนวนงาน :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$numusertask ),0,0,"L");
    $pdf->Cell(30,8,iconv('UTF-8','cp874','จำนวนครั้งที่ถูกสั่งเเก้ :'),0,0,"R");
    $pdf->Cell(65,8,iconv('UTF-8','cp874',$numdetails),0,1,"L");
    

   

    $pdf->Ln();


    $pdf->setDrawColor(100,100,100); 
    $pdf->SetFont('THSarabunb','B',14); 
    $pdf->Cell(22,8,iconv('UTF-8','cp874','รหัสหัวข้องาน'),1,0,"C");
    $pdf->Cell(40,8,iconv('UTF-8','cp874','ชื่อหัวงาน'),1,0,"C");
    $pdf->Cell(42,8,iconv('UTF-8','cp874','วันที่เรื่ม - วันที่สิ้นสุด'),1,0,"C");
    $pdf->Cell(18,8,iconv('UTF-8','cp874','ความสำเร็จ'),1,0,"C");
    $pdf->Cell(35,8,iconv('UTF-8','cp874','สถานะ'),1,0,"C"); 
    $pdf->Cell(35,8,iconv('UTF-8','cp874','มอบหมาย'),1,0,"C");
  /*   $pdf->Cell(25,8,iconv('UTF-8','cp874','สถานะ'),1,0,"C"); */
    $pdf->Ln();
 
    
    $i = 1;
                                            
    $stmttasklist = "SELECT *
    FROM project_list 
    NATURAL JOIN project 
    NATURAL JOIN job_type 
    NATURAL JOIN user 

    WHERE user_id = $id";
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
            
        $pdf->Cell(22,10,iconv('UTF-8','cp874',$stmttasklistrow2['project_id']),1,0,"C");
        $pdf->Cell(40,10,iconv('UTF-8','cp874',$stmttasklistrow2['name_project']),1,0,"c");
        $pdf->Cell(42, 10, iconv('UTF-8', 'cp874', thai_date_short(strtotime($stmttasklistrow2['start_date']))) . ' - ' . iconv('UTF-8', 'cp874', thai_date_short(strtotime($stmttasklistrow2['end_date']))), 1, 0, "C");
        $pdf->Cell(18,10,iconv('UTF-8','cp874', $stmttasklistrow2['progress_project'].' '.'%'),1,0,"C"); 
       /*  $pdf->Cell(25,10,iconv('UTF-8','cp874',  $comptask2),1,0,"C");  */
        $pdf->Cell(35,10,iconv('UTF-8','cp874',showstatprotext1($stmttasklistrow2['status_1'])) .iconv('UTF-8','cp874',' ('.showstatprotext2($stmttasklistrow2['status_2']).' )') , 1, 0, "C");
        $pdf->Cell(35,10,iconv('UTF-8','cp874',$stmttasklistrow2['firstname'].' '.$stmttasklistrow2['lastname']),1,0,"c"); 
      /*   $pdf->Cell(25,10,iconv('UTF-8','cp874',showstattaskreport($stmttasklistrow2['status_task'])) .iconv('UTF-8','cp874',showstatustimepdf($stmttasklistrow2['status_timetask'])) , 1, 1, "C"); */
      $pdf->Ln(); 
            } 
       /*  /*  $pdf->Ln();  */
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