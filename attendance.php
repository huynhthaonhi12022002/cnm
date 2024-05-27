<?php 
    session_start();
    error_reporting(0);
    include_once('includes/config.php');
    include_once('class/attendance.php');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $attendanceObj = new Attendance($dbh);
    if(isset($_POST["employee_id"])) {
        $employee_id = $_POST["employee_id"];
        $employee = $attendanceObj->getEmployeeById($employee_id);
        if($employee) {
            $attendance_data = $attendanceObj->checkAttendanceToday($employee_id);
        
            if ($attendance_data) {
                $checkout = date("H:i");
                $employee = $attendanceObj->getEmployeeById($employee_id);
                $updateResult = $attendanceObj->updateFieldAttendance($attendance_data, 'checkout', $checkout);
                if ($updateResult) {
                    $msg_success = $employee["firstname"]." ".$employee["lastname"]. ' đã check-out thành công!';
                    echo '<span style="display:none">'.$msg_success.'</span>';
                } else {
                    echo "Lỗi khi cập nhật dữ liệu";
                }
            } else {
                $checkin = date("H:i");
                $checkout = 0;
                $status = 0;
               
                $addResult = $attendanceObj->addAttendance($employee_id, $checkin, $checkout, $status);
                if ($addResult) {
                    $msg_success = $employee["firstname"]." ".$employee["lastname"].' check-in thành công!';
                    echo '<span style="display:none">'.$msg_success.'</span>';
                } else {
                    echo "Lỗi khi thêm dữ liệu";
                }
            }
        } else {
            $msg_error = 'Mã QR Code không hợp lệ. Vui lòng thử lại!';
            echo '<span style="display:none">'.$msg_error.'</span>';
        }
        
    }
    
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Chấm công</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="assets/img/favicon.png'">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
   <script src="assets/js/html5shiv.min.js"></script>
   <script src="assets/js/respond.min.js"></script>
  <![endif]-->
    <style>
        .card {
            position: relative;
            overflow: hidden;
        }

        .light-stripe {
            position: absolute;
            top: -100px;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(to bottom, rgba(255, 0, 0, 0.3), transparent);
            animation: light-stripe-animation 3s linear infinite;
        }

        @keyframes light-stripe-animation {
            0% {
                top: -5px;
            }

            50% {
                top: 100%;
            }

            100% {
                top: -5px;
            }
        }
    </style>
</head>

<body class="account-page" style="align-items: unset">

      <!-- Account Logo -->
      <div class="account-logo" >
        <a href="login.php"><img
                src="assets/img/logo.png"
                alt="logo"></a>
    </div>
    <!-- /Account Logo -->
    <!-- Main Wrapper -->
    <div class="main-wrapper" style="justify-content: flex-start;background-image: url('assets/img/background-hrm.png'); background-size: cover;background-position:center ">
        <div class="account-content">
            <div class="container">

                <div class="account-box" style="width: 715px!important;border-radius:60px;margin-top:100px;">
                    <div class="account-wrapper">
                        <h2 class="account-title" style="font-weight: bold">Chấm công nhân viên</h2>
                        
                        <?php 
                        if(isset($msg_error)) {
                            echo '<div id="msg_error" class="bg-danger p-3 rounded text-center mb-2 text-sm text-white">
                            '.$msg_error.'
                            </div>';
                        }
                        if(isset($msg_success)) {
                            echo '<div id="msg_success" class="bg-success p-3 rounded text-center mb-2 text-sm text-white">
                            '.$msg_success.'
                            </div>';
                        }
                        ?>
                        <!--  Form -->
                        <div class="card bg-white shadow rounded-3 p-3 border-0">
                            <video id="preview"></video>
                            <div class="light-stripe"></div>
                        </div>
                        <form action="#" method="post" id="form">
                            <input type="hidden" name="employee_id" id="employee_id">
                        </form>
                        <!-- / Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        scanner.addListener('scan', function(content) {
            console.log(content);
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(c) {
            document.getElementById('employee_id').value = c;
            document.getElementById('form').submit();
        })
        setTimeout(function(){
        document.getElementById('msg_success').remove();
        }, 2000); 
        setTimeout(function(){
            document.getElementById('msg_error').remove();
        }, 2000); 
    </script>
</body>

</html>
