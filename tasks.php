<?php
session_start();
error_reporting(0);
include_once ('includes/config.php');
include_once ('class/task.php');

$taskObj = new Task($dbh);

if (strlen($_SESSION['userlogin']) == 0) {
    header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
    header('location: login.php');
}

if(isset($_POST['download_file'])) {
    $id = $_POST['file'];
    $result = $taskObj->downloadFile($id);
   
}

if (isset ($_POST['add_task'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $status = 0;
    $project_id = htmlspecialchars($_POST['project_id']);
    $employee_id = htmlspecialchars($_POST['employee_id']);
    // Xử lý tệp tin
    $file_name = $_FILES['file']['name']; // Tên tệp tin
    $file_tmp = $_FILES['file']['tmp_name']; // Đường dẫn tạm thời của tệp tin
    $file_size = $_FILES['file']['size']; // Kích thước tệp tin
    $file_type = $_FILES['file']['type']; // Loại tệp tin
    $file_error = $_FILES['file']['error']; // Lỗi khi tải lên (nếu có)

    if ($file_error === UPLOAD_ERR_OK) {
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = md5($file_name . time()) . '.' . $extension;
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "upload/files/" . $new_file_name)) {
            $file = $new_file_name;
            $result = $taskObj->addTask($title, $description, $start_date, $end_date, $status, $project_id, $employee_id, $file);
            if ($result) {
                header("Location: tasks.php?success=1");
                exit();
            } else {
                echo "<script>alert('Something Went wrong');</script>";
            }
        } else {
            echo "<script>alert('Error uploading file');</script>";
        }
    } else {
        $file = "";
        $result = $taskObj->addTask($title, $description, $start_date, $end_date, $status, $project_id, $employee_id, $file);
        if($result) {
            header("Location: tasks.php?success=1");
        } else {
            echo 'Loi gi do';
        }
    }
}

if (isset ($_POST['update_task'])) {
    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $status = htmlspecialchars($_POST['status']);
    $project_id = htmlspecialchars($_POST['project_id']);
    $employee_id = htmlspecialchars($_POST['employee_id']);
    // Xử lý tệp tin
    $file_name = $_FILES['file']['name']; // Tên tệp tin
    $file_tmp = $_FILES['file']['tmp_name']; // Đường dẫn tạm thời của tệp tin
    $file_size = $_FILES['file']['size']; // Kích thước tệp tin
    $file_type = $_FILES['file']['type']; // Loại tệp tin
    $file_error = $_FILES['file']['error']; // Lỗi khi tải lên (nếu có)

    if ($file_error === UPLOAD_ERR_OK) {
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = md5($file_name . time()) . '.' . $extension;
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "upload/files/" . $new_file_name)) {
            $file = $new_file_name;
            $result = $taskObj->updateTask($id, $title, $description, $start_date, $end_date, $status, $project_id, $employee_id, $file);
            if ($result) {
                header("Location: tasks.php?success=1");
                exit();
            } else {
                echo "<script>alert('Something Went wrong');</script>";
            }
        } else {
            echo "<script>alert('Error uploading file');</script>";
        }
    } else {
        $file = "";
        $result = $taskObj->updateTask($id, $title, $description, $start_date, $end_date, $status, $project_id, $employee_id, $file);
        header("Location: tasks.php?success=2");
    }
}

