<?PHP 
   session_start();
   require_once 'connect.php';
if(isset($_POST['addpro'])){
    //print_r($_POST['users_id']); 
     
      $status1 = 1;
      $proname = $_POST['proname'];

      if(!empty($_POST['users_id'])){
      $users_id=$_POST['users_id'];
      }else {
        $_SESSION['error'] = 'กรุณาเพิ่มคนลงในโปรเจค'; 
        
      }

      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
      $description =$_POST['description'];
      $manager_id=$_SESSION['user_login'];
      $status2=$_POST['status2'];
      $file_project = null;
      $job = $_POST['job'];
      $user=json_encode($users_id);

   /*    echo $job; 
      echo $proname; 
      echo $start_date;
      echo $end_date;
      echo $description;
      echo $manager_id;
      echo $status2;

*/
      if (empty($proname)) {
       $_SESSION['error'] = 'กรุณากรอกชื่อโปรเจค';
       header('location:addproject_page.php');

     } else if (empty($start_date)) {
        $_SESSION['error'] ='กรุณากรอกวันที่เริ่ม';
        header('location:addproject_page.php');

   } else if (empty($end_date)) {
    $_SESSION['error'] = 'กรุณากรอกวันที่สิ้นสุด';
    header('location:addproject_page.php');

   }else if (!isset($_SESSION['error'])) {
        $stmtpro = $db->prepare("INSERT INTO project(name_project, description, status_1,start_date, end_date, file_project, manager_id,status_2,id_jobtype,users_id) 
      VALUES(:proname,:description,:status,:start_date,:end_date,:file_project,:manager_id,:status_2,:id_job,:users_id)");
       $stmtpro->bindParam(":proname", $proname);
       $stmtpro->bindParam(":description", $description);
       $stmtpro->bindParam(":status", $status1);
       $stmtpro->bindParam(":start_date", $start_date);
       $stmtpro->bindParam(":end_date", $end_date);
       $stmtpro->bindParam(":file_project",$file_project);
       $stmtpro->bindParam(":manager_id", $manager_id);
       $stmtpro->bindParam(":status_2", $status2);
       $stmtpro->bindParam(":id_job", $job);
       $stmtpro->bindParam(":users_id",$user );
       $stmtpro->execute(); 
       $lastId = $db->lastInsertId();
       
   }  
   if(!isset($_SESSION['error'])){
      foreach ($users_id as $id => $users_id){
      $sql= $db->prepare("INSERT INTO project_list(project_id,user_id) VALUES(:project_id,:user_id)");
      $sql->bindParam(":project_id", $lastId );
      $sql->bindParam(":user_id", $users_id );
      $sql->execute(); 
      $_SESSION['success'] = "เพิ่มโปรเจคเรียบร้อยแล้ว! ";
      header('location:addproject_page.php');
         
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