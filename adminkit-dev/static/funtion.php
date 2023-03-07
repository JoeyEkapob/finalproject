<?php
    function showstatpro($status){
        $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
        if($status =='1'){
            echo "<span class='badge bg-secondary'>".$stat1[$status]."</span>";
        }elseif($status =='2'){
            echo "<span class='badge bg-primary'>".$stat1[$status]."</span>";
        }elseif($status =='3'){
            echo "<span class='badge bg-danger'>".$stat1[$status]."</span>";
        }elseif($status =='4'){
            echo "<span class='badge bg-danger'>".$stat1[$status]."</span>";
        }
    }

    function showstatpro2($status_2){
        $stat2 = array("","งานปกติ","งานด่วน","งานด่วนมาก");
    if ($status_2 == '1') {
        echo " "."<span class='badge bg-secondary'>".$stat2[$status_2]."</span>";
    }else if($status_2 == '2'){
        echo " "."<span class='badge bg-warning'>".$stat2[$status_2]."</span>";
    }else if($status_2 == '3'){
        echo " "."<span class='badge bg-danger'>".$stat2[$status_2]."</span>";
                                       
        }
    }
 
    function showstattask($statustask){
        $stat1 = array("","รอดำเนินการ","กำลังดำเนินการ","ส่งเรียบร้อยเเล้ว","รอการเเก้ไข","เลยระยะเวลาที่กำหนด","ดำเนินการเสร็จสิ้น");
        if($statustask =='1'){
            echo "<span class='badge bg-secondary'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='2'){
            echo "<span class='badge bg-primary'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='3'){
            echo "<span class='badge bg-success'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='4'){
            echo "<span class='badge bg-warning'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='5'){
            echo "<span class='badge bg-danger'>".$stat1[$statustask]."</span>";
        }elseif($statustask =='6'){
            echo "<span class='badge bg-success'>".$stat1[$statustask]."</span>";
        } 
    }

    function ThDate($date2){
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
    
    return "วัน $ThDay[$week] 
            ที่ $day  
            $ThMonth[$months] 
            $years";
    }

?>