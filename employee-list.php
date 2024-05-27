<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/employee.php');
include_once('class/user.php');
// Kiểm tra đăng nhập
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}

// Khởi tạo đối tượng Employee
$employeeObj = new Employee($dbh);
$userObj = new User($dbh);
// Thêm nhân viên mới
if (isset($_POST['add_employee'])) {
	$uuid = htmlspecialchars($_POST['uuid']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $department_id = htmlspecialchars($_POST['department_id']);
    $designation_id = htmlspecialchars($_POST['designation_id']);
    $join_date = htmlspecialchars($_POST['join_date']);
    $basic_salary = htmlspecialchars($_POST['basic_salary']);
    $avatar_name = $_FILES["avatar"]["name"];
	$name = $firstname.' '.$lastname;
	$password = password_hash('1111111111', PASSWORD_DEFAULT);
	$role = 0;
	$status = 1;
    $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
    $new_avatar_name = md5($avatar_name . time()) . '.' . $extension;
    move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/employees/" . $new_avatar_name);
    $result = $employeeObj->addEmployee($firstname, $lastname, $email, $phone, $department_id, $designation_id, $join_date, $new_avatar_name, $basic_salary,$uuid);
	if ($result !== false) {
		$employeeID = $result['id'];
		move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/users/" . $new_avatar_name);

		$result1 = $userObj->addUserNew($name, $email, $password, $new_avatar_name, $role, $status, $employeeID);
	}
	
    if ($result) {
        header("Location: employees-list.php?success=1");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Sửa thông tin nhân viên
if (isset($_POST['update_employee'])) {
    $id = htmlspecialchars($_POST['id']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
	$uuid = htmlspecialchars($_POST['uuid']);
    $phone = htmlspecialchars($_POST['phone']);
    $department_id = htmlspecialchars($_POST['department_id']);
    $designation_id = htmlspecialchars($_POST['designation_id']);
    $join_date = htmlspecialchars($_POST['join_date']);
    $avatar_name = $_FILES["avatar"]["name"];
    $basic_salary = htmlspecialchars($_POST['basic_salary']);

    // Kiểm tra xem có tệp avatar mới được tải lên không
    if (!empty($_FILES["avatar"]["name"])) {
        $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
        $new_avatar_name = md5($avatar_name . time()) . '.' . $extension;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/employees/" . $new_avatar_name);
    } else {
        // Nếu không, sử dụng avatar cũ
        $new_avatar_name = htmlspecialchars($_POST['old_avatar']);
    }

    // Cập nhật thông tin nhân viên vào cơ sở dữ liệu
    $result = $employeeObj->updateEmployee($id, $firstname, $lastname, $email, $phone, $department_id, $designation_id, $join_date, $new_avatar_name, $basic_salary, $uuid);
    if ($result) {
        header("Location: employees-list.php?success=2");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Xóa nhân viên
if (isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    $result = $employeeObj->deleteEmployee($id);
    if ($result) {
        header("Location: employees-list.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete employee');</script>";
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
        <title>Employees</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="assets/css/line-awesome.min.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/css/select1.min.css">
		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
		
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
            <?php include_once("includes/header.php");?>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <?php include_once("includes/sidebar.php");?>
			<!-- /Sidebar -->
			<?php include_once('includes/notification/notify.php');?>
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Danh sách nhân viên</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Nhân viên</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Thêm nhân viên</a>
								<div class="view-icons">
									<a href="employee-list.php" title="Grid View" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
									<a href="employees.php" title="Tabular View" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm nhân viên thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật nhân viên thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa nhân viên thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					<!-- user profiles list starts her -->

					<div class="row staff-grid-row">
						<div class="row staff-grid-row">
					<?php
					$results = $employeeObj->viewAllEmployees();
					$cnt = 1;
					if ($results) {
						foreach ($results as $row) {
					?>
							<div class="col-md-3 col-sm-6 col-12 col-lg-4 col-xl-3">
								<div class="profile-widget">
									<div class="profile-img">
										<a href="#" class="avatar"><img alt="picture" src="upload/employees/<?php echo htmlentities($row["avatar"]); ?>"></a>
									</div>
									<div class="dropdown profile-action">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item editbtn" href="#" data-toggle="modal" data-target="#edit_employee"
												data-id="<?=$row["id"]?>" data-firstname="<?=$row["firstname"]?>" data-lastname="<?=$row["lastname"]?>" data-email="<?=$row["email"]?>"
												data-phone="<?=$row["phone"]?>" data-uuid="<?=$row["uuid"]?>" data-department="<?=$row["department_id"]?>" data-designation="<?=$row["designation_id"]?>"
												data-basic_salary="<?=$row["basic_salary"]?>" data-avatar="<?=$row["avatar"]?>" data-join_date="<?=$row["join_date"]?>"
												><i class="fa fa-pencil m-r-5"></i> Sửa</a>
											<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_employee_<?=$row["id"]?>"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
										</div>
									</div>
									<h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="#"><?php echo htmlentities($row["company"]); ?></a></h4>
									<h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="#"><?php echo htmlentities(($row["firstname"]).' '.($row["lastname"])); ?></a></h5>
									<div class="small text-muted"><?php echo htmlentities($row["email"]); ?></div>
									<div class="small text-muted"><?php echo htmlentities($row["phone"]); ?></div>
								</div>
							</div>
							<div class="modal custom-modal fade" id="delete_client_<?= $row["id"] ?>" role="dialog">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-body">
											<div class="form-header">
												<h3>Xóa khách hàng này?</h3>
												<p>Bạn có chắc chán muốn xóa?</p>
											</div>
											<div class="modal-btn delete-action">
												<div class="row">
													<div class="col-6">
														<a href="clients-list.php?delid=<?= $row["id"] ?>" class="btn btn-primary continue-btn">Xóa</a>
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
					<?php $cnt += 1;
						}
					} ?>
					</tbody>
				</div>
					</div>
					
    </div>
    
				<!-- /Page Content -->
				
				<!-- Add Employee Modal -->
				<?php include_once("includes/modals/employee/add_employee.php"); ?>
				<!-- /Add Employee Modal -->
				
				<!-- Edit Employee Modal -->
				<?php include_once("includes/modals/employee/edit_employee.php"); ?>
				<!-- /Edit Employee Modal -->
				
				<!-- Delete Employee Modal -->
				<?php include_once("includes/modals/employee/delete_employee.php"); ?>
				<!-- /Delete Employee Modal -->
		
            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->
		
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
		
		<!-- Custom JS -->
		<script src="assets/js/app.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
		<script>
			 $(document).ready(function() {
				$('.select').select2({
					dropdownSearch: true
				});
				$("#form-add").validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                errorPlacement: function(error, element) {
                    if (element.hasClass('select')) {
                        error.insertAfter(element.next('span.select2'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    firstname: {
                        required: true,
                    },
                    lastname: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true // Kiểm tra định dạng email
                    },
                    phone: {
                        required: true,
                    },
                    company: {
                        required: true,
                    },
                    department_id: {
                        required: true,
                    },
                    designation_id: {
                        required: true,
                    },
                    basic_salary: {
                        required: true,
                    },
					join_date:{
                        required: true,
                    },

                },
                messages: {
                    firstname: "*Vui lòng nhập họ đệm!",
                    lastname: "*Vui lòng nhập tên!",
                    email: {
                        required: "*Vui lòng nhập địa chỉ email!",
                        email: "*Vui lòng nhập đúng định dạng email!"
                    },
                    phone: "*Vui lòng nhập số điện thoại!",
                    company: "*Vui lòng nhập công ty!",
                   	department_id: "*Vui lòng nhập phòng ban!",
                    designation_id: "*Vui lòng nhập chức vụ!",
                    basic_salary: "*Vui lòng nhập lương cơ bản!",
					join_date: "*Vui lòng nhập ngày gia nhập!",
                }
            });
            $("#form-edit").validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                errorPlacement: function(error, element) {
                    if (element.hasClass('select')) {
                        error.insertAfter(element.next('span.select2'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    firstname: {
                        required: true,
                    },
                    lastname: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    company: {
                        required: true,
                    },
                    department_id: {
                        required: true,
                    },
                    designation_id: {
                        required: true,
                    },
                    basic_salary: {
                        required: true,
                    },	
					join_date:{
                        required: true,
                    },
					
                },
                messages: {
                    firstname: "*Vui lòng nhập họ đệm!",
                    lastname: "*Vui lòng nhập tên!",
                    email: "*Vui lòng nhập email!",
                    phone: "*Vui lòng nhập số điện thoại!",
                    company: "*Vui lòng nhập công ty!",
                   department_id: "*Vui lòng nhập phòng ban!",
                    designation_id: "*Vui lòng nhập chức vụ!",
                    basic_salary: "*Vui lòng nhập lương cơ bản!",
					join_date: "*Vui lòng nhập ngày gia nhập!",

                }
            });
				$('.editbtn').on('click', function() {
					$('#edit_employee').modal('show');
					var id = $(this).data('id');
					var firstname = $(this).data('firstname');
					var lastname = $(this).data('lastname');
					var email = $(this).data('email');
					var uuid = $(this).data('uuid');
					var phone = $(this).data('phone');
					var avatar = $(this).data('avatar');
					var company = $(this).data('company');
					var designation = $(this).data('designation');
					var department = $(this).data('department');
					var basic_salary = $(this).data('basic_salary');
					var join_date = $(this).data('join_date');

					var avatar = $(this).data('avatar');
					$('.edit_id').val(id);
					$('.edit_firstname').val(firstname);
					$('.edit_uuid').val(uuid);
					$('.edit_lastname').val(lastname);
					$('.edit_email').val(email);
					$('.edit_phone').val(phone);
					$('.edit_join_date').val(join_date);
					$('.edit_company').val(company);
					$('.edit_designation').val(designation).trigger('change');
					$('.edit_department').val(department).trigger('change');
					$('.edit_avatar').val(avatar);
					$('.edit_basic_salary').val(basic_salary);
					$('.edit_department option').each(function() {
						if ($(this).val() == id) {
							$(this).attr('selected', 'selected');
						}
					});

					$('.edit_designation option').each(function() {
						if ($(this).val() == id) {
							$(this).attr('selected', 'selected');
						}
					});
					
				})
				$('.datatable').DataTable().destroy();
				$('.datatable').DataTable({
				dom: 'lBfrtip',
				buttons: [
					'excel', 'pdf', 'print'
				],
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