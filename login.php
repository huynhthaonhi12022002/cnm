<?php
	session_start();
	error_reporting(0);
	// ini_set('display_errors', 1);
	include_once("includes/config.php");

	// Check if the user is already logged in, then redirect to index.php
	if(isset($_SESSION['userlogin']) && $_SESSION['userlogin'] > 0){
		header('location:index.php');
		exit();
	}

	if(isset($_POST['login'])){
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);

		// Query user from the database
		$sql = "SELECT email, password, name, id, role, employee_id FROM users WHERE email = :email AND status = 1";
		$query = $dbh->prepare($sql);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$user = $query->fetch(PDO::FETCH_ASSOC);

		// Check if the user exists
		if($user){
			// Verify the password
			if(password_verify($password, $user['password'])){
				// Successful login, set session and redirect
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['userlogin'] = $user['email'];
				$_SESSION['user_name'] = $user['name'];
				$_SESSION['user_role'] = $user['role'];
				$_SESSION['employee_id'] = $user['employee_id'];
				if($user['role'] == 1 && $_SESSION['user_id'] > 0) {
					header('location:index.php');
				} elseif($user['role'] == 2 && $_SESSION['user_id'] > 0) {
					header('location:job-list.php');
				} elseif($user['role'] == 0 && $_SESSION['user_id'] > 0) {
					header('location:./employee/dashboard.php');
				}
				exit();
			} else {
				$alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Oh Snap!😕</strong> Bạn đã nhập sai mật khẩu!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
			}
		} else {
			$alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Oh Snap!🙃</strong> Bạn đã nhập sai email!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
		}
	}
	require_once('login-google.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

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
</head>

<body class="account-page">

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">
                <!-- Account Logo -->
                <div class="account-logo">
                    <a href="index.php"><img src="assets/img/logo2.png" alt="Company Logo"></a>
                </div>
                <!-- /Account Logo -->

                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Login</h3>
                        <!-- Account Form -->
                        <?=$alertMessage?>
                        <form method="POST">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" type="text" placeholder="Nhập email"
                                    value="123123123@gmail.com">
                            </div>
                        
                                <div class="row align-items-center">
                                    <div class="col">
                                        <label class="col-form-label">Mật khẩu</label>
                                    </div>
                                    <div class="col-auto">
                                        <a class="text-muted" href="forgot-password.php">
                                            Quên mật khẩu?
                                        </a>
                                    </div>
                                </div>
                       
                            <input class="form-control" name="password" type="password" placeholder="Nhập mật khẩu"
                                value="123123123">

                   
                    <div class="form-group text-center mt-5">
                        <button class="btn btn-primary account-btn" name="login" type="submit">Đăng nhập</button>
                        <!-- <div class="col-auto " style="margin-top:14px;"> -->


                        <a class="button-google" href="<?=$login_url?>">
                            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid"
                                viewBox="0 0 256 262">
                                <path fill="#4285F4"
                                    d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027">
                                </path>
                                <path fill="#34A853"
                                    d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1">
                                </path>
                                <path fill="#FBBC05"
                                    d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782">
                                </path>
                                <path fill="#EB4335"
                                    d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251">
                                </path>
                            </svg>
                            Đăng nhập bằng Google
                        </a>
                        <!-- </div> -->
                    </div>
					
                    <div class="account-footer">
        <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
    </div>
                    </form>
                    <!-- /Account Form -->
					</div>
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

</body>

</html>