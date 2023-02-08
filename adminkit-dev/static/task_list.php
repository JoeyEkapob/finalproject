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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css"  
<?php include "sidebar.php"?>

<?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>

<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
    <main class="content">
    <?php if($row['level'] != 5 ): ?>
       <!--  <div class="col-lg-12">
            <div class="card card-outline card-success">
                <div class="container-fluid p-0">
                    <div class="card-header">
            
                        
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="addproject_page.php"><i class="fa fa-plus"></i>  + เพิ่มโปรเจค</a>
                            
                        </div>
                 
                    </div>
                </div>
            </div>
        </div> -->
        <?php endif; ?>
           
                 
                          
                   
                        
                  
        </main>
        
</form>

    </body>
</html>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});
</script>
<?php include "footer.php"?>