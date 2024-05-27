<?php 
    session_start();
    error_reporting(0);
    include_once('includes/config.php');
    include_once('class/department.php');

// Kiểm tra đăng nhập
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}


    $departmentObj = new Department($dbh);

    if (isset($_POST['add_department'])) {
        $name = htmlspecialchars($_POST['name']);
        $result = $departmentObj->addDepartment($name);
        if ($result) {
            header("Location: departments.php?success=1");
            exit();
        } else {
            echo "<script>alert('Something Went wrong');</script>";
        }
    }
    
    if (isset($_POST['update_department'])) {
        $id = htmlspecialchars($_POST['id']);
        $name = htmlspecialchars($_POST['name']);
        $result = $departmentObj->updateDepartment($id, $name);
        if ($result) {
            header("Location: departments.php?success=2");
            exit();
        } else {
            echo "<script>alert('Something Went wrong');</script>";
        }
    }
    
    // Kiểm tra xem có tham số delid được truyền vào không
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $result = $departmentObj->deleteDepartment($rid);
        if ($result) {
            header("Location: departments.php?success=0");
            exit();
        } else {
            echo "<script>alert('Error: Unable to delete department');</script>";
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
    <title>Phòng ban</title>
    
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
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
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
                            <h3 class="page-title">Danh sách phòng ban</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Phòng ban</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i> Thêm phòng ban</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
				<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm phòng ban thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật phòng ban thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa phòng ban thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th>Tên phòng ban</th>
                                        <th class="text-right">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = "SELECT * FROM departments";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $row) {
                                ?>
                           
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo htmlentities($row->name);?></td>
                                        <td class="text-right">
                                            <a class="btn editbtn btn-warning" href="#" data-toggle="modal" data-target="#edit_department" data-id="<?=$row->id?>" data-name="<?=$row->name?>"><i class="fa fa-pencil "></i> </a>
                                            <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#delete_department_<?=$row->id?>"><i class="fa fa-trash-o "></i> </a>
                                        </td>
                                    </tr>
                            
                          
                                <div class="modal custom-modal fade" id="delete_department_<?=$row->id?>" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-header">
									<h3>Xóa phòng ban này?</h3>
									<p>Bạn có chắc chắn muốn xóa?</p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-6">
											<a href="departments.php?delid=<?php echo htmlentities($row->id);?>" class="btn btn-primary continue-btn">Xóa</a>
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
                                        $cnt+=1; 
                                      
                                    }
                                }?>
                                 </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
            <div id="edit_department" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa phòng ban</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" id="form-edit">
                                                    <input type="hidden" name="id" id="edit_id">
                                                    <div class="form-group">
                                                        <label>Tên phòng ban <span class="text-danger">*</span></label>
                                                        <input class="form-control " id="edit_name"  name="name" type="text">
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary submit-btn" name="update_department">Lưu</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            <!-- Add Department Modal -->
			<div id="add_department" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Thêm phòng ban</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" id="form-add">
									<div class="form-group">
										<label>Tên phòng ban <span class="text-danger">*</span></label>
										<input name="name"  class="form-control" type="text">
									</div>
									<div class="submit-section">
										<button name="add_department"  class="btn btn-primary submit-btn">Lưu</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
            <!-- /Add Department Modal -->
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
    
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#form-add").validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                name: {
                    required: true,
                },

            },
            messages: { 
				name: "*Vui lòng nhập tên phòng ban!",
            } 
        });
        $("#form-edit").validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                name: {
                    required: true,
                },

            },
            messages: { 
				name: "*Vui lòng nhập tên phòng ban!",
            } 
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
            $('.table').on('click','.editbtn',function (){
                $('#edit_department').modal('show');
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#edit_id').val(id);
                $('#edit_name').val(name);
            });
        });
    </script>
</body>
</html>
