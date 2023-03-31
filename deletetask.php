<?php
session_start();
include 'connect.php';

if(isset($_GET['delete_id'])){
    try {
    $pro_id=$_GET['project_id']; 
    $id=$_GET['delete_id'];
    
        
        if(isset($id)){
        $delete_task = $db->prepare('DELETE FROM task_list WHERE task_id = :id');
        $delete_task->bindParam(':id', $id);
        $delete_task->execute();
        $_SESSION['success'] = "ลบงานเรียบร้อยแล้ว!";
        header('location:view_project.php?view_id='.$pro_id);
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header('location:view_project.php?view_id='.$pro_id);
    } 
    
        
} catch(PDOException $e) {
    $e->getMessage();
}
}   

?>