// Kiểm tra xem có tham số delid được truyền vào không
if (isset ($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $result = $taskObj->deleteTask($rid);
    if ($result) {
        header("Location: tasks.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete task');</script>";
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
        <title>Nhiệm vụ</title>
        
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        
        <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="assets/css/line-awesome.min.css">
        
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="assets/css//select1.min.css">
        
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
                                <h3 class="page-title">Tasks</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Tasks</li>
                                </ul>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_task"><i class="fa fa-plus"></i> Add Task</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display: none;">
                        <strong>Success!</strong> Thêm nhiệm vụ thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert" id="update-alert" style="display: none;">
                        <strong>Success!</strong> Cập nhật nhiệm vụ thành công!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" style="display: none;">
                        <strong>Success!</strong> Xóa nhiệm vụ thành công!
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
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Start date</th>
                                        <th>End date</th>
                                        <th>Project</th>
                                        <th>Employee</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $results = $taskObj->viewAllTasks();
                                    $cnt = 1;

                                    foreach ($results as $key => $row) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $cnt ?></td>
                                                    <td><?php echo htmlentities($row["title"]); ?></td>
                                                    <td><?php echo htmlentities($row["description"]); ?></td>
                                                    <td><?php echo date('d/m/Y', htmlentities(strtotime($row["start_date"]))); ?></td>
                                                    <td><?php echo date('d/m/Y', htmlentities(strtotime($row["end_date"]))); ?></td>
                                                    <td><?php echo htmlentities($row["project_name"]); ?></td>
                                                    <td><?php echo htmlentities($row["firstname"]." ".$row["lastname"]); ?></td>
                                                    <td>
                                                        <?php if($row['file']): ?>
                                                            <form  method="post">
                                                            <input type="hidden" name="file" value="<?=$row["id"]?>">
                                                            <button class="btn btn-sm btn-primary" type="submit" name="download_file">
                                                                <i class="fa fa-download"></i>
                                                                Download
                                                            </button>	
                                                        </form>
                                                        <?php else: ?>
                                                            <p class="text-second"> Không có dữ liệu</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                    <?php if (strtotime($row["end_date"]) > strtotime(date("Y/m/d")) && $row["status"] == 0): ?>
                                                        <a class="btn btn-white btn-sm btn-rounded" href="#"  aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-warning"></i> Đang thực hiện
                                                        </a>
                                                    <?php elseif ($row["status"] == 1): ?>
                                                        <a class="btn btn-white btn-sm btn-rounded" href="#"  aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-success"></i> Đã hoàn thành
                                                        </a>
                                                    <?php elseif ($row["status"] == 2): ?>
                                                        <a class="btn btn-white btn-sm btn-rounded" href="#"  aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-info"></i> Đã review
                                                        </a>
                                                    <?php elseif ((strtotime($row["end_date"]) <= strtotime(date("Y/m/d")) && $row["status"] == 0) ): ?>
                                                        <a class="btn btn-white btn-sm btn-rounded" href="#"  aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-danger"></i> Quá hạn
                                                        </a>
                                                    <?php endif; ?>

                                                    </td>
                                                        
                                                    <td class="text-center">
                                                        <a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_task" 
                                                        data-id="<?= $row["id"] ?>"
                                                        data-title="<?= $row["title"] ?>"
                                                        data-startdate="<?= $row["start_date"] ?>"
                                                        data-enddate="<?= $row["end_date"] ?>"
                                                        data-project="<?= $row["project_id"] ?>"
                                                        data-employee="<?= $row["employee_id"] ?>"
                                                        data-description="<?= $row["description"] ?>"
                                                        data-status="<?= $row["status"] ?>"
                                                        > <i class="fa fa-pencil"></i> </a>
                                                        <a class="btn btn-danger text-white" data-toggle="modal" data-target="#delete_task_<?= $row["id"] ?>"><i class="fa fa-trash-o"></i> </a>
                                                
                                                    </td>
                                                </tr>
                                                <div class="modal custom-modal fade" id="delete_task_<?php echo $row["id"]; ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <h3>Delete Task</h3>
                                                                    <p>Are you sure want to delete?</p>
                                                                </div>
                                                                <div class="modal-btn delete-action">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <a href="tasks.php?delid=<?php echo $row["id"]; ?>" class="btn btn-primary continue-btn">Delete</a>
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
        <!-- /Main Wrapper -->
        <?php include_once 'includes/modals/tasks/edit_task.php'; ?>    
        <?php include_once 'includes/modals/tasks/add_task.php'; ?>           

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
      
        $('.select').select2({
					dropdownSearch: true
				});
        $('.datatable').on('click','.editbtn',function (){
                $('#edit_task').modal('show');
                var id = $(this).data('id');
                var title = $(this).data('title');
                var startDate = $(this).data('startdate');
                var endDate = $(this).data('enddate');
                var status = $(this).data('status');
                var project = $(this).data('project');
                var employee = $(this).data('employee');
                var description = $(this).data('description');
                var status = $(this).data('status');
                $('.edit_id').val(id);
                $('#edit_task .edit_title').val(title);
                $('#edit_description').val(description);
                $('#edit_task .edit_start_date').val(startDate);
                $('#edit_task .edit_end_date').val(endDate);
                $('#edit_task .edit_project').val(project).trigger('change');
                $('#edit_task .edit_employee').val(employee).trigger('change');
                $('#edit_task .edit_status').val(status).trigger('change');
                $(".edit_employee option").each(function()
                        {
                            if($(this).val() == employee){
                                $(this).attr('selected','selected');
                            }
                        });
                $(".edit_status option").each(function()
                        {
                            if($(this).val() == status){
                                $(this).attr('selected','selected');
                            }
                        });
                $(".edit_project option").each(function()
                {
                    if($(this).val() == project){
                        $(this).attr('selected','selected');
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
        function setupValidation(formId) {
        $(formId).validate({
            rules: {
                title: {
                    required: true
                },
                start_date: {
                    required: true
                },
                end_date: {
                    required: true
                },
                project_id: {
                    required: true
                },
                employee_id: {
                    required: true
                },
                description: {
                    required: true
                }
            },
            messages: {
                title: "*Vui lòng nhập tiêu đề",
                start_date: "*Vui lòng nhập ngày bắt đầu",
                end_date: "*Vui lòng nhập ngày kết thúc",
                project_id: "*Vui lòng chọn dự án",
                employee_id: "*Vui lòng chọn nhân viên thực hiện",
                description: "*Vui lòng nhập mô tả"
            },
            errorPlacement: function(error, element) {
                if (element.is("select")) {
                    error.insertAfter(element.next("span.select2")); // For Select2
                } else {
                    error.insertAfter(element);
                }
            },

        });
        $(formId + ' select').on('change', function() {
            $(this).valid();
        });
    }

		setupValidation("#form-add");
		setupValidation("#form-edit");
})
</script>
    </body>
</html>