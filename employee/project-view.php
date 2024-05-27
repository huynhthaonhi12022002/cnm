<?php
session_start();
error_reporting(0);
include_once('../includes/config.php');
include_once('../class/project.php');
$projectObj = new Project($dbh);

if (strlen($_SESSION['userlogin']) == 0) {
    header('location:../login.php');
}



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pro_detail = $projectObj->viewProjectById($id);
}

$projectData = $projectObj->viewProjectWithTasksById($_GET['id']);
if ($projectData) {
    $project = $projectData['project'];
    $allTasks = $projectData['allTasks'];
    $pendingTasks = $projectData['pendingTasks'];
    $completedTasks = $projectData['completedTasks'];
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
    <title>Dự án</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="../assets/css/select1.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
			<script src="../assets/js/html5shiv.min.js"></script>
			<script src="../assets/js/respond.min.js"></script>
		<![endif]-->
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php include_once("../includes/header_employee.php"); ?>
        <!-- /Header -->

        <!-- Sidebar -->
        <?php include_once("../includes/sidebar_employee.php"); ?>
        <!-- /Sidebar -->
        <?php if ($pro_detail) : ?>
            <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title"><?= $pro_detail["name"] ?></h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Project</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row">
                        <div class="col-lg-8 col-xl-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="project-title">
                                        <h5 class="card-title"><?= $pro_detail["name"] ?></h5>
                                        <small class="block text-ellipsis m-b-15"><span class="text-xs"></span> <span class="text-muted"></span><span class="text-xs"></span> <span class="text-muted"></span></small>
                                        <p><?= $pro_detail["description"] ?></p>
                                    </div>

                                </div>
                            </div>
                            <!-- <div class="card">
                            <div class="card-body">
                                <h5 class="card-title m-b-20">Uploaded  files</h5>
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                        <div class="uploaded-box">
                                            <div class="uploaded-img">
                                                <img src="../assets/img/placeholder.jpg" class="img-fluid" alt="">
                                            </div>
                                            <div class="uploaded-img-name">
                                                demo.png
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                        <div class="uploaded-box">
                                            <div class="uploaded-img">
                                                <img src="../assets/img/placeholder.jpg" class="img-fluid" alt="">
                                            </div>
                                            <div class="uploaded-img-name">
                                                demo.png
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                        <div class="uploaded-box">
                                            <div class="uploaded-img">
                                                <img src="../assets/img/placeholder.jpg" class="img-fluid" alt="">
                                            </div>
                                            <div class="uploaded-img-name">
                                                demo.png
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                        <div class="uploaded-box">
                                            <div class="uploaded-img">
                                                <img src="../assets/img/placeholder.jpg" class="img-fluid" alt="">
                                            </div>
                                            <div class="uploaded-img-name">
                                                demo.png
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title m-b-20">Tệp tin đã tải lên</h5>
                                    <ul class="files-list">

                                        <?php
                                        $files = json_decode($pro_detail['files'], true);
                                        foreach ($files as $file) :

                                        ?>
                                            <li>
                                                <div class="files-cont">
                                                    <div class="file-type">
                                                        <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                    </div>
                                                    <div class="files-info">
                                                        <span class="file-name text-ellipsis"><a href="http://localhost/cnm/upload/files/<?=$file?>" download="<?=$file?>"><?=$file?></a></span>
                                                        <span class="file-author"><a href="#"></a></span> <span class="file-date"></span>
                                                        <div class="file-size"></div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                         <div class="project-task">
    <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
        <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">Tất cả nhiệm vụ</a></li>
        <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Nhiệm vụ đang làm</a></li>
        <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Nhiệm vụ đã hoàn thành</a></li>
    </ul>
    <div class="tab-content">
        <!-- All Tasks Tab -->
        <div class="tab-pane show active" id="all_tasks">
            <div class="task-wrapper">
                <div class="task-list-container">
                    <div class="task-list-body">
                        <ul id="task-list">
                            <?php foreach ($allTasks as $task): ?>
                                <li class="task <?php if ($task['status'] == 1) echo 'completed'; ?>">
                                <div class="task-container">
                                    <span class="task-action-btn task-check">
                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                            <i class="material-icons">check</i>
                                        </span>
                                    </span>
                                    <span class="task-label"  contenteditable="true"><?= htmlspecialchars($task['title']) ?></span>
                                    
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Tasks Tab -->
        <div class="tab-pane" id="pending_tasks">
            <div class="task-wrapper">
                <div class="task-list-container">
                    <div class="task-list-body">
                        <ul id="task-list">
                            <?php foreach ($pendingTasks as $task): ?>
                            <li class="task">
                                <div class="task-container">
                                    <span class="task-action-btn task-check">
                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                            <i class="material-icons">check</i>
                                        </span>
                                    </span>
                                    <span class="task-label" contenteditable="true"><?= htmlspecialchars($task['title']) ?></span>
                                    
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Completed Tasks Tab -->
        <div class="tab-pane" id="completed_tasks">
            <div class="task-wrapper">
                <div class="task-list-container">
                    <div class="task-list-body">
                        <ul id="task-list">
                            <?php foreach ($completedTasks as $task): ?>
                            <li class="completed task">
                                <div class="task-container">
                                    <span class="task-action-btn task-check">
                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                            <i class="material-icons">check</i>
                                        </span>
                                    </span>
                                    <span class="task-label"><?= htmlspecialchars($task['title']) ?></span>
                                    
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title m-b-15">Chi tiết dự án</h6>
                                    <table class="table table-striped table-border">
                                        <tbody>
                                            <tr>
                                                <td>Chi phí:</td>
                                                <td class="text-right">
                                                    <?= number_format($pro_detail['rate'], 0, ',', '.') . ' đ' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ngày bắt đầu:</td>
                                                <td class="text-right">
                                                    <?= date('d/m/Y', strtotime($pro_detail['start_date'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ngày kết thúc:</td>
                                                <td class="text-right">
                                                    <?= date('d/m/Y', strtotime($pro_detail['end_date'])) ?></td>

                                            </tr>
                                            <tr>
                                                <td>Ưu tiên:</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <?php if ($pro_detail['priority'] == 'High') : ?>
                                                            <a href="#" class="badge badge-danger">High </a>
                                                        <?php elseif ($pro_detail['priority'] == 'Medium') : ?>
                                                            <a href="#" class="badge badge-info">Medium </a>
                                                        <?php else : ?>
                                                            <a href="#" class="badge badge-warning">Low </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Leader:</td>
                                                <td class="text-right"><a href="#"><?= $pro_detail["firstname"] . " " . $pro_detail["lastname"] ?></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Trạng thái:</td>
                                                <?php if ($pro_detail['status'] == 1) : ?>
                                                    <td class="text-right text-success">Đang làm</td>
                                                <?php else : ?>
                                                    <td class="text-right text-danger">Ngưng hoạt động</td>
                                                <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p> -->
                                    <div class="progress progress-xs mb-0">
                                        <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: 40%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="card project-user">
                                <div class="card-body">
                                    <h6 class="card-title m-b-20">
                                        Thành viên trong nhóm

                                    </h6>
                                    <ul class="list-box">

                                        <?php
                                        $team = json_decode($pro_detail['team'], true);
                                        foreach ($team as $id) :
                                            $employee_team = $projectObj->getEmployeeById($id);
                                            if ($employee_team !== null) {
                                        ?>

                                                <li class="mt-2">
                                                    <a href="#">
                                                        <div class="list-item">
                                                            <div class="list-left">
                                                                <span class="avatar"><img alt="" src="upload/employees/<?= $employee_team['avatar'] ?>"></span>
                                                            </div>
                                                            <div class="list-body">
                                                                <span class="message-author"><?= $employee_team['firstname'] . " " . $employee_team['lastname'] ?></span>
                                                                <div class="clearfix"></div>
                                                                <span class="message-content"></span>

                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                        <?php
                                            } else {
                                            }
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Content -->

                <!-- Assign Leader Modal -->
                <div id="assign_leader" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign Leader to this project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group m-b-30">
                                    <input placeholder="Search to add a leader" class="form-control search-input" type="text">
                                    <span class="input-group-append">
                                        <button class="btn btn-primary">Search</button>
                                    </span>
                                </div>
                                <div>
                                    <ul class="chat-user-list">
                                        <li>
                                            <a href="#">
                                                <div class="media">
                                                    <span class="avatar"><img alt="" src="../assets/img/profiles/avatar-09.jpg"></span>
                                                    <div class="media-body align-self-center text-nowrap">
                                                        <div class="user-name">Richard Miles</div>
                                                        <span class="designation">Web Developer</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="media">
                                                    <span class="avatar"><img alt="" src="../assets/img/profiles/avatar-10.jpg"></span>
                                                    <div class="media-body align-self-center text-nowrap">
                                                        <div class="user-name">John Smith</div>
                                                        <span class="designation">Android Developer</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="media">
                                                    <span class="avatar">
                                                        <img alt="" src="../assets/img/profiles/avatar-16.jpg">
                                                    </span>
                                                    <div class="media-body align-self-center text-nowrap">
                                                        <div class="user-name">Jeffery Lalor</div>
                                                        <span class="designation">Team Leader</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Assign Leader Modal -->

                <!-- Assign User Modal -->
                <div id="assign_user" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign the user to this project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group m-b-30">
                                    <input placeholder="Search a user to assign" class="form-control search-input" type="text">
                                    <span class="input-group-append">
                                        <button class="btn btn-primary">Search</button>
                                    </span>
                                </div>
                                <div>
                                    <ul class="chat-user-list">
                                        <li>
                                            <a href="#">
                                                <div class="media">
                                                    <span class="avatar"><img alt="" src="../assets/img/profiles/avatar-09.jpg"></span>
                                                    <div class="media-body align-self-center text-nowrap">
                                                        <div class="user-name">Richard Miles</div>
                                                        <span class="designation">Web Developer</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="media">
                                                    <span class="avatar"><img alt="" src="../assets/img/profiles/avatar-10.jpg"></span>
                                                    <div class="media-body align-self-center text-nowrap">
                                                        <div class="user-name">John Smith</div>
                                                        <span class="designation">Android Developer</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="media">
                                                    <span class="avatar">
                                                        <img alt="" src="../assets/img/profiles/avatar-16.jpg">
                                                    </span>
                                                    <div class="media-body align-self-center text-nowrap">
                                                        <div class="user-name">Jeffery Lalor</div>
                                                        <span class="designation">Team Leader</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Assign User Modal -->

                <!-- Edit Project Modal -->
                <div id="edit_project" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Project Name</label>
                                                <input class="form-control" value="Project Management" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Client</label>
                                                <select class="select">
                                                    <option>Global Technologies</option>
                                                    <option>Delta Infotech</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Rate</label>
                                                <input placeholder="$50" class="form-control" value="$5000" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <select class="select">
                                                    <option>Hourly</option>
                                                    <option selected="">Fixed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Priority</label>
                                                <select class="select">
                                                    <option selected="">High</option>
                                                    <option>Medium</option>
                                                    <option>Low</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Add Project Leader</label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Team Leader</label>
                                                <div class="project-members">
                                                    <a class="avatar" href="#" data-toggle="tooltip" title="Jeffery Lalor">
                                                        <img alt="" src="../assets/img/profiles/avatar-16.jpg">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Add Team</label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Team Members</label>
                                                <div class="project-members">
                                                    <a class="avatar" href="#" data-toggle="tooltip" title="John Doe">
                                                        <img alt="" src="../assets/img/profiles/avatar-02.jpg">
                                                    </a>
                                                    <a class="avatar" href="#" data-toggle="tooltip" title="Richard Miles">
                                                        <img alt="" src="../assets/img/profiles/avatar-09.jpg">
                                                    </a>
                                                    <a class="avatar" href="#" data-toggle="tooltip" title="John Smith">
                                                        <img alt="" src="../assets/img/profiles/avatar-10.jpg">
                                                    </a>
                                                    <a class="avatar" href="#" data-toggle="tooltip" title="Mike Litorus">
                                                        <img alt="" src="../assets/img/profiles/avatar-05.jpg">
                                                    </a>
                                                    <span class="all-team">+2</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea rows="4" class="form-control" placeholder="Enter your message here"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Files</label>
                                        <input class="form-control" type="file">
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Edit Project Modal -->

            </div>
            <!-- /Page Wrapper -->
        <?php endif; ?>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="../assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="../assets/js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="../assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Task JS -->
    <script src="../assets/js/task.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            $('.select').select2({
                dropdownSearch: true
            });
        })
    </script>
</body>

</html>