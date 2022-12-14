<?php include "head.php"?>
<?php
            if (isset($_SESSION['user_login'])) {
                $user_id = $_SESSION['user_login'];
             //echo $admin_id ;
			 	$sql = "SELECT * FROM user AS u  LEFT JOIN position AS p ON  u.role_id = p.role_id WHERE u.user_id = $user_id ";
				$stmt = $db->prepare($sql);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
				$imageURL = 'img/avatars/'.$row['avatar'];
				//print_r ($row);
            }
			
?>
<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.php">
				<?php if($row['level'] ==  1): ?>
				<span class="align-middle">Admin <?php echo $row['firstname'] ?></span>
				<?php else: ?>
					<span class="align-middle">user <?php echo $row['firstname'] ?></span>
					<?php endif; ?>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Pages
					</li>
				
				
					<li class="sidebar-item">
						<a class="sidebar-link" href="index.php">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">หน้าหลัก</span>
            </a>
					</li>

					<?php if($row['level'] != 5 ): ?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="">
              <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">+เพิ่มโปรเจค</span>
            </a>
					</li>
					<?php endif; ?>
					

					<li class="sidebar-item">
						<a class="sidebar-link" href="">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">รายการโปรเจค</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">รายการงาน</span>
            </a>
					</li>
					 <li class="sidebar-item">
						<a class="sidebar-link" href="">
              <i class="align-middle" data-feather="menu"></i> <span class="align-middle">รายงาน</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="">
              <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">ตรวจงาน</span>
            </a>
					</li>

					<?php if($row['level'] == 1 && 2): ?>
					<li class="sidebar-header">
						USER
					</li>
					<?php endif; ?>
					<?php if($row['level'] == 1 ): ?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="sign-up.php">
              <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">+เพิ่มสมาชิก</span>
            </a>
					</li>
					<?php endif; ?>
					<?php if($row['level'] == 1 && 2): ?>
					<li class="sidebar-item ">
						<a class="sidebar-link" href="user_list.php">
              <i class="align-middle" data-feather="users"></i> <span class="align-middle">สมาชิก</span>
            </a>
					</li>
					<?php endif; ?>
				</ul>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                	<img src="<?php echo $imageURL ?>" class="avatar img-fluid rounded me-1" alt="" > <span class="text-dark"> <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<!-- <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a> -->
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" onclick="alert('คุณต้องการออกจากระบบใช่ไหม')" href="logout.php">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>