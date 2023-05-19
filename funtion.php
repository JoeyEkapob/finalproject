<?php
    function showstatpro($status){
        $stat1 = array("","รอดำเนินการ","เลยระยะเวลา","ปิดโปรเจค");
        if($status =='1'){
            echo "<span class='badge bg-secondary'>".$stat1[$status]."</span>";
        }elseif($status =='2'){
            echo "<span class='badge bg-warning'>".$stat1[$status]."</span>";
        }elseif($status =='3'){
            echo "<span class='badge bg-danger'>".$stat1[$status]."</span>";
        }
    }

    function showstatpro2($status_2){
        $stat2 = array("","ปกติ","ด่วน","ด่วนมาก");
    if ($status_2 == '1') {
        echo " "."<span class='badge bg-secondary'>".$stat2[$status_2]."</span>";
    }else if($status_2== '2'){
        echo " "."<span class='badge bg-warning'>".$stat2[$status_2]."</span>";
    }else if($status_2 == '3'){
        echo " "."<span class='badge bg-danger'>".$stat2[$status_2]."</span>";
                                       
        }
    }

    function showstatustime($statustime){
    if ($statustime == '') {
        return "";
    }else if($statustime == '1'){
        return "( เเจ้งเตือน )";
    }else if($statustime == '2'){
        return " <b style='color:red'> ( ล่าช้า ) </b>";
    }else if($statustime == '3'){
        return " <b style='color:red'> ( ยกเลิกงาน ) </b>";
        }
    }    

    function showstatustimepdf($statustime){
        if ($statustime == '') {
            return "";
        }else if($statustime == '1'){
            return "( เเจ้งเตือน )";
        }else if($statustime == '2'){
            return " (ล่าช้า)";
        }else if($statustime == '3'){
                return " (ยกเลิกงาน)";
        }
    }   
    function showstatprotext1($status){
        if ($status == '1') {
            return "รอดำเนินการ";
        }else if($status== '2'){
            return "เลยระยะเวลา";
        }else if($status == '3'){
            return "ปิดโปรเจค";
                                           
            }
        }

    function showstattask2($status){
        if ($status == '1') {
            return "<span class='badge bg-danger'> ยกเลิกงาน </span>";
        }
    }
    function showstattask2pdf($status){
        if ($status == '1') {
            return "ยกเลิกงาน";
        }
    }

    function showstatprotext2($status_2){
    if ($status_2 == '1') {
        return "งานปกติ";
    }else if($status_2== '2'){
        return "งานด่วน";
    }else if($status_2 == '3'){
        return "งานด่วนมาก";
                                       
        }
    }
    function showstatuser($statususer){
        if ($statususer == '1') {
            return "<span class='badge bg-success'> เปิด </span>";
        }else if($statususer== '0'){
            return "<span class='badge bg-secondary'> ปิด </span>";
        }
    }
    function showstattask($statustask){
        $stat1 = array("","รอดำเนินการ","ส่งเเล้ว","รอเเก้ไข","เลยเวลา","เสร็จสิ้น");
        if($statustask =='1'){
            echo "<span class='badge bg-primary'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='2'){
            echo "<span class='badge bg-success'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='3'){
            echo "<span class='badge bg-warning'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='4'){
            echo "<span class='badge bg-warning'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='5'){
            echo "<span class='badge bg-danger'>".$stat1[$statustask]."</span>";
        } 
    }

    function showstattaskreport($statustask){
        $stat1 = array("","รอดำเนินการ","ส่งเเล้ว","รอเเก้ไข","เลยเวลา","เสร็จสิ้น");
        if($statustask =='1'){
            return "รอดำเนินการ";
        }elseif($statustask =='2'){
            return "ส่งเเล้ว";
        }elseif($statustask =='3'){
            return "รอเเก้ไข";
        }elseif($statustask =='4'){
            return "เลยเวลา";
        }elseif($statustask =='5'){
            return "เสร็จสิ้น";
        } 
    }
    function showstatdetail($statusdetail){
        if($statusdetail =='Y'){
            return "รอตรวจ";
        }elseif($statusdetail =='N'){
            return "ตรวจเเล้ว";
        } 
    }

    function showtdetailtext($detail){
        if($detail =='1'){
            return "ลากิจ";
        }elseif($detail =='2'){
            return "ลาป่วย";
        } elseif($detail =='3'){
            return "ติดงานราชการด่วน";
        } elseif($detail =='4'){
            return "แก้ไขงาน";
        } 
    }

    function showshortname($shortname){
        if($shortname =='1'){
            return "นาย";
        }elseif($shortname =='2'){
            return "นางสาว";
        } elseif($shortname =='9'){
            return "นาง";
        } elseif($shortname =='3'){
            return "ดร.";
        } elseif($shortname =='4'){
        return "ผศ.";
        } elseif($shortname =='5'){
            return "รศ.";
        } elseif($shortname =='6'){
            return "ศ.";
        } elseif($shortname =='7'){
            return "ผศ.ดร.";
        } elseif($shortname =='8'){
            return "ศ.ดร."; 
        }elseif($shortname =='10'){
            return "อาจารย์"; 
        } elseif($shortname =='11'){
            return "Mr."; 
        }elseif($shortname =='12'){
            return "Ms"; 
        }
        }


    function ThDate($date2){
        if (empty($date2)){
            return "";
        }
    //วันภาษาไทย

    $ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์" );
    //เดือนภาษาไทย
    $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
    
    //วันที่ ที่ต้องการเอามาเปลี่ยนฟอแมต
    //อาจมาจากฐานข้อมูล
    //กำหนดคุณสมบัติ
    $week = date("w",strtotime($date2)); // ค่าวันในสัปดาห์ (0-6)
    $months = date("m",strtotime($date2))-1; // ค่าเดือน (1-12)
    $day = date("d",strtotime($date2)); // ค่าวันที่(1-31)
    $years = date("Y",strtotime($date2))+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.
    $time = " เวลา ".date("H:i",strtotime($date2));

    return "วัน$ThDay[$week] ที่ $day $ThMonth[$months] $years  ";
    }
  
    $dayTH = [null,'อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
    $monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    $monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
    function thai_date_and_time($time){   // 19 ธันวาคม 2556 เวลา 10:10:43
        global $dayTH,$monthTH;   
        $thai_date_return= " วัน ".$dayTH[date("w",strtotime($time))];
        $thai_date_return.=" ที่  ".date("d",strtotime($time));   
        $thai_date_return.=" ".$monthTH[date("n",strtotime($time))];   
        $thai_date_return.= " ".(date("Y",strtotime($time))+543);   
        $time= " เวลา ".date("H:i",strtotime($time))." น. ";
        return "$thai_date_return <br> $time" ;   
    } 
    function thai_date_and_time_short($time){   // 19  ธ.ค. 2556 10:10:4
        global $dayTH,$monthTH_brev;   
        $thai_date_return = date("j",strtotime($time));   
        $thai_date_return.=" ".$monthTH_brev[date("n",strtotime($time))];   
        $thai_date_return.= " ".(date("Y",strtotime($time))+543);   
        $thai_date_return.= " เวลา ".date("H:i",strtotime($time))." น. ";
        return $thai_date_return;   
    } 
    function thai_date_short($time){   // 19  ธ.ค. 2556a
        global $dayTH,$monthTH_brev;   
        $thai_date_return = date("j",$time);   
        $thai_date_return.=" ".$monthTH_brev[date("n",$time)];   
        $thai_date_return.= " ".(date("Y",$time)+543);   
        return $thai_date_return;   
    } 
    function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
        global $dayTH,$monthTH;   
        $thai_date_return = date("j",$time);   
        $thai_date_return.=" ".$monthTH[date("n",$time)];   
        $thai_date_return.= " ".(date("Y",$time)+543);   
        return $thai_date_return;   
    } 
    function thai_date_short_number($time){   // 19-12-56
        global $dayTH,$monthTH;   
        $thai_date_return = date("d",$time);   
        $thai_date_return.="-".date("m",$time);   
        $thai_date_return.= "-".substr((date("Y",$time)+543),-2);   
        return $thai_date_return;   
    }  
   
    ?>

