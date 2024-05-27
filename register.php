<?php
include_once('includes/config.php');
include_once('class/user.php');

// Khởi tạo đối tượng User
$userObj = new User($dbh);

// Thêm người dùng mới
if (isset($_POST['add_user'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    $role =2;
    $status = 1;
    $new_avatar_name = "";
    // Thêm người dùng vào cơ sở dữ liệu
    $result = $userObj->addUser($name, $email, $password, $new_avatar_name, $role, $status);
    if ($result) {
        $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong></strong> Tạo tài khoản ứng viên thành công!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}
?>

<html lang="en" class="mdl-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Register</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error {
            color: red!important;
        }
    </style>
</head>

<body class="account-page">

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">

            <div class="container">

                <!-- Account Logo -->
                <div class="account-logo">
                    <a href=""><img src="assets/img/logo.png" alt="logo"></a>
                </div>
                <!-- /Account Logo -->

                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Register</h3>
                        <?=$success??""?>
                        <!--  Form -->
                        <form action="#" method="post" id="registrationForm">
                           
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input name="name" type="text" value="" class="form-control ">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="text" value="" class="form-control ">
                            </div>

                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input name="password" class="form-control" type="password">
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input name="password_confirmation" class="form-control" type="password">
                            </div>

                            <div class="form-group text-center d-flex ">
                                <button class="btn btn-primary account-btn" name="add_user" type="submit" style="margin: 0 auto;">Đăng ký</button>
                            </div>
                            <div class="account-footer">
                                <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
                            </div>
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
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#registrationForm").validate({
                rules: {
                    name: {
                        required: true,                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "[name='password']"
                    }
                },
                messages: {
                    name: {
                        required: "*Vui lòng nhập họ tên",
                    },
                    email: {
                        required: "*Vui lòng nhập email",
                        email: "*Vui lòng nhập email hợp lệ"
                    },
                    password: {
                        required: "*Vui lòng nhập mật khẩu",
                    },
                    password_confirmation: {
                        required: "*Vui lòng nhập lại mật khẩu",
                        equalTo: "*Mật khẩu nhập lại không khớp"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
</html>