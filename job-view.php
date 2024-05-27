<?php
session_start();
error_reporting(0);
include_once ('includes/config.php');
include_once ('class/job.php');
include_once ('class/applicant.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location: login.php');
}
if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 0) {
    header('location: login.php');
}

$jobObj = new Job($dbh);
$applicantObj = new Applicant($dbh);
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $results = $jobObj->getJobById($id);
}

if (isset($_POST['add_applicant'])) {
    $job_id = htmlspecialchars($_POST['job_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $status = htmlspecialchars($_POST['status']);
    $user_id = htmlspecialchars($_POST['user_id']);

    $cv = $_FILES["cv"]["name"];

    // Xử lý tên file avatar
    $extension = pathinfo($cv, PATHINFO_EXTENSION);
    $new_cv_name = md5($cv . time()) . '.' . $extension;
    move_uploaded_file($_FILES["cv"]["tmp_name"], "upload/cv/" . $new_cv_name);
    $result = $applicantObj->addApplicant($job_id, $name, $email, $new_cv_name, $message, $status, $user_id);
    if ($result) {
        header('location: job-view.php?id=' . $job_id);
        return $msg ='<div class="alert alert-success alert-dismissible show" role="alert">
                    <strong>Success! </strong> <span class="text-black">Nộp đơn xin việc thành công!</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    } else {
        echo "<script>alert('Something Went wrong');</script>";
    }
    
}

function diffForHumans($timestamp) {
    $now = time();
    if ($timestamp > $now) {
        return "in the future";
    }

    $diff = $now - $timestamp;

    if ($diff < 60) {
        return "just now";
    } elseif ($diff < 3600) {
        $minutes = round($diff / 60);
        return "$minutes minute" . ($minutes > 1 ? "s" : "") . " ago";
    } elseif ($diff < 86400) {
        $hours = round($diff / 3600);
        return "$hours hour" . ($hours > 1 ? "s" : "") . " ago";
    } elseif ($diff < 604800) {
        $days = round($diff / 86400);
        return "$days day" . ($days > 1 ? "s" : "") . " ago";
    } elseif ($diff < 2419200) {
        $weeks = round($diff / 604800);
        return "$weeks week" . ($weeks > 1 ? "s" : "") . " ago";
    } elseif ($diff < 29030400) {
        $months = round($diff / 2419200);
        return "$months month" . ($months > 1 ? "s" : "") . " ago";
    } else {
        $years = round($diff / 29030400);
        return "$years year" . ($years > 1 ? "s" : "") . " ago";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
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

    @yield('styles')

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
        <div class="header">

            <!-- Logo -->
            <div class="header-left">
                <a href="" class="logo">
                    <img src="assets/img/logo.png" width="40" height="40" alt="logo">
                </a>
            </div>
            <!-- /Logo -->

            <!-- Header Title -->
            <div class="page-title-box float-left">
                <h3>Công ty ABC Technologies</h3>
            </div>
            <!-- /Header Title -->

            <!-- Header Menu -->
            <ul class="nav user-menu">

                <!-- Search -->
                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="">
                            <input class="form-control" type="text" placeholder="Search here">
                            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </li>
                <!-- /Search -->
                <li class="nav-item">
                    <a href="job-list.php" class="nav-link">Jobs</a>
                </li>

                <?php 
            $sql = "SELECT * FROM users WHERE id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $_SESSION["user_id"]);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
		?>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <?php if($result["avatar"]): ?>
                        <span class="user-img">
                            <?php if (substr($result["avatar"], 0, 5) === 'https'): ?>
                            <img src="<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar">
                            <?php else: ?>
                            <img src="upload/users/<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar">
                            <?php endif; ?>

                            <span class="status online"></span></span>
                        <?php endif; ?>
                        <span><?php echo htmlentities(ucfirst($_SESSION['user_name']));?></span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.php">My Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="logout.php" class="nav-link">Log out</a>
                </div>


            </div>
            <!-- /Mobile Menu -->

        </div>
        <!-- /Header -->

        <!-- Page Wrapper -->
        <div class="page-wrapper job-wrapper">

            <!-- Page Content -->
            <div class="content container">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">

                            <?php if(isset($msg)):
                                    echo $msg;
                                    
                                ?>

                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-8">
                        <div class="job-info job-widget">
                            <h3 class="job-title"><?=$results["title"]?></h3>
                            <span class="job-dept"><?=$results["department_id"]?></span>
                            <ul class="job-post-det">
                                <li><i class="fa fa-calendar"></i> Ngày đăng: <span
                                        class="text-blue"><?=diffForHumans(strtotime($results["start_date"]))?></span>
                                </li>
                                <li><i class="fa fa-calendar"></i> Ngày hết hạn: <span
                                        class="text-blue"><?=diffForHumans(strtotime($results["expire_date"]))?></span>
                                </li>
                                <?php
                                $count_applicants = $jobObj->getCandidates($results["id"]);
                                ?>
                                <li><i class="fa fa-user-o"></i> Ứng viên đã nộp đơn: <span
                                        class="text-blue"><?=$jobObj->getCandidates($results["id"]);?></span></li>
                            </ul>
                        </div>
                        <div class="job-content job-widget">
                            <?=$results["description"]?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="job-det-info job-widget">
                            <a class="btn job-btn" href="#" data-toggle="modal" data-target="#apply_job">Apply For This
                                Job</a>
                            <div class="info-list">
                                <span><i class="fa fa-bar-chart"></i></span>
                                <h5>Loại công việc</h5>
                                <p> <?=$results["type"]?></p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-money"></i></span>
                                <h5>Mức lương</h5>
                                <p><?=number_format($results['salary_from'], 0, ',', '.') . ' đ'?> - <?=number_format($results['salary_to'], 0, ',', '.') . ' đ'?></p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-suitcase"></i></span>
                                <h5>Kinh nghiệm</h5>
                                <p><?=$results["experience"]?> Năm</p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-ticket"></i></span>
                                <h5>Số lượng cần tuyển</h5>
                                <p><?=$results["vacancy"]?></p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-map-signs"></i></span>
                                <h5>Địa chỉ</h5>
                                <p> <?=$results["location"]?></p>
                            </div>

                            <div class="info-list text-center">
                                <a class="app-ends" href="#">Application ends in
                                    <?=diffForHumans(strtotime($results["expire_date"]))?></a>
                            </div>
                        </div>
                    </div>

                    <!-- Apply Job Modal -->
                    <div class="modal custom-modal fade" id="apply_job" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Đơn xin ứng tuyển</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data" id="form-add">
                                        <input type="hidden" name="job_id" value="<?=$results["id"]?>">
                                        <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">
                                        <div class="form-group">
                                            <label>Họ và tên</label>
                                            <input class="form-control" name="name" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" name="email" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Lời nhắn</label>
                                            <textarea class="form-control" name="message"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload your CV</label>
                                            <input type="file" name="cv" class="form-control" accept=".pdf"
                                                id="cv_upload">
                                        </div>
                                        <input type="hidden" name="status" value="New">
                                        <div class="submit-section">
                                            <button class="btn btn-primary submit-btn" name="add_applicant">Gửi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript">
    </script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Datatable JS -->

    <!-- Select2 JS -->

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

    <script>
    $(document).ready(function() {
        setupValidation("#form-add");

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
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true // Kiểm tra định dạng email
                    },

                    cv: {
                        required: true
                    },

                },
                messages: {
                    name: "*Vui lòng nhập họ và tên!",
                    email: {
                        required: "*Vui lòng nhập địa chỉ email!",
                        email: "*Vui lòng nhập đúng định dạng email!"
                    },

                    cv: "*Vui lòng nộp file cv định dạng pdf!",

                },
            });
        }
    })
    </script>
</body>

</html>