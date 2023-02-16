<?php
session_start();
include 'connect.php';

if(isset($_GET['delete_id'])){
    try {
 
    $id=$_GET['delete_id'];

        if(isset($id)){

        $sql = "SELECT * from project natural join file natural join file_item_project where project_id = $id ";
        $qry = $db->query($sql);
        $qry->execute();
        while ($row2 = $qry->fetch(PDO::FETCH_ASSOC)){  
            unlink("img/file/".$row2['filename']); 
        }


        $delete_task = $db->prepare('DELETE FROM task_list  WHERE project_id=:id');
        $delete_task->bindParam(':id', $id);
        $delete_task->execute(); 

        $delete_task = $db->prepare('DELETE project_list,file_item_project,file,project FROM project_list natural join file_item_project natural join file   natural join project WHERE project_id=:id');
        $delete_task->bindParam(':id', $id);
        $delete_task->execute();  
        
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