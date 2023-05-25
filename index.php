<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
	include "sidebar.php";

	$user_id=$_SESSION['user_login'];
	/* echo $user_id; */
	$where ="";
	$stmtusernum = "SELECT COUNT(user_id) as num FROM user  ";
	$stmtusernum = $db->prepare($stmtusernum);
	$stmtusernum ->execute();
	$stmtusernum = $stmtusernum->fetchColumn();
/* 	echo $stmtusernum ; */

	 if($level >= 2){
		$where = "   and user_id  = $user_id ";
	 }
	$stmtprojectnumuser = "SELECT COUNT(pl.project_id) as num1 FROM project_list as pl  left join  project as p on pl.project_id = p.project_id WHERE 1=1  $where";
	$stmtprojectnumuser = $db->prepare($stmtprojectnumuser);
	$stmtprojectnumuser ->execute();
	$stmtprojectnumuser = $stmtprojectnumuser->fetchColumn();

	if($level >= 2){
		$where = "   where manager_id = $user_id ";
	 }
	$stmtprojectnummanager = "SELECT COUNT(project_id) as num1 FROM project   $where";
	$stmtprojectnummanager = $db->prepare($stmtprojectnummanager);
	$stmtprojectnummanager ->execute();
	$stmtprojectnummanager = $stmtprojectnummanager->fetchColumn();


	if($level >= 2){
		$where = "   and user_id = $user_id    ";
	 }
	$stmttasknum = "SELECT COUNT(task_id) as num2 FROM task_list as t left join project as p on t.project_id = p.project_id WHERE  status_1 !=3 AND  progress_task != 100 AND status_task != 5 AND status_task2 != 1 $where ";
	$stmttasknum = $db->prepare($stmttasknum);
	$stmttasknum ->execute();
	$stmttasknum = $stmttasknum->fetchColumn(); 

	$sql4 = $db->query("SELECT task_id  FROM task_list as t left join project as p on t.project_id = p.project_id WHERE  1=1 $where ");
    $numusertask = $sql4->rowCount();  	

	$sql5 = $db->query("SELECT * FROM task_list WHERE user_id = $user_id AND status_task != 5 AND progress_task != 100 $where  ");
	$numtaskonpro = $sql5->rowCount(); 

	$stmttaskpnum = "SELECT COUNT(task_id) FROM task_list as t left join project as p on t.project_id = p.project_id  where p.status_1 !=3 AND t.progress_task != 100 AND t.status_task != 5 AND status_timetask = 2  AND status_task2 != 1 $where ";
	$stmttaskpnum = $db->prepare($stmttaskpnum);
	$stmttaskpnum ->execute();
 	$stmttaskpnum = $stmttaskpnum->fetchColumn(); 

	 $sql6 = $db->query("SELECT * FROM task_list WHERE user_id = $user_id AND status_timetask = 2 AND status_task != 5 AND progress_task != 100  $where ");
	 $numtimede = $sql6->rowCount();

	 if($level >= 2){
		$where = "and  p.manager_id = $user_id "; 
	} 
	
	$stmtdetails = "SELECT COUNT(details_id)  FROM details as d left join project as p on p.project_id = d.project_id WHERE state_details = 'Y' $where ";
	$stmtdetails = $db->prepare($stmtdetails);
	$stmtdetails ->execute();
	$stmtdetails = $stmtdetails->fetchColumn(); 
/* 
	print_r($stmtdetails); */
	//extract($row);
	//print_r ($num_rows); 
?>

