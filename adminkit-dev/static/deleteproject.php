<?php
session_start();
include 'connect.php';

if(isset($_GET['delete_id'])){
    try {
 
    $id=$_GET['delete_id'];

        if(isset($id)){
        $delete_task = $db->prepare('DELETE FROM task_list WHERE project_id = :id');
        $delete_task->bindParam(':id', $id);
        $delete_task->execute();  
        
        $delete_prolist = $db->prepare('DELETE FROM project_list WHERE project_id = :id');
        $delete_prolist->bindParam(':id', $id);
        $delete_prolist->execute();
   
        $delete_pro = $db->prepare('DELETE FROM project WHERE project_id = :id');
        $delete_pro->bindParam(':id', $id);
        $delete_pro->execute();
      
        $_SESSION['success'] = "ลบหัวข้องานเรียบร้อยแล้ว!";
        header('location:project_list.php');
        
        } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header('location:project_list.php');
            } 
    
        
    }catch(PDOException $e) {
    $e->getMessage();
    }
}   

?>