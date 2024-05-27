<?php 
session_start();
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
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $payslip = $payrollObj->viewPayrollById($id);
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
        <title>Chi tiết bảng lương</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="assets/css/line-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		<style>
@media print {
    /* Hide unnecessary elements */
    .container .row .col-auto,
    .container .row .col-md-12 {
        display: none !important;
    }
    /* Customize printing styles here */
    .payslip-title {
        font-size: 24px; /* Ví dụ: tăng kích thước font cho tiêu đề */
    }
}
</style>
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
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Chi tiết phiếu lương</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Phiếu lương tháng <?=date("m/Y",strtotime($payslip["month_salary"]))?></li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<div class="btn-group btn-group-sm">
									<!-- <button class="btn btn-white" id="print-csv">CSV</button>
									<button class="btn btn-white" id="print-pdf">PDF</button> -->
									<button class="btn btn-white" id="print-btn"><i class="fa fa-print fa-lg"></i> Print</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card" id="print-content">
								<div class="card-body">
									<h4 class="payslip-title">Phiếu lương </h4>
									<div class="row">
										<div class="col-sm-6 m-b-20">
											<img src="assets/img/logo2.png" class="inv-logo" alt="">
											<ul class="list-unstyled mb-0">
												<li>Công ty ABC Technologies</li>
												<li>12 Nguyễn Văn Bảo, Phường 4, Gò Vấp, TP.HCM</li>
											</ul>
										</div>
										<div class="col-sm-6 m-b-20">
											<div class="invoice-details">
												<h3 class="text-uppercase">Phiếu lương #<?=$payslip["id"]?></h3>
												<ul class="list-unstyled">
													<li>Lương tháng: <span><?=date("m/Y",strtotime($payslip["month_salary"]))?></span></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 m-b-20">
											<ul class="list-unstyled">
												<?php 
													$employee = $payrollObj->getEmployeeById($payslip["employee_id"]);
												?>
												<li><strong>Họ và tên:</strong> <h5 class="mb-0 d-inline-block text-blue"><strong><?=$employee["firstname"]." ".$employee["lastname"]?></strong></h5></li>
												<li><strong>Phòng ban: </strong><span><?=$employee["department_name"]?></span></li>
												<li><strong>Chức vụ: </strong><span><?=$employee["designation_name"]?></span></li>
												<li><strong>Mã nhân viên: </strong><?=$employee["uuid"]?></li>

											</ul>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div>
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td><strong>Lương cơ bản</strong> <span class="float-right"><?=number_format(htmlentities($employee['basic_salary']), 0, ',', '.') . ' đ'?></span></td>
														</tr>
														<tr>
															<td><strong>Phụ cấp (xăng xe, ăn uống,...)</strong> <span class="float-right"><?=number_format(htmlentities($payslip["allowance"]), 0, ',', '.') . ' đ'?></span></td>
														</tr>
														<tr>
															<td><strong>Khoản khấu trừ</strong> <span class="float-right"><?=number_format(htmlentities($payslip["deduction"]), 0, ',', '.') . ' đ'?></span></td>
														</tr>
														<tr>
															<td><strong>Số ngày công</strong> <span class="float-right"><strong><?=htmlentities($payslip["work_day"])?> ngày</strong></span></td>
														</tr>
														<tr>
															<td><strong>Ngày thanh toán</strong> <span class="float-right"><strong><?=date("d/m/Y",htmlentities(strtotime($payslip["paid_date"])))?></strong></span></td>
														</tr>
														<tr>
															<td><strong>Hình thức thanh toán</strong> <span class="float-right"><strong><?php if($payslip["paid_type"]==1):?>Tiền mặt <?php elseif($payslip["paid_type"]==2): ?>Bank <?php else:?>Ví điện tử<?php endif;?></strong></span></td>
														</tr>
														<tr>
															<td><strong>Trạng thái</strong> <span class="float-right"><strong><?=htmlentities($payslip["status"]) ? '<span class="text-success">Đã thanh toán</span>' : '<span class="text-danger">Chưa thanh toán</span>';?></strong></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										
										<div class="col-sm-12">
											<p class="text-danger"><strong>Tổng lương: </strong><?=number_format(htmlentities($payslip["total_salary"]), 0, ',', '.') . ' đ'?></p>
										</div>
									</div>
								</div>
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
        <script src="assets/js/jquery-3.2.1.min.js"></script>

		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/app.js"></script>
		<script>
		document.getElementById("print-btn").addEventListener("click", function() {
			var content = document.getElementById("print-content").innerHTML;
			var printWindow = window.open('', '_blank');
			printWindow.document.write('<html><head><title>Print</title>');
			printWindow.document.write('<link rel="stylesheet" href="assets/css/style.css" type="text/css" />'); // Đường dẫn đến stylesheet của bạn
			printWindow.document.write('<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />'); // Đường dẫn đến stylesheet của bạn

			printWindow.document.write('</head><body>');
			printWindow.document.write(content);
			printWindow.document.write('</body></html>');
			printWindow.document.close();
			printWindow.print();
		});
		</script>
    </body>
</html>