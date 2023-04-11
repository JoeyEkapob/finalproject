<?php
    include 'connect.php';

    if(isset($_GET['delete_id'])){

        $id=$_GET['delete_id'];
            /* echo $id;
            exit; */
            $select_stmt = $db->prepare('SELECT * FROM user WHERE user_id = :id');
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            unlink("img/avatars/".$row['avatar']); 
    
            
            $delete_stmt = $db->prepare('DELETE FROM user WHERE user_id = :id');
            $delete_stmt->bindParam(':id', $id);
            $delete_stmt->execute();
    
            header("Location: user_list.php");


}   



?>
