<?php
    $current_uri = $_SERVER['REQUEST_URI'];
	$is_holidays = ($current_uri == '/cnm/holidays.php');
	$is_employees_list = ($current_uri == '/cnm/employees.php');
	$is_leaves_employee = ($current_uri == '/cnm/leaves-employee.php');
	$is_departments = ($current_uri == '/cnm/departments.php');
	$is_designations = ($current_uri == '/cnm/designations.php');
	$is_certificates = ($current_uri == '/cnm/certificates.php');
	$is_attendances = ($current_uri == '/cnm/attendances.php')
?>
<div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li class="submenu">
								<a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="index.php">Admin Dashboard</a></li>
									<li><a href="employee-dashboard.php">Employee Dashboard</a></li>
								</ul>
							</li>

							<li class="submenu">
							<a href="#" class="<?=$is_employees_list ? 'active' : ''; ?>"><i class="la la-user"></i> <span> Quản lý nhân viên</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a class="<?=$is_employees_list ? 'active' : ''; ?>" href="/cnm/employees.php">Danh sách nhân viên</a></li>
								</ul>
							</li>
					
							<li class="<?=$is_holidays ? 'active' : ''; ?>">
								<a class="" href="holidays.php"><i class="la la-calendar-check-o"></i><span>Quản lý nghỉ lễ</span></a>
							</li>
							<li  class="<?=$is_departments  ? 'active' : ''; ?>">
								<a class="" href="departments.php"><i class="la la-institution"></i><span>Quản lý phòng ban</span></a>
							</li>
							<li class="<?=$is_designations ? 'active' : ''; ?>">
								<a class="" href="designations.php"><i class="la la-key"></i><span>Quản lý chức vụ</span></a>
							</li>
							<li class="<?=$is_certificates ? 'active' : ''; ?>">
								<a class="" href="certificates.php"><i class="la la-clipboard"></i><span>Quản lý bằng cấp</span></a>
							</li>
							<li class="<?=$is_attendances ? 'active' : ''; ?>">
								<a class="" href="attendances.php"><i class="la la-user-secret"></i><span>Quản lý chấm công</span></a>
							</li>
							<li class="submenu">
								<a href="#" class="<?=$is_leaves_employee ? 'active' : ''; ?>"><i class="la la-pencil-square"></i> <span>Quản lý nghỉ phép</span> <span class="menu-arrow"></span></a>
								<ul style="display: non;">
									<li class="<?=$is_leaves_employee ? 'active' : ''; ?>">
										<a class=" " href="leaves-employee.php">Danh sách đơn xin nghỉ</a>
									</li>
								</ul>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/clients-list.php') ? 'active' : ''; ?>" >
								<a   href="clients-list.php"><i class="la la-users"></i> <span>Quản lý khách hàng</span></a>
							</li>

							<li class="submenu">
								<a href="#" class="<?php echo ($current_uri == '/cnm/project-list.php') ? 'active' : ''; ?>" ><i class="la la-rocket"></i> <span>Quản lý dự án </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li class="<?php echo ($current_uri == '/cnm/project-list.php') ? 'active' : ''; ?>">
										<a class="" href="project-list.php">Danh sách dự án</a>
									</li>
								
								</ul>
							</li>
							<li class="submenu">
								<a href="#" class="<?php echo ($current_uri == '/cnm/tasks.php') ? 'active' : ''; ?>"><i class="la la-connectdevelop"></i> <span>Quản lý nhiệm vụ </span> <span class="menu-arrow"></span></a>
								<ul style="display: non;">
									<li class="<?php echo ($current_uri == '/cnm/tasks.php') ? 'active' : ''; ?>">
										<a class="" href="tasks.php">Danh sách nhiệm vụ</a>
									</li>
								</ul>
							</li>

							<li class="submenu">
								<a href="#" class="<?php echo ($current_uri == '/cnm/salary.php')? 'active' : ''; ?>"><i class="la la-money"></i> <span>Quản lý bảng lương </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li class="<?php echo ($current_uri == '/cnm/salary.php')? 'active' : ''; ?>"><a class="" href="salary.php">Danh sách bảng lương</a></li>
								</ul>
							</li>
							<li class="submenu " >
								<a class="<?php echo ($current_uri == '/cnm/jobs.php')||($current_uri == '/cnm/job-applicants.php')? 'active' : ''; ?>" href="#"><i class="la la-briefcase"></i> <span>Quản lý tuyển dụng </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li class="<?php echo ($current_uri == '/cnm/jobs.php') ? 'active' : ''; ?>"><a class="" href="jobs.php"> Danh sách việc làm </a></li>
									<li class="<?php echo ($current_uri == '/cnm/job-applicants.php') ? 'active' : ''; ?>"><a class=" " href="job-applicants.php"> Danh sách ứng tuyển </a></li>
								</ul>
							</li>
							
							<li class="<?php echo ($current_uri == '/cnm/chat.php') ? 'active' : ''; ?>" > 
								<a href="chat.php" class=""><i class="la la-comments"></i> <span>Chat</span></a>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/users.php')?>">
								<a href="users.php"><i class="la la-user-plus"></i> <span>Quản lý người dùng</span></a>
							</li>
							<!-- <li class="submenu">
								<a href="#"><i class="la la-edit"></i> <span> Training </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="training.php"> Training List </a></li>
									<li><a href="trainers.php"> Trainers</a></li>
									<li><a href="training-type.php"> Training Type </a></li>
								</ul>
							</li> -->
							<li class="<?php echo ($current_uri == '/cnm/assets.php') ? 'active' : ''; ?>">
								<a href="assets.php"><i class="la la-object-ungroup"></i> <span>Quản lý tài sản</span></a>
							</li>

							<li class="<?php echo ($current_uri == '/cnm/change-password.php') ? 'active' : ''; ?>">
								<a class="<?php echo ($current_uri == '/cnm/change-password.php') ? 'active' : ''; ?>" href="change-password.php"><i class="la la-share-alt-square"></i> <span>Đổi mật khẩu</span></a>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/profile.php') ? 'active' : ''; ?>">
								<a class="" href="profile.php"><i class="la la-user"></i> <span>Hồ sơ</span></a>
							</li>
							<li> 
								<a href="logout.php"><i class="la la-power-off"></i> <span>Đăng xuất</span></a>
							</li>
							<!-- <li class="submenu">
							<a href="#" class="<?=$is_employees_list ? 'active' : ''; ?>"><i class="la la-user"></i> <span> Quản lý nhân viên</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a class="<?=$is_employees_list ? 'active' : ''; ?>" href="/cnm/employees.php">Danh sách nhân viên</a></li>
								</ul>
							</li>
					
							<li class="">
								<a class="" href=""><i class="la la-calendar-check-o"></i><span>Quản lý nghỉ lễ</span></a>
							</li>
							<li class="">
								<a class="" href=""><i class="la la-institution"></i><span>Quản lý phòng ban</span></a>
							</li>
							<li class="">
								<a class="" href=""><i class="la la-key"></i><span>Quản lý chức vụ</span></a>
							</li>
							<li class="">
								<a class="" href=""><i class="la la-user-secret"></i><span>Quản lý chấm công</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="la la-pencil-square"></i> <span>Quản lý nghỉ phép</span> <span class="menu-arrow"></span></a>
								<ul style="display: non;">
									<li>
										<a class=" " href="leave')">Danh sách đơn xin nghỉ</a>
									</li>
									<li>
										<a class=" " href="type')">Loại nghỉ phép</a>
									</li>
									
								</ul>
							</li>-->
						</ul>
					</div>
                </div>
            </div>