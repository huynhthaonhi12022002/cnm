<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/project.php');
$projectObj = new Project($dbh);

// Check if the user is logged in
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}

if (isset($_POST['add_project'])) {
    $name = htmlspecialchars($_POST['name']);
    $client_id = intval($_POST['client_id']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $rate = htmlspecialchars($_POST['rate']);
    $priority = htmlspecialchars($_POST['priority']);
    $leader = htmlspecialchars($_POST['leader']);
    $team = $_POST['team'];
	$team_new = json_encode($team);
    $description = htmlspecialchars($_POST['description']);
    $progress = 0;
    $status = 1;

    $files = "";
    $upload_dir = 'upload/files/'; 

    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $key => $file_name) {
            $file_size = $_FILES['files']['size'][$key];
            $file_tmp = $_FILES['files']['tmp_name'][$key];
            $file_type = $_FILES['files']['type'][$key];

            $destination_path = $upload_dir . $file_name;

            if (move_uploaded_file($file_tmp, $destination_path)) {
                $files .= $file_name . ","; 
            } else {
                echo "<script>alert('Failed to upload files');</script>";
            }
        }
    }

    $files = rtrim($files, ",");

    $files_json = json_encode(explode(",", $files));

    $result = $projectObj->addProject($name, $client_id, $start_date, $end_date, $rate, $priority, $leader, $team_new, $description, $files_json, $progress, $status);
    
    if ($result) {
        header("Location: project-list.php?success=1");
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

if (isset($_POST['update_project'])) {
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $client_id = intval($_POST['client_id']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $rate = htmlspecialchars($_POST['rate']);
    $priority = htmlspecialchars($_POST['priority']);
    $leader = htmlspecialchars($_POST['leader']);
    $team = $_POST['team'];
	$team_new = json_encode($team);
    $description = htmlspecialchars($_POST['description']);
    $progress = 0;
    $status = 1;
    $files = ""; 
    $upload_dir = 'upload/files/'; 

    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $key => $file_name) {
            $file_size = $_FILES['files']['size'][$key];
            $file_tmp = $_FILES['files']['tmp_name'][$key];
            $file_type = $_FILES['files']['type'][$key];
            $destination_path = $upload_dir . $file_name;
            if (move_uploaded_file($file_tmp, $destination_path)) {
                $files .= $file_name . ","; 
            } else {
                echo "<script>alert('Failed to upload files');</script>";
            }
        }
    }

    $files = rtrim($files, ",");

    $files_json = json_encode(explode(",", $files));

    $result = $projectObj->updateProject($id, $name, $client_id, $start_date, $end_date, $rate, $priority, $leader, $team_new, $description, $files_json, $progress, $status);
    
    if ($result) {
        header("Location: project-list.php?success=2");
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}
// Check if the delid parameter is passed
if (isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    
    $result = $projectObj->deleteProject($id);
    
    if ($result) {
        header("Location: project-list.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete project');</script>";
    }
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
		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
		
		<!-- Summernote CSS -->
		<link rel="stylesheet" href="assets/plugins/summernote/dist/summernote-bs4.css">
		
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
			<!-- /Header -->
			
			<!-- Sidebar -->
            <?php include_once("includes/sidebar.php");?>
			<!-- /Sidebar -->
			<?php include_once ('includes/notification/notify.php'); ?>
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
							<div class="col-auto float-right ml-auto">
								<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_project"><i class="fa fa-plus"></i> Thêm dự án</a>
								<div class="view-icons">
									<a href="project-list.php" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
									<a href="project-list.php" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm dự án thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật dự án thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa dự án thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					<!-- Search Filter -->
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">  
							<div class="form-group form-focus">
								<input type="text" class="form-control floating">
								<label class="focus-label">Project Name</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">  
							<div class="form-group form-focus">
								<input type="text" class="form-control floating">
								<label class="focus-label">Employee Name</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option>Select Roll</option>
									<option>Web Developer</option>
									<option>Web Designer</option>
									<option>Android Developer</option>
									<option>Ios Developer</option>
								</select>
								<label class="focus-label">Role</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">  
							<a href="#" class="btn btn-success btn-block"> Search </a>  
						</div>     
                    </div>
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
											<th class="text-right">Thao tác</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$results = $projectObj->viewAllProjects();
									
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
														
														<a href="#" data-toggle="tooltip" title="<?=$row["firstname"]." ".$row["lastname"]?>"><img alt="" src="upload/employees/<?=$row["avatar"]?>"></a>
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
																<img alt="" src="upload/employees/<?= $employee_team['avatar'] ?>">
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
											<td class="text-right">
												<a class="btn btn-info" href="project-view.php?id=<?=$row["project_id"]?>" ><i class="fa fa-eye"></i></a>				
												<a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_project"  data-id="<?= $row['project_id'] ?>"
    data-name="<?= $row['name'] ?>"
    data-client_id="<?= $row['client_id'] ?>"
    data-start_date="<?= $row['start_date'] ?>"
    data-end_date="<?= $row['end_date'] ?>"
    data-rate="<?= $row['rate'] ?>"
    data-priority="<?= $row['priority'] ?>"
    data-leader="<?= $row['leader'] ?>"
    data-team=<?=$row['team']?>
    data-description="<?= $row['description'] ?>"
    data-progress="<?= $row['progress'] ?>"><i class="fa fa-pencil"></i> </a>
	
												<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#delete_project_<?=$row["id"]?>"><i class="fa fa-trash-o"></i> </a>				
											</td>
										</tr>
										<div class="modal custom-modal fade" id="delete_project_<?=$row["id"]?>" role="dialog">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-body">
														<div class="form-header">
															<h3>Xóa dự án?</h3>
															<p>Bạn có chắc chắn muốn xóa dự án này?</p>
														</div>
														<div class="modal-btn delete-action">
															<div class="row">
																<div class="col-6">
																	<a href="project-list.php?delid=<?=$row["project_id"]?>" class="btn btn-primary continue-btn">Xóa</a>
																</div>
																<div class="col-6">
																	<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Hủy bỏ</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
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
				
				<!-- Create Project Modal -->
				<?php include_once("includes/modals/projects/add_project.php") ?>
				<!-- /Create Project Modal -->
				
				<!-- Edit Project Modal -->
				<?php include_once("includes/modals/projects/edit_project.php"); ?>
				<!-- /Edit Project Modal -->
				
			
				
            </div>
			<!-- /Page Wrapper -->

        </div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/dataTables.bootstrap4.min.js"></script>
		
		<!-- Summernote JS -->
		<script src="assets/plugins/summernote/dist/summernote-bs4.min.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/app.js"></script>
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
		function setupValidation(formId) {
            $(formId).validate({
                rules: {
                    name: {
                        required: true
                    },
                    client_id: {
                        required: true
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                    rate: {
                        required: true
                    },
                    priority: {
                        required: true
                    },
                    leader: {
                        required: true
                    },
                    "team[]": {
                        required: true
                    },
                    description: {
                        required: true
                    },
                
               
                },
                messages: {
                    name: "*Vui lòng nhập tên dự án!",
                    client_id: "*Vui lòng chọn khách hàng!",
                    start_date: "*Vui lòng chọn ngày bắt đầu!",
                    end_date: "*Vui lòng chọn ngày kết thúc!",
                    rate: "*Vui lòng nhập chi phí!",
                    priority: "*Vui lòng chọn ưu tiên!",
                    leader: "*Vui lòng chọn lãnh đạo dự án!",
                    "team[]": "*Vui lòng chọn ít nhất một thành viên!",
                    description: "*Vui lòng nhập mô tả!",
                  
                },
                errorPlacement: function(error, element) {
                    if (element.is("select")) {
                        error.insertAfter(element.next("span.select2"));
                    }else if(element.is("click")) {
                        error.insertAfter(element);
                    }else {

					}
                }
            });
    }

    setupValidation("#form-add");
    setupValidation("#form-edit");		
	})
		</script>
    </body>
</html>