<?php
    session_start();
    include 'connect.php';
    if(isset($_GET['delete_id'])){
        try {
        $status = 2;
        $id=$_GET['delete_id'];
            /*  echo $id;
            exit;  */
            
            // delete an original record from db

            if(isset($id)){
            $delete_stmtjob = $db->prepare('UPDATE job_type SET status = :status WHERE id_jobtype = :id');
            $delete_stmtjob->bindParam(':status', $status);
            $delete_stmtjob->bindParam(':id', $id);
            $delete_stmtjob->execute();
            $_SESSION['success'] = "ลบประเภทงานเรียบร้อยแล้ว! ";
            header("location: jobtype_list.php");
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            header("location: jobtype_list.php");
        } 
        
            
    } catch(PDOException $e) {
        $e->getMessage();
    }
}   


