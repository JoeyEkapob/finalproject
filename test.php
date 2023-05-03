<?php
/*  1. เรียกไฟล์ "fpdf.php" (เครื่องมือช่วยในการออกแบบรายงานเป็น pdf)
    Link : http://fpdf.org/
*/
require("fpdf/fpdf.php");
$pdf = new FPDF(); //สร้าง Obj.
$pdf->AddFont('THSarabun','','THSarabun.php');
$pdf->AddFont('THSarabun','','THSarabun Bold.php');

$pdf->AddPage();
$pdf->SetFont('THSarabun','',16);
$pdf->Cell(40,10,iconv('UTF-8','cp874','Hello World! สารสนเทศ'));
$pdf->SetFont('THSarabun','',27);
$pdf->Cell(40,10,iconv('UTF-8','cp874','Hello World! สารสนเทศ'));
$pdf->Output();
?>