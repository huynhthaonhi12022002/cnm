<?php
    $current_uri = $_SERVER['REQUEST_URI'];
	$is_holidays = ($current_uri == '/cnm/holidays.php');
	$is_employees_list = ($current_uri == '/cnm/employees-list.php');
	$is_leaves_employee = ($current_uri == '/cnm/leaves-employee.php');
	$is_departments = ($current_uri == '/cnm/departments.php');
	$is_designations = ($current_uri == '/cnm/designations.php');
	$is_certificates = ($current_uri == '/cnm/certificates.php');
	$is_attendances = ($current_uri == '/cnm/attendances.php')
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Attendances - HRMS admin template</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Lineawesome CSS -->
		<link rel="stylesheet" href="assets/css/line-awesome.min.css">
		
		<!-- Datatable CSS -->
		<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/css/select1.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
			<?php include_once("includes/header.php");?>
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
							
							<li class="menu-title"> 
								<span>Employees</span>
							</li>
						

							<li class="submenu">
								<a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li class="<?=$is_holidays ? 'active' : ''; ?>">
										<a class="<?=$is_holidays ? 'active' : ''; ?>" href="/cnm/holidays.php">
											<span>Holidays</span>
										</a>
									</li>
									<li class="<?=$is_employees_list ? 'active' : ''; ?>">
										<a class="<?=$is_employees_list ? 'active' : ''; ?>" href="/cnm/employees-list.php">All Employees</a>
									</li>
									<li class="<?=$is_leaves_employee ? 'active' : ''; ?>">
										<a class="<?=$is_leaves_employee ? 'active' : ''; ?>" href="/cnm/leaves-employee.php">Employee Leave</a>
									</li>
									<li class="<?=$is_departments  ? 'active' : ''; ?>">
										<a class="<?=$is_departments  ? 'active' : ''; ?>" href="/cnm/departments.php">Departments</a>
									</li>
									<li class="<?=$is_designations ? 'active' : ''; ?>">
										<a class="<?=$is_designations ? 'active' : ''; ?>" href="/cnm/designations.php">Designations</a>
									</li>
									<li class="<?=$is_certificates ? 'active' : ''; ?>">
										<a class="<?=$is_certificates ? 'active' : ''; ?>" href="/cnm/certificates.php">Certificates</a>
									</li>
									<li class="<?=$is_attendances ? 'active' : ''; ?>">
										<a class="<?=$is_attendances ? 'active' : ''; ?>" href="/cnm/attendances.php">Attendances</a>
									</li>
								</ul>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/clients-list.php') ? 'active' : ''; ?>" > 
								<a  href="/cnm/clients-list.php"><i class="la la-users"></i> <span>Clients</span></a>
							</li>
							<li class="submenu">
								<a href="#" ><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="projects.php">Projects</a></li>
								</ul>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/task.php') ? 'active' : ''; ?>" > 
								<a href="/cnm/tasks.php"><i class="la la-user-secret"></i> <span>Tasks</span></a>
							</li>
							
							<li class="menu-title"> 
								<span>HR</span>
							</li>
							<!-- <li class="submenu">
								<a href="#"><i class="la la-files-o"></i> <span> Accounts </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="invoices.php">Invoices</a></li>
									<li><a href="payments.php">Payments</a></li>
									<li><a href="expenses.php">Expenses</a></li>
									<li><a href="provident-fund.php">Provident Fund</a></li>
									<li><a href="taxes.php">Taxes</a></li>
								</ul>
							</li> -->
							<li class="submenu">
								<a href="#"><i class="la la-money"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="salary.php"> Employee Salary </a></li>
									<li><a href="salary-view.php"> Payslip </a></li>
									<li><a href="payroll-items.php"> Payroll Items </a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="#" ><i class="la la-bullhorn"></i> <span> Jobs </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li class="<?php echo ($current_uri == '/cnm/jobs.php') ? 'active' : ''; ?>" >
										<a class="<?php echo ($current_uri == '/cnm/jobs.php') ? 'active' : ''; ?>" href="/cnm/jobs.php">Job List </a>
									</li>
									<li  class="<?php echo ($current_uri == '/cnm/job-applicants.php') ? 'active' : ''; ?>" >
										<a class="<?php echo ($current_uri == '/cnm/job-applicants.php') ? 'active' : ''; ?>" href="job-applicants.php"> Application List </a>
									</li>
								</ul>
							</li>
							<li class="submenu">
								<a href="#"><i class="la la-edit"></i> <span> Training </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="training.php"> Training List </a></li>
									<li><a href="trainers.php"> Trainers</a></li>
									<li><a href="training-type.php"> Training Type </a></li>
								</ul>
							</li>
							<!-- <li><a href="resignation.php"><i class="la la-external-link-square"></i> <span>Resignation</span></a></li>
							<li><a href="termination.php"><i class="la la-times-circle"></i> <span>Termination</span></a></li> -->
							<li class="menu-title"> 
								<span>Administration</span>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/assets.php') ? 'active' : ''; ?>" > 
								<a href="/cnm/assets.php" class="<?php echo ($current_uri == '/cnm/assets.php') ? 'active' : ''; ?>"><i class="la la-object-ungroup"></i> <span>Assets</span></a>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/users.php') ? 'active' : ''; ?>" > 
								<a href="/cnm/users.php" class="<?php echo ($current_uri == '/cnm/users.php') ? 'active' : ''; ?>" ><i class="la la-user-plus"></i> <span>Users</span></a>
							</li>
							
							<li class="menu-title"> 
								<span>Pages</span>
							</li>
							<li class="submenu">
								<a href="#"><i class="la la-user"></i> <span> Profile </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="profile.php"> Employee Profile </a></li>
									<li><a href="client-profile.php"> Client Profile </a></li>
								</ul>
							</li>
							<li> 
								<a href="logout.php"><i class="la la-power-off"></i> <span>Logout</span></a>
							</li>
							<li class="<?php echo ($current_uri == '/cnm/change-password.php') ? 'active' : ''; ?>"> 
								<a class="<?php echo ($current_uri == '/cnm/change-password.php') ? 'active' : ''; ?>"  href="change-password.php"><i class="la la-key"></i> <span>Change password</span></a>
							</li>
						</ul>
					</div>
                </div>
            </div>

            		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js"></script>
		
		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/dataTables.bootstrap4.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/js/select2.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/app.js"></script>