<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('class/job.php');

if (strlen($_SESSION['userlogin']) == 0) {
    header('location: login.php');
}
if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 0) {
    header('location: login.php');
}

$jobObj = new Job($dbh);

// Thêm công việc mới
if (isset($_POST['add_job'])) {
    $title = htmlspecialchars($_POST['title']);
    $department_id = htmlspecialchars($_POST['department_id']);
    $location = htmlspecialchars($_POST['location']);
    $vacancies = htmlspecialchars($_POST['vacancies']);
    $experience = htmlspecialchars($_POST['experience']);
    $age = htmlspecialchars($_POST['age']);
    $salary_from = htmlspecialchars($_POST['salary_from']);
    $salary_to = htmlspecialchars($_POST['salary_to']);
    $type = htmlspecialchars($_POST['type']);
    $status = htmlspecialchars($_POST['status']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $expire_date = htmlspecialchars($_POST['expire_date']);
    $description = htmlspecialchars($_POST['description']);

    $result = $jobObj->addJob($title, $department_id, $location, $vacancies, $experience, $age, $salary_from, $salary_to, $type, $status, $start_date, $expire_date, $description);
    if ($result) {
        header("Location: jobs.php?success=1");
        exit();
    } else {
        echo "<script>alert('Something Went wrong');</script>";
    }
}

// Sửa thông tin công việc
if (isset($_POST['update_job'])) {
    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $department_id = htmlspecialchars($_POST['department_id']);
    $location = htmlspecialchars($_POST['location']);
    $vacancies = htmlspecialchars($_POST['vacancies']);
    $experience = htmlspecialchars($_POST['experience']);
    $age = htmlspecialchars($_POST['age']);
    $salary_from = htmlspecialchars($_POST['salary_from']);
    $salary_to = htmlspecialchars($_POST['salary_to']);
    $type = htmlspecialchars($_POST['type']);
    $status = htmlspecialchars($_POST['status']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $expire_date = htmlspecialchars($_POST['expire_date']);
    $description = htmlspecialchars($_POST['description']);

    $result = $jobObj->updateJob($id, $title, $department_id, $location, $vacancies, $experience, $age, $salary_from, $salary_to, $type, $status, $start_date, $expire_date, $description);
    if ($result) {
        header("Location: jobs.php?success=2");
        exit();
    } else {
        echo "<script>alert('Something Went wrong');</script>";
    }
}

// Xóa công việc
if (isset($_GET['delid'])) {
    $id = intval($_GET['delid']);
    $result = $jobObj->deleteJob($id);
    if ($result) {
        header("Location: jobs.php?success=0");
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete job');</script>";
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
    <title>Công việc</title>

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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
        <?php include_once('includes/notification/notify.php'); ?>

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Danh sách công việc</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Công việc</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_job"><i class="fa fa-plus"></i> Thêm công việc</a>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên chức vụ</th>
                                        <th>Mô tả</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Loại công việc</th>
                                        <th>Trạng thái</th>
                                        <th>Ứng viên</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $results = $jobObj->viewAllJobs();
                                    $cnt = 1;
                                    if ($results) {
                                        foreach ($results as $row) {
                                    ?>
                                            <tr>
                                                <td><?= $cnt ?></td>
                                                <td><?php echo htmlentities(($row["title"])); ?></td>
                                                <td><?php echo htmlentities($row["description"]); ?></td>
                                                <td><?php echo date('d/m/Y', htmlentities(strtotime($row["start_date"]))); ?></td>
                                                <td><?php echo date('d/m/Y', htmlentities(strtotime($row["expire_date"]))); ?></td>
                                                <td><?php echo htmlentities(($row["type"])); ?></td>
                                                <td><?php echo htmlentities(($row["status"])); ?></td>
                                                <td><a href="job-applicant.php?id=<?= $row["id"] ?>" class="btn btn-success"><?= $jobObj->getCandidates($row["id"]); ?> Ứng viên</a></td>
                                                <td class="text-center">
                                                    <a class="btn btn-warning editbtn" href="#" data-toggle="modal" data-target="#edit_job" data-id="<?= $row["id"] ?>" data-title="<?= $row["title"] ?>" data-description="<?= $row["description"] ?>" data-start_date="<?= $row["start_date"] ?>" data-expire_date="<?= $row["expire_date"] ?>" data-type="<?= $row["type"] ?>" data-status="<?= $row["status"] ?>" data-department_id="<?= $row["department_id"] ?>" data-location="<?= $row["location"] ?>" data-vacancies="<?= $row["vacancies"] ?>" data-experience="<?= $row["experience"] ?>" data-age="<?= $row["age"] ?>" data-salary_from="<?= $row["salary_from"] ?>" data-salary_to="<?= $row["salary_to"] ?>"><i class="fa fa-pencil "></i> </a>
                                                    <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#delete_job_<?= $row["id"] ?>"><i class="fa fa-trash-o "></i> </a>
                                                </td>
                                            </tr>
                                            <div class="modal custom-modal fade" id="delete_job_<?= $row["id"] ?>" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-header">
                                                                <h3>Xóa công việc này?</h3>
                                                                <p>Bạn có chắc chắn muốn xóa?</p>
                                                            </div>
                                                            <div class="modal-btn delete-action">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <a href="jobs.php?delid=<?= $row["id"] ?>" class="btn btn-primary continue-btn">Xóa</a>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->

            <!-- Add Client Modal -->
            <?php include_once("includes/modals/jobs/add_job.php"); ?>
            <!-- /Add Client Modal -->

            <!-- Edit Client Modal -->
            <?php include_once("includes/modals/jobs/edit_job.php"); ?>
            <!-- /Delete Client Modal -->

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
                    errorPlacement: function(error, element) {
                        if (element.hasClass('select')) {
                            error.insertAfter(element.next('span.select2'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    rules: {
                        title: {
                            required: true
                        },
                        department_id: {
                            required: true
                        },
                        location: {
                            required: true,
                        },
                        vacancies: {
                            required: true
                        },
                        experience: {
                            required: true
                        },
                        age: {
                            required: true
                        },
                        salary_from: {
                            required: true
                        },
                        salary_to: {
                            required: true
                        },
                        type: {
                            required: true
                        },
                        status: {
                            required: true
                        },
                        start_date: {
                            required: true
                        },
                        expire_date: {
                            required: true
                        },
                        description: {
                            required: true
                        }
                    },
                    messages: {
                        title: "*Vui lòng nhập tiêu đề công việc!",
                        department_id: "*Vui lòng chọn bộ phận!",
                        location: "*Vui lòng nhập địa điểm!",
                        vacancies: "*Vui lòng nhập số lượng vị trí cần tuyển!",
                        experience: "*Vui lòng nhập yêu cầu kinh nghiệm!",
                        age: "*Vui lòng nhập yêu cầu tuổi!",
                        salary_from: "*Vui lòng nhập mức lương từ!",
                        salary_to: "*Vui lòng nhập mức lương đến!",
                        type: "*Vui lòng chọn loại công việc!",
                        status: "*Vui lòng chọn trạng thái công việc!",
                        start_date: "*Vui lòng nhập ngày bắt đầu!",
                        expire_date: "*Vui lòng nhập ngày hết hạn!",
                        description: "*Vui lòng nhập mô tả công việc!",
                    },
                });
            }
            $('.datatable').on('click', '.editbtn', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var department = $(this).data('department_id');
                var startDate = $(this).data('start_date');
                var expiryDate = $(this).data('expire_date');
                var experience = $(this).data('experience');
                var status = $(this).data('status');
                var type = $(this).data('type');
                var age = $(this).data('age');
                var salary_from = $(this).data('salary_from');
                var salary_to = $(this).data('salary_to');
                var vacancies = $(this).data('vacancies');
                var location = $(this).data('location');
                var description = $(this).data('description');
                $('.edit_id').val(id);
                $('#edit_job .edit_title').val(title);
                $('#edit_job .edit_department').val(department).trigger('change');
                $('#edit_job .edit_start_date').val(startDate);
                $('#edit_job .edit_expire_date').val(expiryDate);
                $('#edit_job .edit_experience').val(experience);
                $('#edit_job .edit_age').val(age);
                $('#edit_job .edit_salary_from').val(salary_from);
                $('#edit_job .edit_salary_to').val(salary_to);
                $('#edit_job .edit_vacancies').val(vacancies);
                $('#edit_job .edit_location').val(location);
                $('#edit_job .edit_description').val(description);
                $('#edit_job .edit_status').val(status).trigger('change');
                $('#edit_job .edit_type').val(type).trigger('change');
                $('.edit_type option').each(function() {
                    if ($(this).val() == id) {
                        $(this).attr('selected', 'selected');
                    }
                });
                $('.edit_status option').each(function() {
                    if ($(this).val() == id) {
                        $(this).attr('selected', 'selected');
                    }
                });
                $('.edit_department option').each(function() {
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
        });
    </script>
</body>

</html>