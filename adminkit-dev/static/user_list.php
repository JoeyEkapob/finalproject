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
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
			
<main class="content">
    <div class="col-lg-12">
        <div class="card card-outline card-success">
            <div class="container-fluid p-0">
                <div class="card-header">
                    <div class="d-flex flex-row-reverse bd-highligh">
                        <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href=""><i class="fa fa-plus"></i>  + Add New User</a>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
						<div class="col-12 col-lg-8 col-xxl-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">สมาชิก</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
                                            <th class="text-center">ID</th>
											<th class="d-none d-xl-table-cell">NAME</th>
											<th class="d-none d-md-table-cell">Email</th>
											<th class="">ตำเเหน่ง</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
                                        $i = 1;
                                        //$type = array('',"Admin","คณบดี","รองคณบดีฝ่ายวิชาการ","ผู้ชวยรองรองคณบดีฝ่ายวิชาการ","หัวหน้าหน่วย","หัวสาขา","เจ้าหน้าที่");
                                        $sql = "SELECT *,concat(firstname,' ',lastname) as name 
                                        FROM user as u
                                        LEFT JOIN position AS p  ON  u.role_id = p.role_id
                                        order by concat(firstname,' ',lastname) asc ";
                                        $qry = $db->query($sql);
                                        $qry->execute();
                                        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                                            //print_r ($row);
					                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td><?php echo ucwords($row['name']) ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td class=""><?php echo $row['position_name']?></td>
                                        <td class="text-center">                               
                                            <a class="btn btn-primary btn-sm"  href="" >1</a>                          
                                            <a href="edituser.php?update_id=<?php echo $row['user_id']?>" class="btn btn-warning btn-sm">2</a>   
                                            <a class="btn btn-danger btn-sm" href="?delete_id=<?php echo $row['user_id']?>">trash</a>
                                        </td>
                                    </tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
    </main>
    <script src="js/app.js"></script>
    </body>
</html>