<?php
session_start();
error_reporting(0);
include_once ('includes/config.php');
include_once ('class/designation.php');
$designationObj = new Designation($dbh);
// Kiểm tra đăng nhập
if (strlen($_SESSION['userlogin']) == 0) {
	header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
	header('location: login.php');
}

if (isset ($_POST['add_designation'])) {
    $name = htmlspecialchars($_POST['designation']);
    $department = htmlspecialchars($_POST['department']);
    $result = $designationObj->addDesignation($name, $department);
    if ($result) {
        header("Location: designations.php?success=1");

    } else {
        echo "<script>alert('Something Went wrong');</scrip>";
    }
}

if (isset ($_POST['update_designation'])) {
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['designation']);
    $department = htmlspecialchars($_POST['department']);
    $result = $designationObj->updateDesignation($id, $name, $department);
    if ($result) {
        header("Location: designations.php?success=2");
    } else {
        echo "<script>alert('Something Went wrong');</scrip>";
    }
}

// Kiểm tra xem có tham số delid được truyền vào không
if (isset ($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $result = $designationObj->deleteDesignation($rid);
    if ($result) {
        header("Location: designations.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete designation');</script>";
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
        <title>Designations</title>
        
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        
        <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="assets/css/line-awesome.min.css">
        
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        
        <!-- Datatable CSS -->
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
        
        <!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        
        <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    </head>
    <body>
        <!-- Main Wrapper -->
        <div class="main-wrapper">
        
            <!-- Header -->
            <?php include_once ("includes/header.php"); ?>
            <!-- /Header -->
            
            <!-- Sidebar -->
            <?php include_once ("includes/sidebar.php"); ?>
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
                                <h3 class="page-title">Danh sách chức vụ</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Chức vụ</li>
                                </ul>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i>Thêm chức vụ</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm chúc vụ thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật chúc vụ thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa chúc vụ thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                         <table class="table table-striped custom-table datatable mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th>Tên chức vụ</th>
                                        <th>Phòng ban</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM designations";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $sql1 = "SELECT * FROM departments";
                                    $query1 = $dbh->prepare($sql1);
                                    $query1->execute();
                                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    $departmentMap = [];
                                    foreach ($results1 as $row1) {
                                        $departmentMap[$row1->id] = $row1->name;
                                    }
                                    foreach ($results as $key => $row) {
                                        ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo htmlentities($row->name); ?></td>
                                                <td><?php echo htmlentities($departmentMap[$row->department_id]); ?></td>
                                                <td class="text-center">
                                        
                                                    <a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_designation" data-id="<?= $row->id ?>" data-designation= "<?= $row->name ?>" data-department= "<?= $row->department_id ?>"> <i class="fa fa-pencil "></i> </a>
                                                    <a class="btn btn-danger text-white" data-toggle="modal" data-target="#delete_designation_<?= $row->id ?>"><i class="fa fa-trash-o "></i> </a>
                                                
                                                </td>
                                            </tr>
                                            <div class="modal custom-modal fade" id="delete_designation_<?= $row->id ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <h3>Xóa chức vụ</h3>
                                                                    <p>Bạn có muốn xóa chức vụ này?</p>
                                                                </div>
                                                                <div class="modal-btn delete-action">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <a href="designations.php?delid=<?php echo $row->id; ?>" class="btn btn-primary continue-btn">Xóa</a>
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
                                    $cnt += 1;
                                    }
                                    ?>

                                </tbody>
                            </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Content -->
            </div>
            <!-- /Page Wrapper -->

        </div>
        <div id="edit_designation" class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Sửa chức vụ</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" id="form-edit">
                                                                    <input type="hidden" name="id"  id="edit_id" value="">
                                                                    <div class="form-group">
                                                                        <label>Tên chức vụ <span class="text-danger">*</span></label>
                                                                        <input class="form-control edit_designation" name="designation" value="" type="text">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Phòng ban <span class="text-danger">*</span></label>
                                                                        <select class="select edit_department" name="department">
                                                                        <option value="">Chọn phòng ban</option>
                                                                        <?php
                                                                        $sql1 = "SELECT * FROM departments";
                                                                        $query1 = $dbh->prepare($sql1);
                                                                        $query1->execute();
                                                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                                        foreach ($results1 as $row) {
                                                                            ?>
                                                                                <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="submit-section">
                                                                        <button class="btn btn-primary submit-btn " name="update_designation">Lưu</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        <!-- /Main Wrapper -->
        <div id="add_designation" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm chức vụ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="form-add">
                                    <div class="form-group">
                                        <label>Tên chức vụ <span class="text-danger">*</span></label>
                                        <input name="designation" required class="form-control" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Phòng ban <span class="text-danger">*</span></label>
                                        <select  name="department" class="form-control select">
                                            <option value="">Chọn phòng ban</option>
                                            <?php
                                            $sql2 = "SELECT * from departments";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($result2 as $row) {
                                                ?>  
                                                <option value="<?php echo htmlentities($row->id); ?>">
                                                <?php echo htmlentities($row->name); ?></option>
                                            <?php } ?> 
                                        </select>
                                    </div>
                                    <div class="submit-section">
                                        <button name="add_designation" type="submit" class="btn btn-primary submit-btn">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
        
        <!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        
        <!-- Slimscroll JS -->
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        
        <!-- Select2 JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>        
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function(){
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
                    designation: {
                        required: true,
                    },
                    department: {
                        required: true,
                    },
                },
                messages: {
                    designation: "*Vui lòng nhập tên chức vụ!",
                    department: "*Vui lòng chọn phòng ban!",
                }
            });
        }
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
      $('.editbtn').on('click',function (){
            $('#edit_designation').modal('show');
            var id = $(this).data('id');
            var designation = $(this).data('designation');
            var department = $(this).data('department');
            $('#edit_id').val(id);
            $('.edit_designation').val(designation);
            $('.edit_department').val(department).trigger('change');
            
            $('.edit_department option').each(function()
            {
                if($(this).val() == id){
                    $(this).attr('selected','selected');
                }
        });
        })
})
</script>
    </body>
</html>