<?php
//call main fpdf file
class PDF_MC_Table extends FPDF {

    // variable to store widths and aligns of cells, and line height
    var $widths;
    var $aligns;
    var $lineHeight;
    
    
    //Set the array of column widths
    function SetWidths($w){
        $this->widths=$w;
    }
    
    //Set the array of column alignments
    function SetAligns($a){
        $this->aligns=$a;
    }
    
    //Set line height
    function SetLineHeight($h){
        $this->lineHeight=$h;
    }
    
    //Calculate the height of the row
    function Row($data)
    {
        // number of line
        $nb=0;
    
        // loop each data to find out greatest line number in a row.
        for($i=0;$i<count($data);$i++){
            // NbLines will calculate how many lines needed to display text wrapped in specified width.
            // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        }
        
        //multiply number of line with line height. This will be the height of current row
        $h=$this->lineHeight * $nb;
    
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
    
        //Draw the cells of current row
        for($i=0;$i<count($data);$i++)
        {
            // width of the current col
            $w=$this->widths[$i];
            // alignment of the current col. if unset, make it left.
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
         /*    echo $w.' '.$h; */
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,8,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
           
        }
        //Go to the next line
        $this->Ln($h);
    }
    
    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
    
    function NbLines($w,$txt)
    {
        //calculate the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
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
?>