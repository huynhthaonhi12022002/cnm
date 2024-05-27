<?php
declare(strict_types=1);
session_start();
use chillerlan\QRCode\{QRCode, QROptions};

require_once('./vendor/autoload.php');
?>
<?php
error_reporting(0);
include_once('includes/config.php');
include_once('class/payroll.php');

if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}

$payrollObj = new Payroll($dbh);

// Add new payroll entry
if (isset($_POST['add_payroll'])) {
    $employee_id = htmlspecialchars($_POST['employee_id']);
	$salary = $payrollObj->getEmployeeById($employee_id);
	$new_salary = $salary["basic_salary"];
    $work_day = htmlspecialchars($_POST['work_day']);
    $allowance = htmlspecialchars($_POST['allowance']);
    $month_salary = htmlspecialchars($_POST['month_salary']);
    $status = htmlspecialchars($_POST['status']);
    $deduction = htmlspecialchars($_POST['deduction']);
    $paid_type = htmlspecialchars($_POST['paid_type']);
    $paid_date = htmlspecialchars($_POST['paid_date']);
    $total_salary = $new_salary + $allowance - $deduction;

    $result = $payrollObj->addPayroll($employee_id, $work_day, $allowance, $month_salary, $status, $deduction, $total_salary, $paid_type, $paid_date);
    if ($result) {
        header("Location: salary.php?success=1");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Update payroll information
if (isset($_POST['update_payroll'])) {
    $id = htmlspecialchars($_POST['id']);
    $employee_id = htmlspecialchars($_POST['employee_id']);
	$salary = $payrollObj->getEmployeeById($employee_id);
	$new_salary = $salary["basic_salary"];
    $work_day = htmlspecialchars($_POST['work_day']);
    $allowance = htmlspecialchars($_POST['allowance']);
    $month_salary = htmlspecialchars($_POST['month_salary']);
    $status = htmlspecialchars($_POST['status']);
    $deduction = htmlspecialchars($_POST['deduction']);
	$total_salary = $new_salary + $allowance - $deduction;
    $paid_type = htmlspecialchars($_POST['paid_type']);
    $paid_date = htmlspecialchars($_POST['paid_date']);

    $result = $payrollObj->updatePayroll($id, $employee_id, $work_day, $allowance, $month_salary, $status, $deduction, $total_salary, $paid_type, $paid_date);
    if ($result) {
        header("Location: salary.php?success=2");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

// Delete payroll entry
if (isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    $result = $payrollObj->deletePayroll($id);
    if ($result) {
        header("Location: salary.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete payroll');</script>";
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
        <title>Bảng lương</title>
		
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
								<h3 class="page-title">Danh sách bảng lương</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Bảng lương</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Thêm bảng lương</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm công việc thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật công việc thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa công việc thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					<!-- Search Filter -->
					<div class="row filter-row">
					   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
							<div class="form-group form-focus">
								<input type="text" class="form-control floating">
								<label class="focus-label">Employee Name</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option value=""> -- Select -- </option>
									<option value="">Employee</option>
									<option value="1">Manager</option>
								</select>
								<label class="focus-label">Role</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option> -- Select -- </option>
									<option> Pending </option>
									<option> Approved </option>
									<option> Rejected </option>
								</select>
								<label class="focus-label">Leave Status</label>
							</div>
					   </div>
					   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
							<div class="form-group form-focus">
								<div class="cal-icon">
									<input class="form-control floating datetimepicker" type="text">
								</div>
								<label class="focus-label">From</label>
							</div>
						</div>
					   <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
							<div class="form-group form-focus">
								<div class="cal-icon">
									<input class="form-control floating datetimepicker" type="text">
								</div>
								<label class="focus-label">To</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">  
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
											<th>#</th>
											<th>Tên nhân viên</th>
											<th>Lương cơ bản</th>
											<th>Lương tháng</th>
											<th>Ngày công</th>
											<th>Thực lãnh</th>
											<th>Ngày tính lương</th>
                                            <!-- <th>QR Code</th> -->
											<th>Trạng thái</th>
											<th class="text-right">Thao tác</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i = 1;
										$results = $payrollObj->viewAllPayroll();
										if ($results):
											foreach($results as $row):
                                            $options = new QROptions([
                                                'eccLevel' => QRCode::ECC_L,
                                                'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                                                'version' => 5,
                                            ]);
                                            $qrcode = new QRCode($options);
                                            $qrCodePayroll = $qrcode->render("http://localhost/cnm/salary-view.php?id=".$row['id']);
										?>
										<tr>
											<td><?=$i?></td>
											<td>
												<?=$row['firstname'].' '.$row['lastname']?>
											</td>
											<td class="text-danger">
												<?=number_format($row['basic_salary'], 0, ',', '.') . ' đ'?>
											</td>
											<td>
												<?=date('m/Y',strtotime($row['month_salary']))?>
											</td>
											<td>
												<?=$row['work_day']?>
											</td>
											<td class="text-blue">
												<?=number_format($row['total_salary'], 0, ',', '.') . ' đ'?>
											</td>
											<td>
												<?=date('d/m/Y',strtotime($row['paid_date']))?>
											</td>
                                            <!-- <td>
                                                <img src="<?=$qrCodePayroll?>" alt="" width="80" height="80" srcset="">
                                            </td> -->
											<td>
												<?php if($row['status']==1): ?>
													<button class="btn btn-success">Đã thanh toán</button>
												<?php else: ?>
													<button class="btn btn-danger">Chưa thanh toán</button>
												<?php endif; ?>
											</td>
											<td>
												<a class="btn btn-info" href="salary-view.php?id=<?=$row["id"]?>" ><i class="fa fa-eye"></i></a>
												<a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_salary" 
												data-id="<?=$row["id"]?>" 
												data-employee_id="<?=$row["employee_id"]?>" 
												data-work_day="<?=$row["work_day"]?>"
												data-allowance="<?=$row["allowance"]?>" 
												data-month_salary="<?=$row["month_salary"]?>" 
												data-status="<?=$row["status"]?>" 
												data-deduction="<?=$row["deduction"]?>" 
												data-total_salary="<?=$row["total_salary"]?>"
                                                data-paid_type="<?=$row["paid_type"]?>" 
												data-paid_date="<?=$row["paid_date"]?>" 
                                                ><i class="fa fa-pencil"></i></a>
												<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#delete_salary_<?=$row["id"]?>"><i class="fa fa-trash-o"></i></a>
											</td>
											<div class="modal custom-modal fade" id="delete_salary_<?=$row["id"]?>" role="dialog">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<div class="modal-body">
															<div class="form-header">
																<h3>Xóa bảng lương này?</h3>
																<p>Bạn có chắc chắn muốn xóa?</p>
															</div>
															<div class="modal-btn delete-action">
																<div class="row">
																	<div class="col-6">
																		<a href="salary.php?delid=<?=$row["id"]?>" class="btn btn-primary continue-btn">Xóa</a>
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
										</tr>
										<?php 
											$i++;
											endforeach;
										endif;
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
                </div>
				<!-- /Page Content -->
				
				<!-- Add Salary Modal -->
				<?php include_once("includes/modals/salary/add.php"); ?>
				<!-- /Add Salary Modal -->
				
				<!-- Edit Salary Modal -->
				<?php include_once("includes/modals/salary/edit.php"); ?>
				<!-- /Edit Salary Modal -->
				
				<!-- Delete Salary Modal -->
				<!-- /Delete Salary Modal -->
				
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
                $('.select').select2({
					dropdownSearch: true
				});
				setupValidation("#form-add");
				setupValidation("#form-edit");
				function setupValidation(formId) {
					$(formId).validate({
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
							employee_id: {
								required: true
							},
							paid_type: {
								required: true
							},
							work_day: {
								required: true,
								
							},
							month_salary: {
								required: true
							},
							status: {
								required: true
							},
							paid_date: {
								required: true
							}
						},
						messages: {
							employee_id: "*Vui lòng chọn nhân viên!",
							paid_type: "*Vui lòng chọn hình thức thanh toán!",
							work_day: "*Vui lòng nhập số ngày công!",
							month_salary:"*Vui lòng chọn lương thángtháng!",
							status: "*Vui lòng chọn trạng thái!",
							paid_date: "*Vui lòng chọn ngày thanh toán!",

						},
					});
				}
                $('.datatable').on('click','.editbtn',function (){
				var id = $(this).data('id');
				var employee_id = $(this).data('employee_id');
				var work_day = $(this).data('work_day');
				var allowance = $(this).data('allowance');
				var month_salary = $(this).data('month_salary');
				var status = $(this).data('status');
				var deduction = $(this).data('deduction');
				var total_salary = $(this).data('total_salary');
                var paid_type = $(this).data('paid_type');
                var paid_date = $(this).data('paid_date');
				$('.edit_id').val(id);
				$('.edit_employee_id').val(employee_id).trigger('change');;
				$('.edit_work_day').val(work_day);
				$('.edit_allowance').val(allowance);
                $('.edit_month_salary').val(month_salary);
                $('.edit_deduction').val(deduction);
                $('.edit_total_salary').val(total_salary);
                $('.edit_paid_date').val(paid_date);
				$('.edit_status').val(status).trigger('change');
				$('.edit_paid_type').val(paid_type).trigger('change');
				$('.edit_employee_id option').each(function() {
						if ($(this).val() == id) {
							$(this).attr('selected', 'selected');
						}
					});
                $('.edit_paid_type option').each(function() {
						if ($(this).val() == id) {
							$(this).attr('selected', 'selected');
						}
					});
                $('.edit_status option').each(function() {
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