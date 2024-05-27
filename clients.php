<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/client.php');

if (strlen($_SESSION['userlogin']) == 0) {
	header('location:login.php');
}

$clientObj = new Client($dbh);

if (isset($_POST['add_client'])) {
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$email = htmlspecialchars($_POST['email']);
	$phone = htmlspecialchars($_POST['phone']);
	$company = htmlspecialchars($_POST['company']);
	$address = htmlspecialchars($_POST['address']);
	$avatar_name = $_FILES["avatar"]["name"];
	$extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
	$new_avatar_name = md5($avatar_name . time()) . '.' . $extension;
	move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/clients/" . $new_avatar_name);
	$result = $clientObj->addClient($firstname, $lastname, $email, $phone, $company, $address, $new_avatar_name);
	if ($result) {
		header("Location: clients-list.php?success=1");
		exit();
	} else {
		echo "<script>alert('Something Went wrong');</script>";
	}
}

if (isset($_POST['update_client'])) {
	$id = htmlspecialchars($_POST['id']);
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$email = htmlspecialchars($_POST['email']);
	$phone = htmlspecialchars($_POST['phone']);
	$company = htmlspecialchars($_POST['company']);
	$address = htmlspecialchars($_POST['address']);

	// Lấy tên tệp hình ảnh hiện tại từ trường ẩn
	$old_avatar = htmlspecialchars($_POST['old_avatar']);

	// Kiểm tra xem có tệp avatar mới được tải lên không
	if (!empty($_FILES["avatar"]["name"])) {
		$avatar_name = $_FILES["avatar"]["name"];
		$extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
		$avatar = md5($avatar_name . time()) . '.' . $extension;
		move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/clients/" . $avatar);
	} else {
		// Nếu không, sử dụng tên tệp hình ảnh hiện tại
		$avatar = $old_avatar;
	}

	$result = $clientObj->updateClient($id, $firstname, $lastname, $email, $phone, $company, $address, $avatar);
	if ($result) {
		header("Location: clients-list.php?success=2");
		exit();
	} else {
		echo "<script>alert('Something Went wrong');</script>";
	}
}


// Kiểm tra xem có tham số delid được truyền vào không
if (isset($_GET['delid'])) {
	$id = intval($_GET['delid']);

	// Gọi phương thức xóa client từ đối tượng client
	$result = $clientObj->deleteClient($id);
	if ($result) {
		header("Location: clients-list.php?success=0");
		exit();
	} else {
		echo "<script>alert('Error: Unable to delete client');</script>";
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
	<title>Clients - HRMS admin template</title>

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
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title">Danh sách khách hàng</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item active">Khách hàng</li>
							</ul>
						</div>

						<div class="col-auto float-right ml-auto">
							<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_client"><i class="fa fa-plus"></i>Thêm khách hàng</a>
							<div class="view-icons">
								<a href="clients.php" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
								<a href="clients-list.php" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
							</div>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm khách hàng thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật khách hàng thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa khách hàng thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

				<div class="row staff-grid-row">
					<?php
					$results = $clientObj->getAllClients();
					$cnt = 1;
					if ($results) {
						foreach ($results as $row) {
					?>
							<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
								<div class="profile-widget">
									<div class="profile-img">
										<a href="#" class="avatar"><img alt="picture" src="upload/clients/<?php echo htmlentities($row["avatar"]); ?>"></a>
									</div>
									<div class="dropdown profile-action">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item editbtn" href="#" data-toggle="modal" data-target="#edit_client" data-toggle="modal" data-target="#edit_client" data-id="<?=$row["id"]?>" data-address="<?=$row["address"]?>" data-avatar="<?=$row["avatar"]?>"
												data-firstname="<?=$row["firstname"]?>" data-lastname="<?=$row["lastname"]?>" data-phone="<?=$row["phone"]?>" data-email="<?=$row["email"]?>" data-company="<?=$row["company"]?>"><i class="fa fa-pencil m-r-5"></i> Sửa</a>
											<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_client_<?=$row["id"]?>"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
										</div>
									</div>
									<h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="#"><?php echo htmlentities($row["company"]); ?></a></h4>
									<h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="#"><?php echo htmlentities(($row["firstname"]).' '.($row["lastname"])); ?></a></h5>
									<div class="small text-muted"><?php echo htmlentities($row["email"]); ?></div>
									<div class="small text-muted"><?php echo htmlentities($row["phone"]); ?></div>
									<div class="small text-muted"><?php echo htmlentities($row["address"]); ?></div>
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
			<!-- /Page Content -->

			<?php include_once("includes/modals/clients/edit_client.php"); ?>
			<!-- Add Client Modal -->
			<?php include_once("includes/modals/clients/add_client.php"); ?>
			<!-- /Delete Client Modal -->

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

	<!-- Datatable JS -->
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>

	<!-- Select2 JS -->
	<script src="assets/js/select2.min.js"></script>

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
			setupValidation("#form-add");
			setupValidation("#form-edit");

			function setupValidation(formId) {
				$(formId).validate({
					rules: {
						firstname: {
							required: true
						},
						lastname: {
							required: true
						},
						email: {
							required: true,
							email: true // Kiểm tra định dạng email
						},
						phone: {
							required: true
						},
						address: {
							required: true
						},
						company: {
							required: true
						}
					},
					messages: {
						firstname: "*Vui lòng nhập họ đệm!",
						lastname: "*Vui lòng nhập tên!",
						email: {
							required: "*Vui lòng nhập địa chỉ email!",
							email: "*Vui lòng nhập đúng định dạng email!"
						},
						address: "*Vui lòng nhập địa chỉ!",
						phone: "*Vui lòng nhập số điện thoại!",
						company: "*Vui lòng nhập tên công ty!",

					},
				});
			}
			$('.editbtn').on('click', function() {
				$('#edit_client').modal('show');
				var id = $(this).data('id');
				var firstname = $(this).data('firstname');
				var lastname = $(this).data('lastname');
				var email = $(this).data('email');
				var phone = $(this).data('phone');
				var avatar = $(this).data('avatar');
				var company = $(this).data('company');
				var address = $(this).data('address');
				$('#edit_id').val(id);
				$('#edit_firstname').val(firstname);
				$('#edit_lastname').val(lastname);
				$('#edit_address').val(address);
				$('#edit_email').val(email);
				$('#edit_phone').val(phone);
				$('#edit_company').val(company);
				$('#edit_avatar').val(avatar);
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