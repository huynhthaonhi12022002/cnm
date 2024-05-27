<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/user.php');

// Kiểm tra đăng nhập
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}

// Khởi tạo đối tượng User
$userObj = new User($dbh);

// Thêm người dùng mới
if (isset($_POST['add_user'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    $avatar_name = $_FILES["avatar"]["name"];
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);

    // Xử lý tên file avatar
    $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
    $new_avatar_name = md5($avatar_name . time()) . '.' . $extension;
    move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/users/" . $new_avatar_name);

    // Thêm người dùng vào cơ sở dữ liệu
    $result = $userObj->addUser($name, $email, $password, $new_avatar_name, $role, $status);
    if ($result) {
        header("Location: users.php?success=1");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Sửa thông tin người dùng
if (isset($_POST['update_user'])) {
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
	if(isset($_POST["password"])) {
		$password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
	} else {
		$password = $_POST["old_password"];
	}
    $avatar_name = $_FILES["avatar"]["name"];
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);

    // Kiểm tra xem có tệp avatar mới được tải lên không
    if (!empty($_FILES["avatar"]["name"])) {
        $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
        $new_avatar_name = md5($avatar_name . time()) . '.' . $extension;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/users/" . $new_avatar_name);
    } else {
        // Nếu không, sử dụng avatar cũ
        $new_avatar_name = htmlspecialchars($_POST['old_avatar']);
    }

    // Cập nhật thông tin người dùng vào cơ sở dữ liệu
    $result = $userObj->updateUser($id, $name, $email, $password, $new_avatar_name, $role, $status);
    if ($result) {
        header("Location: users.php?success=2");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Xóa người dùng
if (isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    $result = $userObj->deleteUser($id);
    if ($result) {
        header("Location: users.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete user');</script>";
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
        <title>Người dùng</title>
		
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
			<?php include_once('includes/notification/notify.php');?>

			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Danh sách người dùng</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Người dùng</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Thêm người dùng</a>
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
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table datatable">
									<thead>
										<tr><th>STT</th>
											<th>Tên</th>
											<th>Email</th>
											<th>Vai trò</th>
											<th>Trạng thái</th>
											<th>Ngày tạo</th>
											<th class="text-right">Thao tác</th>
										</tr>
									</thead>
									<tbody>
									<?php
										
										$results= $userObj->viewAllUsers();
										$cnt=1;
										if($results)
										{
										foreach($results as $row)
										{	
									?>
								
										<tr>
											<td><?=$cnt++?></td>
											<td>
												<h2 class="table-avatar">
													<a href="profile.php" class="avatar"><img src="upload/users/<?php echo htmlentities($row["avatar"]);?>" alt="Profile Pic"></a>
													<a href="profile.php"><?php echo htmlentities($row["name"]);?>
													<!-- <span><?php echo htmlentities($row["name"]);?></span> -->
												</a>
												</h2>
											</td>
											<td><?php echo htmlentities($row["email"]);?></td>
											<td>
												<?php if($row["role"] == 1): ?>
													<button class="btn btn-info text-center" style="min-width:100px">Admin</button>
												<?php elseif($row["role"] == 0): ?>
													<button class="btn btn-secondary text-center" style="min-width:100px">Nhân viên</button>
												<?php else: ?>
													<button class="btn btn-success text-center" style="min-width:100px">Ứng viên</button>
												<?php endif ?>

											</td>
											<td>
												<?php if($row["status"] == 1): ?>
													<span class="badge bg-inverse-success">Active</span>
												<?php else: ?>
													<span class="badge bg-inverse-danger">InActive</span>
												<?php endif ?>

											</td>
											<td><?php echo htmlentities($row["created_at"]);?></td>
											<td class="text-right">
												<a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_user"
												data-id="<?=$row["id"]?>" data-name="<?=$row["name"]?>" data-email="<?=$row["email"]?>" data-status="<?=$row["status"]?>"  data-role="<?=$row["role"]?>" data-password="<?=$row["password"]?>" data-avatar="<?=$row["avatar"]?>"
												><i class="fa fa-pencil"></i> </a>
												<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#delete_user_<?=$row["id"]?>"><i class="fa fa-trash-o"></i> </a>
											</td>
										</tr>
										<div class="modal custom-modal fade" id="delete_user_<?=$row["id"]?>" role="dialog">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-body">
														<div class="form-header">
															<h3>Xóa người dùng</h3>
															<p>Bạn có chắc chắn muốn xóa?</p>
														</div>
														<div class="modal-btn delete-action">
															<div class="row">
																<div class="col-6">
																<a href="users.php?delid=<?=$row["id"]?>" class="btn btn-primary continue-btn">Xóa</a>
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
										<div id="edit_user" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Sửa người dùng</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" enctype="multipart/form-data" id="form-edit">
									<div class="row">
									<div class="col-sm-6">
									<input class="form-control edit_id"  name="id" type="hidden">
											<div class="form-group">
												<label>Tên <span class="text-danger">*</span></label>
												<input class="form-control edit_name" required name="name" type="text">
											</div>
										</div>
								
										<div class="col-sm-6">
											<div class="form-group">
												<label>Email <span class="text-danger">*</span></label>
												<input class="form-control edit_email" required name="email" type="email">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Mật khẩu</label>
												<input class="form-control edit_password"  name="old_password" type="hidden">
												<input class="form-control" name="password" required type="password">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Nhập lại mật khẩu</label>
												<input class="form-control" name="confirm_password" required type="password">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Trạng thái </label>
												<select name="status" id="" class="select form-control edit_status">
													<option value="">Chọn trạng thái</option>
													<option value="1">Active</option>
													<option value="0">InActive</option>
													
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Vai trò </label>
												<select name="role" id="" class="select form-control edit_role">
													<option value="">Chọn vai trò</option>
													<option value="1">Admin</option>
													<option value="0">Employee</option>
												</select>
											</div>
										</div>
										
										<div class="col-sm-12">
										<div class="form-group">
												<label>Avatar <span class="text-danger">*</span></label>
												<input class="form-control"  name="avatar" type="file">
												<input class="form-control edit_avatar"  name="old_avatar" type="hidden">

											</div>
										</div>
									
										<div class="col-sm-12">
											<div class="submit-section">
												<button type="submit" name="update_user" class="btn btn-primary submit-btn">Lưu</button>
											</div>
										</div>
								</form>
							</div>
						</div>
					</div>
				</div>
									<?php $cnt=$cnt+1; }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
                </div>
				<!-- /Page Content -->
				
				<!-- Add User Modal -->
				<?php include_once("includes/modals/user/add_user.php"); ?>
				<!-- /Add User Modal -->
				
			
			
				
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
				function setupValidation(formId) {
				$(formId).validate({
					rules: {
						name: {
							required: true
						},
						role: {
							required: true
						},
						email: {
							required: true,
							email: true // Kiểm tra định dạng email
						},
						password: {
							required: true
						},
						confirm_password: {
							required: true,
							equalTo: "#password",
							equalTo: "#password1"
						},
						status: {
							required: true
						}
					},
					messages: {
						name: "*Vui lòng nhập tên!",
						role: "*Vui lòng chọn vai trò!",
						email: {
							required: "*Vui lòng nhập địa chỉ email!",
							email: "*Vui lòng nhập đúng định dạng email!"
						},
						password: "*Vui lòng nhập mật khẩu!",
						status:"*Vui lòng chọn trạng thái!",
						confirm_password: {
							required: "*Vui lòng nhập lại mật khẩu!",
							equalTo: "*Mật khẩu xác nhận phải giống với mật khẩu đã nhập."
						},
					},
					errorPlacement: function(error, element) {
						if (element.is("select")) {
							error.insertAfter(element.next("span.select2"));
						} else {
							error.insertAfter(element);
						}
					}
				});
			}

		setupValidation("#form-add");
		setupValidation("#form-edit");
				$('.editbtn').on('click', function() {
					var id = $(this).data('id');
					var name = $(this).data('name');
					var email = $(this).data('email');
					var password = $(this).data('password');
					var role = $(this).data('role');
					var status = $(this).data('status');
					var avatar = $(this).data('avatar');
					$('.edit_id').val(id);
					$('.edit_name').val(name);
					$('.edit_email').val(email);
					$('.edit_password').val(password);
					$('.edit_role').val(role).trigger('change');
					$('.edit_status').val(status).trigger('change');
					$('.edit_avatar').val(avatar);
					$('.edit_role option').each(function() {
						if ($(this).val() == id) {
							$(this).attr('selected', 'selected');
						}
					});

					$('.edit_status option').each(function() {
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