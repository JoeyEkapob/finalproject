<?php 
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