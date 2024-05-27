﻿<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/leave.php');

if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}

$leavesObj = new Leave($dbh);
if(isset($_POST['status'])) {
	$status = $_POST['status'];
	$id = $_POST['id'];

	$update_sql = "UPDATE leaves SET status=:status WHERE id=:id";
	$update_query = $dbh->prepare($update_sql);
	$update_query->bindParam(':status', $status, PDO::PARAM_STR);
	$update_query->bindParam(':id', $id, PDO::PARAM_STR);
	$update_query->execute();
	$message = "Đổi mật khẩu thành công!";
}
// Thêm ngày nghỉ mới
if (isset($_POST['add_leave'])) {
    $employee_id = htmlspecialchars($_POST['employee_id']);
    $type = htmlspecialchars($_POST['type']);
    $from = htmlspecialchars($_POST['from']);
    $to = htmlspecialchars($_POST['to']);
    $reason = htmlspecialchars($_POST['reason']);
    $status = 0;

    $result = $leavesObj->addLeave($employee_id, $type, $from, $to, $reason, $status);
    if ($result) {
        header("Location: leaves-employee.php?success=1");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Sửa thông tin ngày nghỉ
if (isset($_POST['update_leave'])) {
    $id = htmlspecialchars($_POST['id']);
    $employee_id = htmlspecialchars($_POST['employee_id']);
    $type = htmlspecialchars($_POST['type']);
    $from = htmlspecialchars($_POST['from']);
    $to = htmlspecialchars($_POST['to']);
    $reason = htmlspecialchars($_POST['reason']);
    $status = htmlspecialchars($_POST['status']);

    $result = $leavesObj->updateLeave($id, $employee_id, $type, $from, $to, $reason, $status);
    if ($result) {
        header("Location: leaves-employee.php?success=2");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Xóa ngày nghỉ
if (isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    $result = $leavesObj->deleteLeave($id);
    if ($result) {
        header("Location: leaves-employee.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete leave');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Leaves - HRMS admin template</title>

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
                            <h3 class="page-title">Danh sách đơn xin nghỉ</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Đơn xin nghỉ</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i
                                    class="fa fa-plus"></i> Thêm đơn xin nghỉ</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert"
                    style="display: none;">
                    <strong>Success!</strong> Thêm nghỉ phép thành công!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert"
                    style="display: none;">
                    <strong>Success!</strong> Cập nhật nghỉ phép thành công!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert"
                    style="display: none;">
                    <strong>Success!</strong> Xóa nghỉ phép thành công!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nhân viên</th>
                                        <th>Từ ngày</th>
                                        <th>Đến ngày</th>
                                        <th>Tổng số ngày</th>
                                        <th>Lý do</th>
										<th>Trạng thái</th>
                                        <th class="text-right">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										$results = $leavesObj->viewAllLeaves();
										$cnt=1;
										if($results)
										{
										foreach($results as $row)
										{	
									?>
                                    <tr>
                                        <td><?=$cnt?></td>
                                        <td><?php echo htmlentities($row["firstname"] . ' ' . $row["lastname"] )?></td>
                                        <td><?php echo htmlentities(date('d/m/Y', strtotime($row["from"]))); ?></td>
                                        <td><?php echo htmlentities(date('d/m/Y', strtotime($row["to"]))); ?></td>
                                        <td><?=$diff_days = (strtotime($row["to"]) - strtotime($row["from"])) / (60 * 60 * 24) + 1;?>
                                        </td>
                                        <td><?php echo htmlentities($row["reason"]);?></td>
										<td>
											<?php if($row["status"] == 0): ?>
												<span class="badge bg-inverse-secondary">Chờ xác nhận</span>
											<?php elseif($row["status"] == 1):?>
												<span class="badge bg-inverse-success">Chấp nhận</span>
											<?php else: ?>
											<span class="badge bg-inverse-danger">Từ chối</span>
											<?php endif; ?>
										</td>
                                        <td class="text-right">
                                            <?php if($row["status"] == 0): ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?=$row["id"]?>">
                                                <button class="btn btn-success"
                                                    style="font-size: 13px; font-weight: 600; " type="submit"
                                                    name="status" value="1">
                                                    <i class="fa fa-check text-white" aria-hidden="true"></i> 
                                                </button>
                                                <button class="btn btn-danger" style="font-size: 13px;font-weight: 600;"
                                                    type="submit" name="status" value="2">
                                                    <i class="fa fa-times text-white" aria-hidden="true"></i> 
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                        </td>
                                    </tr>
                                    <div class="modal custom-modal fade" id="delete_leave_<?=$row["id"]?>"
                                        role="dialog">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="form-header">
                                                        <h3>Xóa đơn nghỉ phép?</h3>
                                                        <p>Bạn có chắc chắn muốn xóa?</p>
                                                    </div>
                                                    <div class="modal-btn delete-action">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <a href="leaves-employee.php?delid=<?php echo htmlentities($row["id"]);?>"
                                                                    class="btn btn-primary continue-btn">Xóa</a>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="javascript:void(0);" data-dismiss="modal"
                                                                    class="btn btn-primary cancel-btn">Hủy bỏ</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php $cnt+=1;
										}
									}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->

            <!-- Add Leave Modal -->
            <?php include_once 'includes/modals/leave/add_leave.php'; ?>
            <!-- /Add Leave Modal -->

            <!-- Edit Leave Modal -->
            <?php include_once 'includes/modals/leave/edit_leave.php'; ?>
            <!-- /Edit Leave Modal -->

            <!-- Delete Leave Modal -->

            <!-- /Delete Leave Modal -->

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

    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>

    <!-- Datatable JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

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
        $('.editbtn').click(function() {
            var id = $(this).data('id');
            var employee = $(this).data('employee');
            var leave_type = $(this).data('type');
            var from = $(this).data('from');
            var to = $(this).data('to');
            var reason = $(this).data('reason')
            $('.edit_id').val(id);
            $('.edit_employee').val(employee).trigger('change');
            $('.edit_type').val(leave_type).trigger('change');
            $('.edit_status').val(leave_type).trigger('change');
            $('.edit_from').val(from);
            $('.edit_to').val(to)
            $('.edit_reason').val(reason);
            // check employee select
            $(".edit_employee option").each(function() {
                if ($(this).val() == employee) {
                    $(this).attr('selected', 'selected');
                }
            });
            // check leave type select
            $(".edit_type option").each(function() {
                if ($(this).val() == leave_type) {
                    $(this).attr('selected', 'selected');
                }
            });
            // check status select
            $(".edit_status option").each(function() {
                if ($(this).val() == status) {
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