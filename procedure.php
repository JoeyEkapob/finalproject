<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
<?php include "sidebar.php"?>
        <div class="text-center">  
        
            <div class="pt-5 px-3">

                <h1 class="display-4 fw-bold  ">วิธีสร้าง LINE Notify</h1>
                <p class="lead mt-3"> เป็นขั้นตอนการสร้าง LINE Notify เพื่อนำ token ไปใช้งานในระบบแจ้งเตือนระบบมอบหมายงาน มีขั้นตอนดังนี้</p>

            </div>

            <div class="overflow-hidden" style="max-height: 100%;">
                <div class="px-5">
                
                    <img src="pic/img1.png" class="img-fluid"> 
                    <p>1. เข้าไปที่ 
                    <a href="https://notify-bot.line.me">  https://notify-bot.line.me</a> แล้วเข้าสู่ระบบ
                    </p>
        
                    <img src="pic/img2.png" class="img-fluid">
                    <p>2. หลังจากเข้าสู่ระบบแล้วให้เข้าเมนู “หน้าของฉัน”</p>
                    
                    <img src="pic/img3.png" class="img-fluid">
                    <p>3. ต่อมาเลือกปุ่มออก “Token” </p>
                
                    <img src="pic/img4.png" class="img-fluid">
                    <p>4. ใส่ชื่อ Token ตามที่ต้องการ พร้อมกับเลือกหัวข้อ รับการแจ้งเตือนแบบตัวต่อจาก LINE Notify และกดปุ่ม ออก Token</p>

                    <img src="pic/img5.png" class="img-fluid" >
                    <p>5. เว็บจะแสดงรหัสให้ทำการคัดลอกรหัส</p>
            
                    <img src="pic/img6.png" class="img-fluid" >
                    <p >6. เมื่อสมัครเสร็จแล้ว หน้าจอจะแสดงบริการที่เชื่อมต่อ เป็นอันสิ้นสุดขั้นตอนสมัครใช้บริการ LINE Notify </p>
            
                </div>
                
            </div>
            
        </div>
  

</body>
</html>
<?php include "footer.php"?>