<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body> 

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
			<main class="content">
				<div class="container-fluid p-0">

					<!-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> -->
					
					<div class="row">
						<div class="col-xxl-12 col-xxl- d-flex">
							<div class="w-100">
								<div class="row">
									<?php if ($level != $maxlevel): ?>
								
										<div class="col-sm-3">
											<a href="checktask_list.php">
												<div class="card">
													<div class="card-body">
														<div class="row">
															<div class="col mt-0">
																<h5 class="card-title">งานที่ต้องตรวจ</h5>
															</div>

															<div class="col-auto">
																<div class="stat text-primary">
																	<i class="align-middle" data-feather="clipboard"></i>
																</div>
															</div>
														</div>
														<h1 class="mt-1 mb-3"><?php echo $stmtdetails; ?></h1>
														<div class="mb-0">
															<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
															<span class="text-muted">งานที่ต้องตรวจทั้งหมด</span>
														</div>
													</div>
												</div>
											</a>
										</div>
								
									<?php endif ?>
									<?php if ($level > 2): ?>
									<div class="col-sm-3">
											<div class="card">
												<div class="card-body">
													<div class="row">
														<div class="col mt-0">
															<h5 class="card-title">งานล่าช้า</h5>
														</div>

														<div class="col-auto">
															<div class="stat text-primary">
																<i class="align-middle" data-feather="list"></i>
															</div>
														</div>
													</div>
													<h1 class="mt-1 mb-3"><?php echo $stmttaskpnum  ?></h1>
													<div class="mb-0">
														<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
														<span class="text-muted">งานทั้งหมดที่ล่าช้า</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-3">
												<div class="card">
													<div class="card-body">
														<div class="row">
															<div class="col mt-0">
																<h5 class="card-title">งานค้าง</h5>
															</div>

															<div class="col-auto">
																<div class="stat text-primary">
																	<i class="align-middle" data-feather="list"></i>
																</div>
															</div>
														</div>
														<h1 class="mt-1 mb-3"><?php echo $numtaskonpro ?></h1>
														<div class="mb-0">
															<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
															<span class="text-muted">งานค้างทั้งหมด</span>
														</div>
													</div>
												</div>
											</div>
											
											<?php endif ?>
											<div class="col-sm-3">
												<div class="card">
													<div class="card-body">
														<div class="row">
															<div class="col mt-0">
																<h5 class="card-title">งาน</h5>
															</div>

															<div class="col-auto">
																<div class="stat text-primary">
																	<i class="align-middle" data-feather="list"></i>
																</div>
															</div>
														</div>
														<h1 class="mt-1 mb-3"><?php echo $numusertask ?></h1>
														<div class="mb-0">
															<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
															<span class="text-muted">งานทั้งหมด</span>
														</div>
													</div>
												</div>
											</div>
										<?php if ($level > 2): ?>
										<div class="col-sm-3">
											<a href="project_list_user.php">
												<div class="card">
													<div class="card-body">
														<div class="row">
															<div class="col mt-0">
																<h5 class="card-title">หัวข้องานที่ได้รับ</h5>
															</div>

															<div class="col-auto">
																<div class="stat text-primary">
																	<i class="align-middle" data-feather="layers"></i>
																</div>
															</div>
														</div>
														<h1 class="mt-1 mb-3"><?php echo $stmtprojectnumuser ?></h1>
														<div class="mb-0">
															<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
															<span class="text-muted">หัวข้องานที่ได้รับมอบหมายทั้งหมด</span>
														</div>
													</div>
												</div>
											</a>
										</div>
										<?php endif ?>
										<?php if ($level != $maxlevel): ?>
										<div class="col-sm-3">
											<a href="project_list.php">
												<div class="card">
													<div class="card-body">
														<div class="row">
															<div class="col mt-0">
																<h5 class="card-title">หัวข้องานที่สร้าง</h5>
															</div>

															<div class="col-auto">
																<div class="stat text-primary">
																	<i class="align-middle" data-feather="layers"></i>
																</div>
															</div>
														</div>
														<h1 class="mt-1 mb-3"><?php echo $stmtprojectnummanager ?></h1>
														<div class="mb-0">
															<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
															<span class="text-muted">หัวข้องานที่สร้างทั้งหมด</span>
														</div>
													</div>
												</div>
											</a>
										</div>
										<?php endif ?>
										<?php if ($level <= 2): ?>
										<div class="col-sm-3">
											<a href="user_list.php">
												<div class="card">
													<div class="card-body">
														<div class="row">
															<div class="col mt-0">
																<h5 class="card-title">สมาชิก</h5>
															</div>
		
															<div class="col-auto">
																<div class="stat text-primary">
																	<i class="align-middle" data-feather="users"></i>
																</div>
															</div>
														</div>
													<h1 class="mt-1 mb-3"><?php echo $stmtusernum ?></h1>
													<div class="mb-0">
														<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i></span>
														<span class="text-muted">สมาชิกทั้งหมด</span>
													</div>
												</div>
											</a>
										</div>
										<?php endif; ?>
									</div>
								</div>
						<!-- 	</div> -->
						</div>
					</div>
						<!-- <div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Recent Movement</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="chartjs-dashboard-line"></canvas>
									</div>
								</div>
							</div>
						</div> -->
					<!-- </div> -->

					<div class="row">
						<!-- <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Browser Usage</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div>

										<table class="table mb-0">
											<tbody>
												<tr>
													<td>Chrome</td>
													<td class="text-end">4306</td>
												</tr>
												<tr>
													<td>Firefox</td>
													<td class="text-end">3801</td>
												</tr>
												<tr>
													<td>IE</td>
													<td class="text-end">1689</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div> -->
						<!-- <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Real-Time</h5>
								</div>
								<div class="card-body px-4">
									<div id="world_map" style="height:350px;"></div>
								</div>
							</div>
						</div> -->
						<!-- <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Calendar</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="chart">
											<div id="datetimepicker-dashboard"></div>
										</div>
									</div>
								</div>
							</div>
						</div> -->
					</div>

				
						<div class="col-12">
							<div class="card flex-fill">
								
								<div class="card-header">
									<h5 class="card-title mb-0">หัวข้องานของคุณ</h5>
								</div>
									<?php
										$i = 1;
									/* 	echo $level; */
										if($level >=2 ){
											$where = "  natural join project_list where user_id  = $user_id AND status_1 = 1";   
										}
										$stmtshowproject = "SELECT * FROM project  $where ORDER BY  end_date,status_2  DESC LIMIT 5;";
										$stmtshowproject = $db->query($stmtshowproject);
										$stmtshowproject->execute();
									?>
								<div class="table-responsive-xl">
									<table class="table table-hover">
										<thead>
											<tr>
												<th class="id-col">ลำดับ</th>
												<th class="name-col">ชื่อหัวข้องาน</th>
												<th class="progress-col" >ความคืบหน้า</th>
												<th class="start-col">วันที่เริ่ม</th>
												<th class="end-col">วันที่สิ้นสุด</th>
												<th class="status-col">สถานะ</th>
												<th class="action-col">Action</th>
											</tr>
										</thead>
									<tbody>
											<tr>
													
												<?php while ($stmtshowprojectrow = $stmtshowproject->fetch(PDO::FETCH_ASSOC)){ ?>

													<td class="id-col"><?php echo $i++ ?></td>
													<td class="name-col">
														<p><b><?php echo $stmtshowprojectrow["name_project"]?></b>
														<?php showstatpro2($stmtshowprojectrow['status_2']) ?></p>
														<p class="truncate"><?php echo mb_substr($stmtshowprojectrow['description'],0,20).'...';  ?></p>
													</td>
													<td class="progress-col">
														<div class="progress mb-3">
															<div class="progress-bar progress-bar-striped progress-bar-animated-sm" role="progressbar" style="width:<?php echo $stmtshowprojectrow['progress_project'] ?>%" ><?php echo $stmtshowprojectrow['progress_project'] ?>%</div>
														</div>
													</td>

													<td class="start-col " ><?php echo ThDate($stmtshowprojectrow['start_date']) ?></td>
													<td class="end-col "><?php echo ThDate(($stmtshowprojectrow['end_date'])) ?></td>
													<td class="status-col">
														<?php showstatpro($stmtshowprojectrow['status_1']);	?>
													</td>
													<td class="action-col">                   
													<!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                       
														<a class="btn btn-bitbucket btn-sm" title="ดูรายละเอียดงาน" href="view_project.php?view_id=<?php echo $stmtshowprojectrow['project_id']?>"><i data-feather="zoom-in"></i></a>
														<!-- <a href="editproject.php?update_id=<?php echo $stmtshowprojectrow['project_id']?>" class="btn btn-warning btn-sm">2</a>
														<a href="deleteproject.php?delete_id=<?php echo $stmtshowprojectrow['project_id']?>" class="btn btn-danger btn-sm" >trash</a> -->
														
														</td>
													</tr>
												
										<?php } ?>
									</tbody>           
								</table>
							</div>	
						</div>
					</div>
				</div>

		
			</main>

			<!-- <footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a>								&copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer> -->
		</div>
	</div>



	

</body>

</html>
<script> 

</script> 
<?php include "footer.php"?>