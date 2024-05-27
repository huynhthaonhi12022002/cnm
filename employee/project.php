<?php
session_start();
error_reporting(0);
include_once('../includes/config.php');
include_once('../class/project.php');
$projectObj = new Project($dbh);

// Check if the user is logged in
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: ../login.php');
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
        <title>Dự án</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
		
		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="../assets/css/line-awesome.min.css">
		
		<!-- Datatable CSS -->
		<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="../assets/css/select1.min.css">
		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
		
		<!-- Summernote CSS -->
		<link rel="stylesheet" href="../assets/plugins/summernote/dist/summernote-bs4.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="../assets/css/style.css">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="../assets/js/html5shiv.min.js"></script>
			<script src="../assets/js/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            <?php include_once("../includes/header_employee.php");?>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <?php include_once("../includes/sidebar_employee.php");?>
			<!-- /Sidebar -->

			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Danh sách dự án</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Dự án</li>
								</ul>
							</div>
							
						</div>
					</div>
					<!-- /Page Header -->
					
					<!-- Search Filter -->
					
					<!-- /Search Filter -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table datatable">
									<thead>
										<tr>
											<th>Project</th>
											<th>Khách hàng</th>
											<th>Trưởng nhóm</th>
											<th>Thành viên</th>
											<th>Deadline</th>
											<th>Ưu tiên</th>
											<th>Trạng thái</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                            $id = $_SESSION['employee_id']; 
											$results = $projectObj->getProjectsByEmp($id);
									
											if($results):
											foreach($results as $row):
										?>
										<tr>
											<td>
												<a href="project-view.php?id=<?=$row["project_id"]?>"><?=$row["name"]?></a>
											</td>
											<td><?=$row["firstname_c"]." ".$row["lastname_c"]?></td>
											<td>
												<ul class="team-members">
													<li>
														
														<a href="#" data-toggle="tooltip" title="<?=$row["firstname"]." ".$row["lastname"]?>"><img alt="" src="../upload/employees/<?=$row["avatar"]?>"></a>
													</li>
												</ul>
											</td>
								
											<td>
												<ul class="team-members text-nowrap">
												<?php
												 	$team = json_decode($row['team'], true);
													foreach ($team as $id):
														$employee_team = $projectObj->getEmployeeById($id);
														if ($employee_team !== null) {
													?>
														<li>
															<a href="#" title="<?= $employee_team['firstname'] . " " . $employee_team['lastname'] ?>" data-toggle="tooltip">
																<img alt="" src="../upload/employees/<?= $employee_team['avatar'] ?>">
															</a>
														</li>
													<?php
														} else {
															
														}
													endforeach;
													?>
												</ul>
											</td>
											<td><?=date("d/m/Y", strtotime($row["end_date"]))?></td>
											<td>
												<div class="dropdown action-label">
													<a href="" class="btn btn-white btn-sm btn-rounded " data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> <?=$row["priority"]?> </a>
												
												</div>
											</td>
											<td>
												<div class="dropdown action-label">
												<?php 
													if($row["status"] == 1):
												?>
													<a href="" class="btn btn-white btn-sm btn-rounded " data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Đang làm </a>
												<?php
													else:
												?>
													<a href="" class="btn btn-white btn-sm btn-rounded " data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Không hoạt động </a>

												<?php
													endif;
												?>
												</div>
											</td>
											
										</tr>
										
										<?php
											endforeach;
										endif;  ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
                </div>
				<!-- /Page Content -->
				
			
				
			
				
            </div>
			<!-- /Page Wrapper -->

        </div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
        <script src="../assets/js/jquery-3.2.1.min.js"></script>

		<!-- Bootstrap Core JS -->
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>

		<!-- Slimscroll JS -->
		<script src="../assets/js/jquery.slimscroll.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="../assets/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="../assets/js/moment.min.js"></script>
		<script src="../assets/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Datatable JS -->
		<script src="../assets/js/jquery.dataTables.min.js"></script>
		<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
		
		<!-- Summernote JS -->
		<script src="../assets/plugins/summernote/dist/summernote-bs4.min.js"></script>

		<!-- Custom JS -->
		<script src="../assets/js/app.js"></script>
		<script>
			$(document).ready(function(){
				
				$('.select').select2({
					dropdownSearch: true
				});
				$('.table').on('click','.editbtn',(function(){
						var id = $(this).data('id');
						var name = $(this).data('name');
						var client = $(this).data('client_id');
						var startdate = $(this).data('start_date');
						var enddate = $(this).data('end_date');
						var rate = $(this).data('rate');
						var priority = $(this).data('priority');
						var leader = $(this).data('leader');
						var team  = $(this).data('team');			
						var description = $(this).data('description');
						var progress = $(this).data('progress');
						$('#edit_project').modal('show');
						$('#edit_id').val(id);
						$('#edit_name').val(name);
						$('#edit_client').val(client).trigger('change');
						$('#edit_startdate').val(startdate);
						$('#edit_enddate').val(enddate);
						$('#edit_rate').val(rate);
						$('#edit_priority').val(priority).trigger('change');
						$('#edit_leader').val(leader).trigger('change');
						$('#edit_team').val(team).trigger('change');
						$('#edit_description').val(description);
						$('#edit_progress').val(progress);
						$('#progress_result').html("Progress Value: " + progress);
						$('#edit_progress').change(function(){
							$('#progress_result').html("Progress Value: " + $(this).val());
						});

				}));
				$('.datatable').DataTable().destroy();

				$('.datatable').DataTable({
           
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            searching: true,
            language: {
                search: "Tìm kiếm",
                paginate: {
                    first: "Trang đầu",
                    previous: "Trang trước",
                    next: "Trang sau",
                    last: "Trang cuối"
                },
                emptyTable: "Không có dữ liệu",
                info: "Hiển thị _START_ - _END_ Tổng cộng _TOTAL_ ",
                infoEmpty: "Không có dữ liệu, Hiển thị 0 bản ghi ",
                zeroRecords: "Không có dữ liệu bạn muốn tìm",
                infoFiltered: "",
                lengthMenu: "Hiển thị số lượng _MENU_ ",
            }
        });
			})
		</script>
    </body>
</html>