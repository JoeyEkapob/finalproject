<?php
    require_once 'connect.php';
    require  'fpdf/fpdf.php';
    include "funtion.php";
    date_default_timezone_set('asia/bangkok');
    $date = date ("Y-m-d");

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
$pdf->Cell(190,70,iconv('UTF-8','cp874','รายงาน'),0,0,"C");

$pdf->SetY(50);
/* $pdf->SetFont('THSarabun','',14); */


/* $pdf->SetFillColor(100,0,0); */
$pdf->setDrawColor(100,100,100); 
$pdf->SetFont('THSarabunb','B',14); 
$pdf->Cell(22,10,iconv('UTF-8','cp874','รหัสหัวข้องาน'),1,0,"C");
$pdf->Cell(40,10,iconv('UTF-8','cp874','ชื่อหัวข้องาน'),1,0,"C");
$pdf->Cell(40,10,iconv('UTF-8','cp874','ประเภทงาน'),1,0,"C");
$pdf->Cell(17,10,iconv('UTF-8','cp874','จำนวนงาน'),1,0,"C");
$pdf->Cell(17,10,iconv('UTF-8','cp874','งานที่เสร็จ'),1,0,"C");
$pdf->Cell(17,10,iconv('UTF-8','cp874','ความสำเร็จ'),1,0,"C");
$pdf->Cell(40,10,iconv('UTF-8','cp874','คนที่มอบหมาย'),1,0,"C");
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
        $pdf->Cell(40,10,iconv('UTF-8','cp874',$array['name_jobtype']),1,0,"c");
        $pdf->Cell(17,10,iconv('UTF-8','cp874',$numtask ),1,0,"C");
        $pdf->Cell(17,10,iconv('UTF-8','cp874',$comptask2),1,0,"C");
        $pdf->Cell(17,10,iconv('UTF-8','cp874',$array['progress_project'].' '.'%'),1,0,"C");
        $pdf->Cell(40,10,iconv('UTF-8','cp874',$array['firstname'].' '.$array['lastname']),1,1,"c");

        } 
   /*  $pdf->Ln(); */
    } else{

        $pdf->Cell(193,10,iconv('UTF-8','cp874','ไม่พอข้อมูล'),1,1,"C");
    }
$pdf->SetFont('THSarabun','',10); 
$pdf->Cell(193,8,iconv('UTF-8','cp874','ผู้พิมพ์ fdsfffffffffffffffffffffffffffffffff'),0,1,"R");
$pdf->Cell(193,3,iconv('UTF-8','cp874','วันที่พิมพ์ '.ThDate($date).''),0,0,"R");


$pdf->Output();
ob_end_flush();

