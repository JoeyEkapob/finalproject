<?php
    session_start();
    require_once 'connect.php';
    if(!isset($_SESSION['user_login'])){
         $_SESSION['error'] = '<center>กรุณาล็อกอิน</center>'; 
        header('location:sign-in.php');
    }
	 include "sidebar.php";
	 
	$user_id=$_SESSION['user_login'];
	$where ="";
/* 	$stmt = "SELECT * FROM user natural join position WHERE user_id = $user_id";
	$stmt = $db->prepare($stmt);
	$stmt ->execute();
	$stmt = $stmt->fetch(PDO::FETCH_ASSOC);

	$level = $stmt['level']; */

	$stmtusernum = "SELECT COUNT(user_id) as num FROM user  ";
	$stmtusernum = $db->prepare($stmtusernum);
	$stmtusernum ->execute();
	$stmtusernum = $stmtusernum->fetchColumn();


	if($level >= 2){
		$where = "   natural join project_list WHERE user_id = $user_id ";
	}

	$stmtprojectnum = "SELECT COUNT(project_id) as num1 FROM project   $where";
	$stmtprojectnum = $db->prepare($stmtprojectnum);
	$stmtprojectnum ->execute();
	$stmtprojectnum = $stmtprojectnum->fetchColumn();
	
	$stmttasknum = "SELECT COUNT(project_id) as num2 FROM task_list $where  ";
	$stmttasknum = $db->prepare($stmttasknum);
	$stmttasknum ->execute();
	$stmttasknum = $stmttasknum->fetchColumn();

	$state_details = "";
	if($level >= 2){
	$stmtdetails = "SELECT COUNT(details_id) as num3 FROM details WHERE state_details = 'Y'  ";
	}else{
	$stmtdetails = "SELECT COUNT(details_id) as num3 FROM details WHERE state_details = 'Y' AND  usersenddetails = $user_id ";
	}
	$stmtdetails = $db->prepare($stmtdetails);
	$stmtdetails ->execute();
	$stmtdetails = $stmtdetails->fetchColumn();
	//extract($row);
	//print_r ($num_rows); 
?>

<!DOCTYPE html>
<html lang="en">
<?php include "head.php"?>
<body>
	<?php include "funtion.php"?>
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
									<?php if ($level != 5): ?>
										<div class="col-sm-3">
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
														<h1 class="mt-1 mb-3"><?php echo $stmttasknum ?></h1>
														<div class="mb-0">
															<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
															<span class="text-muted">งานทั้งหมด</span>
														</div>
													</div>
												</div>
											</div>
										<div class="col-sm-3">
											<div class="card">
												<div class="card-body">
													<div class="row">
														<div class="col mt-0">
															<h5 class="card-title">หัวข้องาน</h5>
														</div>

														<div class="col-auto">
															<div class="stat text-primary">
																<i class="align-middle" data-feather="layers"></i>
															</div>
														</div>
													</div>
													<h1 class="mt-1 mb-3"><?php echo $stmtprojectnum ?></h1>
													<div class="mb-0">
														<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>  </span>
														<span class="text-muted">หัวข้องานทั้งหมด</span>
													</div>
												</div>
											</div>
										</div>
										<?php if ($level <= 2): ?>
										<div class="col-sm-3">
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
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
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

					<div class="row">
						<div class="col-12">
							<div class="card flex-fill">
								
								<div class="card-header">
									<h5 class="card-title mb-0">หัวข้องานของคุณ</h5>
								</div>
									<?php
										$i = 1;
										if($level >=2 ){
											$where = "  natural join project_list where user_id  = $user_id ";   
										}else {
											
										}

										$stmtshowproject = "SELECT * FROM project  $where ORDER BY  end_date,status_2  DESC LIMIT 5;";
										$stmtshowproject = $db->query($stmtshowproject);
										$stmtshowproject->execute();
									?>
									<table class="table table-hover my-0">
										<thead>
											<tr>
												<th class="text-center">ลำดับ</th>
												<th class="text-left">ชื่อโปรเจค</th>
												<th class="text-left">ความคืบหน้า</th>
												<th class="text-center">วันที่เริ่ม</th>
												<th class="text-center">วันที่สิ้นสุด</th>
												<th class="text-center">สถานะ</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
									<tbody>
											<tr>
													
												<?php while ($stmtshowprojectrow = $stmtshowproject->fetch(PDO::FETCH_ASSOC)){ ?>

													<td class="text-center"><?php echo $i++ ?></td>
														<td>
															<p><b><?php echo $stmtshowprojectrow["name_project"]?></b>
															<?php showstatpro2($stmtshowprojectrow['status_2']) ?></p>
															<p class="truncate"><?php echo substr($stmtshowprojectrow['description'],0,20).'...';  ?></p>
														
														</td>
													<td class="">
													
														<div class="progress mb-3">
										
															<div class="progress-bar progress-bar-striped progress-bar-animated-sm" role="progressbar" style="width:<?php echo $stmtshowprojectrow['progress_project'] ?>%" ><?php echo $stmtshowprojectrow['progress_project'] ?>%</div>
														</div>

													</td>

													<td class="text-center" ><?php echo ThDate($stmtshowprojectrow['start_date']) ?></td>
													<td class="text-center "><?php echo ThDate(($stmtshowprojectrow['end_date'])) ?></td>
													<td class="text-center">
														<?php
														/*  echo $stat1[$row['status_1']];
														exit; */
														showstatpro($stmtshowprojectrow['status_1']);									
														?>
													</td>
													<td class="text-center">                   
													<!--  <a class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">1</a>    -->                       
														<a class="btn btn-bitbucket btn-sm" href="view_project.php?view_id=<?php echo $stmtshowprojectrow['project_id']?>"><i data-feather="zoom-in"></i></a>
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
<?php include "footer.php"?>