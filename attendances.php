<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/attendance.php');

// Kiểm tra đăng nhập
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}


$attendanceObj = new Attendance($dbh);

if(isset($_POST['add_attendance'])){
    $employee_id = htmlspecialchars($_POST['employee_id']);
    $checkin = htmlspecialchars($_POST['checkin']);
    $checkout = htmlspecialchars($_POST['checkout']);
    if( strtotime($_POST['checkin']) > strtotime('08:00:00') ) {
        $status = "Trễ";
    } elseif(strtotime($_POST['checkin']) == strtotime('08:00:00')) {
        $status = "Đúng giờ";
    } else {
        $status = "Sớm";
    }
    $result = $attendanceObj->addAttendance($employee_id, $checkin, $checkout, $status);
    if($result){
        header("Location: attendances.php?success=1");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

if(isset($_POST['update_attendance'])){
    $id = htmlspecialchars($_POST['id']);
    $employee_id = htmlspecialchars($_POST['employee_id']);
    $checkin = htmlspecialchars($_POST['checkin']);
    $checkout = htmlspecialchars($_POST['checkout']);

    $result = $attendanceObj->updateAttendance($id, $employee_id, $checkin, $checkout, $status);
    if($result){
        header("Location: attendances.php?success=2");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

if(isset($_GET['delid'])){
    $id = intval($_GET['delid']);

    $result = $attendanceObj->deleteAttendance($id);
    if($result){
        header("Location: attendances.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete attendance');</script>";
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
        <title>Chấm công</title>
		
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
								<h3 class="page-title">Danh sách chấm công</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Chấm công</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<!-- <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_attendance"><i class="fa fa-plus"></i> Add Attendance</a> -->
							
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm chấm công thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật chấm công thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa chấm công thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table datatable">
									<thead>
										<tr>
											
											<th>#</th>
											<th>Họ và tên</th>
                                            <th>Checkin</th>
                                            <th>Checkout</th>
                                            <th>Ngày chấm công</th>
											<th class="text-center">Thao tác</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$results = $attendanceObj->viewAllAttendance();
										$cnt=1;
										if($results)
										{
										foreach($results as $row)
										{	
									?>
										<tr>
											<td><?=$cnt?></td>
											<td><?php echo htmlentities($row["firstname"]." ". $row["lastname"]); ?></td>
                                            <td><?php echo htmlentities($row["checkin"]); ?></td>
                                            <td><?php echo htmlentities($row["checkout"]); ?></td>
                                            <td><?php echo date('d/m/Y',htmlentities(strtotime($row["created_at"]))); ?></td>

											<td class="text-center">
												<a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_attendance" data-id="<?=$row["id"]?>" 
												data-checkin="<?=$row["checkin"]?>" data-checkout="<?=$row["checkout"]?>" data-status="<?=$row["status"]?>" data-employee_id="<?=$row["employee_id"]?>"><i class="fa fa-pencil "></i></a>
												<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#delete_attendance_<?=$row["id"]?>"><i class="fa fa-trash-o "></i> </a>
											</td>
										</tr>
                                    <div class="modal custom-modal fade" id="delete_attendance_<?=$row["id"]?>" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="form-header">
                                                        <h3>Delete Attendance</h3>
                                                        <p>Are you sure want to delete?</p>
                                                    </div>
                                                    <div class="modal-btn delete-action">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <a href="attendances.php?delid=<?=$row["id"]?>" class="btn btn-primary continue-btn">Delete</a>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?php $cnt+=1; }}?>
											</tbody>
								</table>
							</div>
						</div>
					</div>
                </div>
				<!-- /Page Content -->
			
				<!-- Add Client Modal -->
				<?php include_once("includes/modals/attendances/add_attendance.php"); ?>
				<!-- /Add Client Modal -->
				<?php include_once("includes/modals/attendances/edit_attendance.php"); ?>
				<!-- Edit Client Modal -->
			
				<!-- /Delete Client Modal -->
				
            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->
		
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
                $('.editbtn').on('click', function() {
                    var id = $(this).data('id');
                    var checkin = $(this).data('checkin');
                    var checkout = $(this).data('checkout');
                    var employee_id = $(this).data('employee_id');
                    var status = $(this).data('status'); 
                    $('#edit_id').val(id);
                    $('#edit_checkin').val(checkin);
                    $('#edit_checkout').val(checkout);
                    $('#edit_employee').val(employee_id).trigger('change');
                    $('#edit_status').val(status); 
                    $('#edit_employee option').each(function() {
						if ($(this).val() == id) {
							$(this).attr('selected', 'selected');
						}
					});

                });
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