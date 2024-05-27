<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('class/dashboard.php');
$dashboard = new Dashboard($dbh);
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}
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
	<title>Dashboard</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="assets/css/line-awesome.min.css">

	<!-- Chart CSS -->
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
</head>

<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php include_once("includes/header.php"); ?>
		<!-- /Header -->

		<!-- Sidebar -->
		<?php include_once("includes/sidebar.php"); ?>
		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">

			<!-- Page Content -->
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title">Welcome <?php echo htmlentities(ucfirst($_SESSION['userlogin'])); ?>!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">Dashboard</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="row">
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
								<div class="dash-widget-info">
									<h3><?= $dashboard->getCountProjects() ?></h3>
									<span>Projects</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-users"></i></span>
								<div class="dash-widget-info">
									<h3><?= $dashboard->getCountClients() ?></h3>
									<span>Clients</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
								<div class="dash-widget-info">
									<h3><?= $dashboard->getCountTasks() ?></h3>
									<span>Tasks</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-user"></i></span>
								<div class="dash-widget-info">
									<h3><?= $dashboard->getCountEmployees() ?></h3>
									<span>Employees</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					
						<div class="col-md-12 col-lg-12 col-xl-6 d-flex">
							<div class="card flex-fill dash-statistics">
								<div class="card-body">
									<h5 class="card-title">Statistics</h5>
									<div class="stats-list">
										<div class="stats-info">
											<?php $leaves = $dashboard->getTodayLeaves(); ?>
											<p>Today Leave <strong><?=$leaves['today']?><small>/<?=$leaves['total']?></small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-primary" role="progressbar" style="width: <?=$leaves['percentage']?>%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="stats-info">
										<?php $applicant = $dashboard->getTodayApplicants(); ?>
											<p>Today Applicants <strong><?=$applicant['today']?> <small>/<?=$applicant['total']?> </small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-warning" role="progressbar" style="width: <?=$applicant['percentage']?>%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>

										<div class="stats-info">
										<?php $jobs = $dashboard->getTodayJobs(); ?>
											<p>Today Job  <strong><?=$jobs['today']?> <small>/<?=$jobs['total']?> </small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-danger" role="progressbar" style="width: <?=$jobs['percentage']?>%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="stats-info">
										<?php $project_complete = $dashboard->getCompletedProjects(); ?>
											<p>Completed Projects <strong><?=$project_complete['today']?> <small>/<?=$project_complete['total']?> </small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-success" role="progressbar" style="width: <?=$project_complete['percentage']?>%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-lg-6 col-xl-6 d-flex">
							<div class="card flex-fill">
								<div class="card-body">
									<h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2"><?=$leaves['today']?></span></h4>
									<?php $leave_list = $dashboard->getEmployeesOnLeave(); 
										foreach ($leave_list as $item) {
									?>
								
									<div class="leave-info-box">
										<div class="media align-items-center">
										<a href="leaves-employee.php" class="avatar"><img alt="" src="upload/employees/<?=$item['avatar']?>"></a>
											<div class="media-body">
												<div class="text-sm my-0"><?=$item['firstname'].' '.$item['lastname']?></div>
											</div>
										</div>
										<div class="row align-items-center mt-3">
											<div class="col-6">
												<h6 class="mb-0"><?=date('d/m/Y h:i:s', strtotime($item['created_at']))?></h6>
												<span class="text-sm text-muted">Leave Date</span>
											</div>
											<div class="col-6 text-right">
												<?php if($item['status'] == 0):?>
												<span class="badge bg-inverse-danger">
													Chờ duyệt
												</span>
												<?php else: ?>
												<span class="badge bg-inverse-success">
													Chấp nhận
												</span>
												<?php endif ?>

											</div>
										</div>
									</div>

									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
			    <div class="row">
				<div class="col-md-12 d-flex">
						<div class="card card-table flex-fill">
							<div class="card-header">
								<h3 class="card-title mb-0">Dự án gần đây</h3>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table custom-table mb-0">
										<thead>
											<tr>
												<th>Tên dự án </th>
												<th>Tiến trình</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$projects = $dashboard->getRecentProjects();
											foreach ($projects as $project) {
											?>
												<tr>
													<td>
														<h2><a href="project-view.php?id=<?= $project['id'] ?>"><?= $project['name'] ?></a></h2>
														<small class="block text-ellipsis">
															<span class="text-muted">Tổng số:</span> <span><?= $project['total_tasks'] ?></span> <br>
															<span><?= $project['incomplete_tasks'] ?></span> <span class="text-muted">chưa hoàn thành, </span>
															<span><?= $project['completed_tasks'] ?></span> <span class="text-muted">đã hoàn thành</span>

														</small>
													</td>
													<td>
														<div class="progress progress-xs progress-striped">
															<div class="progress-bar" role="progressbar" data-toggle="tooltip" title="<?= $project['progress'] ?>%" style="width: <?= $project['progress'] ?>%"></div>
														</div>
													</td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
																<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
															</div>
														</div>
													</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer">
								<a href="project-list.php">View all projects</a>
							</div>
						</div>
				</div>
					<!-- /Statistics Widget -->
				</div>
			</div>
		</div>
		<!-- /Page Content -->

	</div>
	<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<!-- javascript links starts here -->
	<!-- jQuery -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="assets/js/jquery.slimscroll.min.js"></script>

	<!-- Chart JS -->
	<script src="assets/plugins/morris/morris.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/js/chart.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>
	<!-- javascript links ends here  -->
</body>

</html>