<?php
session_start();
error_reporting(0);
include_once ('includes/config.php');
include_once ('class/job.php');

if (strlen($_SESSION['userlogin']) == 0) {
    header('location: login.php');
}
if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 0) {
    header('location: login.php');
}

$jobObj = new Job($dbh);

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
    <title>Danh sách công việc</title>

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
                    <a class="dropdown-item" href="login.php">Logout</a>
                </div>
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

                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row">
                        <?php
                    $results = $jobObj->viewAllJobs();
                   
                    if($results):
                        foreach($results as $row):
                    ?>
                        <div class="col-md-6">
                            <a class="job-list" href="job-view.php?id=<?=$row["id"]?>">
                                <div class="job-list-det">
                                    <div class="job-list-desc">
                                        <h3 class="job-list-title"><?=$row["title"]?></h3>
                                        <h4 class="job-department"><?=$row["department_id"]?></h4>
                                    </div>
                                    <div class="job-type-info">
                                        <span class="job-types"><?=$row["type"]?></span>
                                    </div>
                                </div>
                                <div class="job-list-footer">
                                    <ul>
                                        <li><i class="fa fa-map-signs"></i> <?=$row["location"]?></li>
                                        <li><i class="fa fa-money"></i><?=number_format($row['salary_from'], 0, ',', '.') . ' đ'?>-<?=number_format($row['salary_to'], 0, ',', '.') . ' đ'?>
                                        </li>
                                        <li><i
                                                class="fa fa-clock-o"></i><?=diffForHumans(strtotime($row["start_date"]))?>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                        <?php 
                        endforeach;
                    endif;
                    ?>
                    </div>
                </div>

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

        <!-- Datatable JS -->

        <!-- Select2 JS -->

        <!-- Custom JS -->
        <script src="assets/js/app.js"></script>

        <script>
        $(document).ready(function() {

        })
        </script>
</body>

</html>