<?php 

require_once 'connect.php';

    $file_project = $_GET['file_project'];

    $stmt = $db->prepare("SELECT * FROM file_item_project WHERE file_item_project = :file_project");
    $stmt->bindParam(":file_project", $file_project);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $filename = $row['filename'];
    $filepath = "img/file/".$filename;

        header('Content-Disposition: attachment; filename=' . basename($filepath));
        readfile($filepath);


        
?>
