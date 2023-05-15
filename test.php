<?php

require_once('vendor/autoload.php');

// create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

/* define('THSarabun', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts/THSarabun.ttf', 'TrueTypeUnicode'));
define('THSarabunBold', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts/THSarabun Bold.ttf', 'TrueTypeUnicode'));

define('PROMPT_REGULAR', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts//Prompt-Regular.ttf', 'TrueTypeUnicode'));
define('PROMPT_BOLD', TCPDF_FONTS::addTTFfont(dirname(__FILE__).'/vendor/tecnickcom/tcpdf/fonts/Prompt-Bold.ttf', 'TrueTypeUnicode'));
 */
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->setPrintHeader(false);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();
/* $pdf->AddFont('THSarabunb','B','/vendor/tecnickcom/tcpdf/fonts/THSarabun Bold.ttf');
$pdf->AddFont('THSarabun','','/vendor/tecnickcom/tcpdf/fonts/THSarabun.ttf'); */

$pdf->SetFont('THSarabun', '', 14);
$pdf->Write(0, 'หกดหกดหกหกดหกดหกด');
$pdf->SetFont('THSarabunb', '', 14);
$pdf->Write(0, 'หกดหกดหกหกดหกดหกด');

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('hello-tcpdf.pdf', 'I');
$pdf->Close();