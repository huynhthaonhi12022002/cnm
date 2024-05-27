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

							<li class="">
								<a class="" href="dashboard.php"><i class="la la-dashboard"></i><span>Dashboard</span></a>
							</li>
						
							<li class="">
								<a class="" href="holidays.php"><i class="la la-calendar-check-o"></i><span>Xem ngày nghỉ lễ</span></a>
							</li>
						
							<li class="submenu">
								<a href="#"><i class="la la-pencil-square"></i> <span>Đơn xin nghỉ phép</span> <span class="menu-arrow"></span></a>
								<ul style="display: non;">
									<li>
										<a class="" href="leave-employee.php">Danh sách đơn xin nghỉ</a>
									</li>
								
									
								</ul>
							</li>
							<li class="">
								<a href="payroll.php"><i class="la la-money"></i> <span>Xem bảng lương </span></a>
							</li>
							<li class="">
								<a href="project.php"><i class="la la-rocket"></i>  <span>Xem dự án được giao </span></a>
							</li>
							<li class="">
								<a href="task.php"><i class="la la-connectdevelop"></i> <span>Xem nhiệm vụ được giao </span></a>
							</li>
							<li class="">
								<a href="chat.php"><i class="la la-comment"></i> <span>Chat</span></a>
							</li>
							<li class="">
								<a href="profile.php"><i class="la la-user"></i> <span>Hồ sơ</span></a>
							</li>
							<li class="">
								<a href="change-password.php"><i class="la la-share-alt-square"></i> <span>Đổi mật khẩu </span></a>
							</li>
						</ul>
					</div>
                </div>
            </div>