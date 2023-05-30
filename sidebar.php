<?php 
include "head.php";
include "funtion.php";
  
		if (isset($_SESSION['user_login'])) {
			$user_id = $_SESSION['user_login'];

			$sql = "SELECT *,concat(firstname,' ',lastname) as name FROM user AS u  natural JOIN position  WHERE u.user_id = $user_id ";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$imageURL = 'img/avatars/'.$row['avatar'];
		}
			$level = $row['level'];
		/* 	echo $level; */
			$department_id = $row['department_id'];
			$role = $row['role_id'];
			/* echo $role ; */  
			$where ='';
			
			if($level > 2){
				$where  = "where (d.department_id = 0 OR d.department_id =  ".$department_id.") AND status_user2 = 1 AND status_user = 1 ";
			}

			$sql2 = "SELECT MAX(level) as maxlevel , MIN(level) as minlevel FROM user as u 
			left join position as p ON u.role_id = p.role_id 
			left join department as d on u.department_id = d.department_id   $where ";
			$stmt2 = $db->prepare($sql2);
			$stmt2->execute();
			$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			$maxlevel = $row2['maxlevel'];
			$minlevel = $row2['minlevel'];
/* 
		 	  echo $level .' ' .$maxlevel ;    */
			
?>
<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.php">
				<?php if($level == 1): ?>
					
				<span class="align-middle">Admin <?php /* echo $row['firstname']  */?></span>
				<?php endif; ?>

				<?php if($level > 1): ?>
					<span class="align-middle">user <?php/*  echo $row['firstname']  */?></span>
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

					<?php if($level != $maxlevel): ?>
						<li class="sidebar-item">
						<a class="sidebar-link" href="addproject_page.php">
              <i class="align-middle" data-feather="layers"></i> <span class="align-middle">เพิ่มหัวข้องาน</span>
            </a>

					<?php endif; ?>
					<li class="sidebar-item">
						<a data-bs-target="#project_list" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
							<i class="align-middle" data-feather="list"></i> 
							 <span class="align-middle">
							 รายการหัวข้องาน
							</span>
						</a>
						<?php if($level != $maxlevel): ?>
						<ul id="project_list" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
							<li class="sidebar-item">
								<a class="sidebar-link" href="project_list.php">
								&nbsp;&nbsp;&nbsp;--> หัวข้องานที่สร้าง 
								</a>
							</li>
						</ul>
						<?php endif; ?>
						<ul id="project_list" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
							<li class="sidebar-item">
								<a class="sidebar-link" href="project_list_user.php">
								&nbsp;&nbsp;&nbsp;--> หัวข้องานที่ถูกมอบหมาย
								</a>
							</li>
						</ul>
					</li>
				
			<li class="sidebar-item">
				<a data-bs-target="#report" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
					<i class="align-middle" data-feather="clipboard"></i> 
						<span class="align-middle">
						รายงาน
					</span>
				</a>

				<ul id="report" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
					<li class="sidebar-item">
						<a class="sidebar-link" href="report.php">
						&nbsp;&nbsp;&nbsp;--> รายงานหัวข้องาน
						</a>
					</li>
				</ul>
			
				<ul id="report" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
					<li class="sidebar-item">
						<a class="sidebar-link" href="reportuser.php">
						&nbsp;&nbsp;&nbsp;--> รายงานสมาชิก
						</a>
					</li>
				</ul>
			
			</li>
					<?php if($level != $maxlevel): ?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="checktask_list.php">
              <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">ตรวจงาน</span>
            </a>
			<?php endif; ?>
					</li>

					<?php if(($level == 1) ): ?>
					<li class="sidebar-header">
						ADMIN
					</li>
					<?php elseif($level == 2): ?>
					<li class="sidebar-header">
						USER
					</li> 
					<?php endif; ?>
					
					<?php if($level <=2): ?>

						<li class="sidebar-item">
							<a class="sidebar-link"  href="jobtype_list.php">
				<i class="align-middle" data-feather="layers"></i> <span class="align-middle">ประเภทงาน</span>
							</a>
					<?php endif; ?>
					<?php if($level == 1): ?>
						<li class="sidebar-item">
							<a class="sidebar-link"  href="departmant_list.php">
				<i class="align-middle" data-feather="layers"></i> <span class="align-middle">รายการฝ่าย</span>
							</a>

						<li class="sidebar-item">
							<a class="sidebar-link"  href="position_list.php">
				<i class="align-middle" data-feather="layers"></i> <span class="align-middle">รายการตำเเหน่ง</span>
							</a>
					<?php endif; ?>

					<?php if($level <=2): ?>

						

					<li class="sidebar-item">
						<a data-bs-target="#user" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
							<i class="align-middle" data-feather="users"></i> 
							 <span class="align-middle">
								สมาชิก
							</span>
						</a>
					
						<ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
							<li class="sidebar-item">
								<a class="sidebar-link" href="user_list.php">
								&nbsp;&nbsp;&nbsp;--> รายการสมาชิก
								</a>
							</li>
						</ul>
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
					
					
							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
							<?php if($row['avatar'] !=""){?>
                				<img src="img/avatars/<?php echo $row['avatar'] ?>" class="avatar rounded-circle rounded me-1" alt="" > <span class="text-dark"> <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></span>
							<?php }else{?>
								<img src="img/avatars/09.jpg" class="avatar rounded-circle rounded me-1" alt="" > <span class="text-dark"> <?php echo  showshortname($row['shortname_id']) . ' ' . $row['firstname'] . ' ' . $row['lastname'] ?></span>
 							<?php }?>
              				</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item viewuserdata"  data-userid="<?php echo $row['user_id'] ?>" ><i class="align-middle me-1" data-feather="user"></i> โปรไฟล์</a>
								<a class="dropdown-item" href="edituser.php?user_id=<?php echo $row['user_id']?>" ><i class="align-middle me-1" data-feather="edit"></i> เเก้ไขโปรไฟล์</a>
								<a class="dropdown-item" href="editnewpassuser.php"><i class="align-middle me-1" data-feather="key"></i> เปลียนรหัสผ่าน</a>

								<!-- <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a> -->
								<div class="dropdown-divider"></div>
								<a class="dropdown-item logoutuser" >ออกจากระบบ</a>
							</div>
							<?php include 'viewmodel.php'?>
					</ul>
				</div>
			</nav>
			<script> 
  $(document).ready(function(){
  $('.viewuserdata').click(function(){
    var proc = 'viewdatauser';
    var userid=$(this).data("userid");
  /*   console.log(userid); */
    $.ajax({
        url:"proc2.php",
        method:"post",
        data:{proc:proc,userid:userid},
        success:function(data){
        /*    console.log(data); */

           $('#datauser').html(data);
            $('#datausermodal').modal('show');  
        }
    })
  });
});
$(".logoutuser").click(function() {
    Swal.fire({
        title: 'คุณต้องการออกจากระบบใช่หรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ออกจากระบบ!',
        cancelButtonText: 'กลับ',
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                resolve(
                    $.ajax({
                        url: 'logout.php',
                        type: 'post',
                        data: 'logout=' + 'true',
                        success: function(response) {
                            Swal.fire({
                                title: 'เรียบร้อย',
                                text: 'ออกจากระบบเรียบร้อยแล้ว!',
                                icon: 'success',
								confirmButtonText:'ตกลง',
                            }).then(() => {
                                document.location.href = 'logout.php';
                            });
                        }
                    })
                );
            });
        },
    });
}); 
</script> 