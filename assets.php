<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/asset.php');

// Kiểm tra đăng nhập
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}


$assetObj = new Asset($dbh);

if(isset($_POST['add_asset'])){
    // Assuming form fields are similar to attendance form fields
    $name = htmlspecialchars($_POST['name']);
    $uuid = htmlspecialchars($_POST['uuid']);
    $purchase_date = htmlspecialchars($_POST['purchase_date']);
    $purchase_from = htmlspecialchars($_POST['purchase_from']);
    $manufacturer = htmlspecialchars($_POST['manufacturer']);
    $model = htmlspecialchars($_POST['model']);
    $serial_number = htmlspecialchars($_POST['serial_number']);
    $status = htmlspecialchars($_POST['status']);
    $supplier = htmlspecialchars($_POST['supplier']);
    $condition = htmlspecialchars($_POST['condition']);
    $warranty = htmlspecialchars($_POST['warranty']);
    $value = htmlspecialchars($_POST['value']);
    $description = htmlspecialchars($_POST['description']);

    $result = $assetObj->addAsset($name, $uuid, $purchase_date, $purchase_from, $manufacturer, $model, $serial_number, $status, $supplier, $condition, $warranty, $value, $description);
    if($result){
        header("Location: assets.php?success=1");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

if(isset($_POST['update_asset'])){
    // Assuming form fields are similar to attendance form fields
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $uuid = htmlspecialchars($_POST['uuid']);
    $purchase_date = htmlspecialchars($_POST['purchase_date']);
    $purchase_from = htmlspecialchars($_POST['purchase_from']);
    $manufacturer = htmlspecialchars($_POST['manufacturer']);
    $model = htmlspecialchars($_POST['model']);
    $serial_number = htmlspecialchars($_POST['serial_number']);
    $status = htmlspecialchars($_POST['status']);
    $supplier = htmlspecialchars($_POST['supplier']);
    $condition = htmlspecialchars($_POST['condition']);
    $warranty = htmlspecialchars($_POST['warranty']);
    $value = htmlspecialchars($_POST['value']);
    $description = htmlspecialchars($_POST['description']);

    $result = $assetObj->updateAsset($id, $name, $uuid, $purchase_date, $purchase_from, $manufacturer, $model, $serial_number, $status, $supplier, $condition, $warranty, $value, $description);
    if($result){
        header("Location: assets.php?success=2");
        exit();
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}

if(isset($_GET['delid'])){
    $id = intval($_GET['delid']);

    $result = $assetObj->deleteAsset($id);
    if($result){
        header("Location: assets.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete asset');</script>";
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
        <title>Tài sản</title>
		
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
								<h3 class="page-title">Danh sách tài sản</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Tài sản</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_asset"><i class="fa fa-plus"></i> Thêm tài sản</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<!-- Search Filter -->
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">  
							<div class="form-group form-focus">
								<input type="text" class="form-control floating">
								<label class="focus-label">Employee Name</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option value=""> -- Select -- </option>
									<option value="0"> Pending </option>
									<option value="1"> Approved </option>
									<option value="2"> Returned </option>
								</select>
								<label class="focus-label">Status</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4">  
						   <div class="row">  
							   <div class="col-md-6 col-sm-6">  
									<div class="form-group form-focus">
										<div class="cal-icon">
											<input class="form-control floating datetimepicker" type="text">
										</div>
										<label class="focus-label">From</label>
									</div>
								</div>
							   <div class="col-md-6 col-sm-6">  
									<div class="form-group form-focus">
										<div class="cal-icon">
											<input class="form-control floating datetimepicker" type="text">
										</div>
										<label class="focus-label">To</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-2">  
							<a href="#" class="btn btn-success btn-block"> Search </a>  
						</div>     
                    </div>
					<!-- /Search Filter -->
					<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm tài sản thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật tài sản thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa tài sản thành công!
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
											<th>Tên tài sản</th>
											<th>Mã tài sản</th>
											<th>Ngày mua</th>
											<th>Mua từ</th>
											<th>Nhà sản xuất</th>
											<th>Model</th>
											<th>Serial Number</th>
											<th>Nhà cung cấp</th>
											<th>Tình trạng</th>
											<th>Bảo hành</th>
											<th>Giá</th>
											<th class="text-center">Trạng thái</th>
											<th class="text-right">Thao tác</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$cnt = 1;
										$results = $assetObj->viewAllAssets();
										if($results):
											foreach($results as $row):
											
									?>
									<tr>
										<td><?= htmlentities($cnt) ?></td>
										<td><?= htmlentities($row["name"]) ?></td>
										<td><?= htmlentities($row["uuid"]) ?></td>
										<td><?= htmlentities($row["purchase_date"]) ?></td>
										<td><?= htmlentities($row["purchase_from"]) ?></td>
										<td><?= htmlentities($row["manufacturer"]) ?></td>
										<td><?= htmlentities($row["model"]) ?></td>
										<td><?= htmlentities($row["serial_number"]) ?></td>
										<td><?= htmlentities($row["supplier"]) ?></td>
										<td><?= htmlentities($row["condition"]) ?></td>
										<td><?= htmlentities($row["warranty"]) ?></td>
										<td><?= htmlentities($row["value"]) ?></td>
										<td><?= htmlentities($row["status"]) ?></td>
										<td>
											<a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_asset" 
											data-id="<?=$row["id"]?>" data-name="<?=$row["name"]?>"
											data-uuid="<?=$row["uuid"]?>" data-pdate="<?=$row["purchase_date"]?>"
											 data-pfrom="<?=$row["purchase_from"]?>"
											 data-manufacturer="<?=$row["manufacturer"]?>"
											 data-model="<?=$row["model"]?>" data-sn="<?=$row["serial_number"]?>" data-supplier="<?=$row["supplier"]?>" data-condition="<?=$row["condition"]?>" data-warranty="<?=$row["warranty"]?>" data-value="<?=$row["value"]?>"
											 data-status="<?=$row["status"]?>" data-description="<?=$row["description"]?>"
												><i class="fa fa-pencil "></i></a>
												<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#delete_asset_<?=$row["id"]?>"><i class="fa fa-trash-o "></i></a>
										</td>
										
									</tr>
									<?php
												$cnt++;
											endforeach;
										endif;
									?>
													
										
									
										<div class="modal custom-modal fade" id="delete_asset_<?=$row["id"]?>" role="dialog" >
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-body">
														<div class="form-header">
															<h3>Xóa tài sản?</h3>
															<p>Bạn có chắc chắn muốn xóa?</p>
														</div>
														<div class="modal-btn delete-action">
															<div class="row">
																<div class="col-6">
																	<a href="assets.php?delid=<?=$row["id"]?>" type="submit" class="btn btn-primary continue-btn">Xóa</a>
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
									</tbody>
								</table>
							</div>
						</div>
					</div>
                </div>
				<!-- /Page Content -->
			
				<!-- Add Asset Modal -->
				<?php include_once("includes/modals/assets/add_asset.php"); ?>
				<!-- /Add Asset Modal -->
				
				<!-- Edit Asset Modal -->
				<?php include_once("includes/modals/assets/edit_asset.php"); ?>
				<!-- Edit Asset Modal -->
				
				
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
		
		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/dataTables.bootstrap4.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/js/select2.min.js"></script>
		
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
				function setupValidation(formId) {
				$(formId).validate({
					rules: {
						name: "required",
						purchase_date: "required",
						purchase_from: "required",
						manufacturer: "required",
						model: "required",
						serial_number: "required",
						supplier: "required",
						condition: "required",
						warranty: "required",
						value: "required",
						description: "required",
						status: "required"
					},
					messages: {
						name: "*Vui lòng nhập tên tài sản!",
						purchase_date: "*Vui lòng nhập ngày mua!",
						purchase_from: "*Vui lòng nhập nơi mua!",
						manufacturer: "*Vui lòng nhập nhà sản xuất!",
						model: "*Vui lòng nhập model!",
						serial_number: "*Vui lòng nhập số serial!",
						supplier: "*Vui lòng nhập nhà cung cấp!",
						condition: "*Vui lòng nhập tình trạng!",
						warranty: "*Vui lòng nhập thời gian bảo hành!",
						value: "*Vui lòng nhập giá trị!",
						description: "*Vui lòng nhập mô tả!",
						status: "*Vui lòng chọn trạng thái!"
					},
					errorPlacement: function(error, element) {
						if (element.is("select")) {
							error.insertAfter(element.next("span.select2"));
						} else {
							error.insertAfter(element);
						}
					}
				});
				$(formId + ' select').on('change', function() {
					$(this).valid();
				});
			}

		setupValidation("#form-add");
		setupValidation("#form-edit");
				$('.table').on('click','.editbtn',function(){
				$('#edit_asset').modal('show');
				var id = $(this).data('id');
				var uuid = $(this).data('uuid');
				var name = $(this).data('name');
				var purchase_date = $(this).data('pdate');
				var purchase_from = $(this).data('pfrom');
				var manufacturer = $(this).data('manufacturer');
				var serial_number = $(this).data('sn');
				var model = $(this).data('model');
				var supplier = $(this).data('supplier');
				var condition = $(this).data('condition');
				var warranty = $(this).data('warranty');
				var value = $(this).data('value');
				var status = $(this).data('status');
				var description = $(this).data('description');
				$('.edit_id').val(id);
				$('.edit_name').val(name);
				$('.edit_uuid').val(uuid);
				$('.edit_purchase_date').val(purchase_date);
				$('.edit_purchase_from').val(purchase_from);
				$('.edit_manufacturer').val(manufacturer);
				$('.edit_model').val(model);
				$('.edit_serial_number').val(serial_number);
				$('.edit_supplier').val(supplier);
				$('.edit_condition').val(condition);
				$('.edit_warranty').val(warranty);
				$('.edit_value').val(value);
				$(".edit_status").val(status).trigger('change');
				$('.edit_description').val(description);
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