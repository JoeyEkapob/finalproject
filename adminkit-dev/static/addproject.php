<?PHP 
   session_start();
   require_once 'connect.php';
if(isset($_POST['addpro'])){
    //print_r($_POST['users_id']); 
     
      $status1 = 1;
      $proname = $_POST['proname'];
      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
      $description =$_POST['description'];
      $manager_id=$_SESSION['user_login'];
      $status2=$_POST['status2'];
      $file_project = null;
      $job = $_POST['job'];

      $users_id1=$_POST['users_id']; // รับค้ามาเป็น arery id เดียว
      //$numbers_string = implode(",", $users_id1); // implode ลูกน้ำเข้าไปเเล้วทำให้เป็น string
      $users_id = explode(",", $users_id1); // เเล้วก็นำ string มาทำเป็น array หลาย id 
     /* echo $job; 
      echo $proname; 
      echo $start_date;
      echo $end_date;
      echo $description;
      echo $manager_id;
      echo $status2;*/
        /* print_r ($users_id);
      exit;  */


     if (empty($proname)) {
       $_SESSION['error'] = 'กรุณากรอกชื่อโปรเจค';
       header('location:addproject_page.php');

   } else if (empty($start_date)) {
        $_SESSION['error'] ='กรุณากรอกวันที่เริ่ม';
        header('location:addproject_page.php');

   } else if (empty($end_date)) {
    $_SESSION['error'] = 'กรุณากรอกวันที่สิ้นสุด';
    header('location:addproject_page.php');

   } else if (empty($users_id1)) {
      $_SESSION['error'] = 'ใส่ชื่อสมาชิก';
      header('location:addproject_page.php');
   
   } else if(!isset($_SESSION['error'])) {
       $inserstmtpro = $db->prepare("INSERT INTO project(name_project, description, status_1,start_date, end_date, file_project, manager_id,status_2,id_jobtype) 
      VALUES(:proname,:description,:status,:start_date,:end_date,:file_project,:manager_id,:status_2,:id_job)");
       $inserstmtpro->bindParam(":proname", $proname);
       $inserstmtpro->bindParam(":description", $description);
       $inserstmtpro->bindParam(":status", $status1);
       $inserstmtpro->bindParam(":start_date", $start_date);
       $inserstmtpro->bindParam(":end_date", $end_date);
       $inserstmtpro->bindParam(":file_project",$file_project);
       $inserstmtpro->bindParam(":manager_id", $manager_id);
       $inserstmtpro->bindParam(":status_2", $status2);
       $inserstmtpro->bindParam(":id_job", $job);
       $inserstmtpro->execute(); 
       $lastId = $db->lastInsertId();
    
      foreach ($users_id as $id => $users_id){
      $inserstmtprolist= $db->prepare("INSERT INTO project_list(project_id,user_id) VALUES(:project_id,:user_id)");
      $inserstmtprolist->bindParam(":project_id", $lastId );
      $inserstmtprolist->bindParam(":user_id", $users_id );
      $inserstmtprolist->execute(); 
    
      $_SESSION['success'] = "เพิ่มโปรเจคเรียบร้อยแล้ว! ";
      header('location:project_list.php');
     
   }  
   }else {
      $_SESSION['error']= "มีบางอย่างผิดพลาด";
      header('location:addproject_page.php');
     
     }       

} 
/* $stmt = $db->query("SELECT * FROM project where project_id=2");
$stmt->execute();
$result = $stmt->fetchAll();
$json='';
foreach($result as $row) {
   $json = $row['users_id'];

}
$array = json_decode($json);
   foreach($array as $value) {
       $stmt1 = $db->query("SELECT * FROM user where user_id= $value ");
       $stmt1->execute();
       $result1 = $stmt1->fetchAll();
       foreach($result1 as $row1) {
          echo $row1['user_id'];
          echo $row1['firstname'];
   
       }
   }  */



?>