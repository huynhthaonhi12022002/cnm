<?php 
	session_start();
	error_reporting(0);
	include_once('includes/config.php');
	if(strlen($_SESSION['userlogin'])==0){
		header('location:login.php');
	}

	if(isset($_POST['change_pass'])) {
		$currentpassword = htmlspecialchars($_POST['password']);
		$npass = htmlspecialchars($_POST['newpassword']);
		$confirmpass = htmlspecialchars($_POST['confirmpassword']);
		$username = $_SESSION['userlogin'];
		
		// Retrieve current password from the database
		$sql = "SELECT password FROM users WHERE email=:uname";
		$query = $dbh->prepare($sql);
		$query->bindParam(':uname', $username, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$dbPassword = $result['password'];
		if(!empty($dbPassword)) {
			if(password_verify($currentpassword, $dbPassword)) {
				// Check if new password matches the confirmation
				if($npass == $confirmpass) {
					// Hash the new password
					$hashed_password = password_hash($npass, PASSWORD_DEFAULT);
					// Update the password in the database
					$update_sql = "UPDATE users SET password=:password WHERE email=:email";
					$update_query = $dbh->prepare($update_sql);
					$update_query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
					$update_query->bindParam(':email', $username, PDO::PARAM_STR);
					$update_query->execute();
					$message = "Đổi mật khẩu thành công!";
				} else {
					$message = "Mật khẩu mới và mật khẩu xác nhận không giống!";
				}
			} else {
				$message = "Mật khẩu cũ không đúng!";
			}
		} else {
			if($npass == $confirmpass) {
				// Hash the new password
				$hashed_password = password_hash($npass, PASSWORD_DEFAULT);
				// Update the password in the database
				$update_sql = "UPDATE users SET password=:password WHERE email=:email";
				$update_query = $dbh->prepare($update_sql);
				$update_query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
				$update_query->bindParam(':email', $username, PDO::PARAM_STR);
				$update_query->execute();
				$message = "Đổi mật khẩu thành công!";
			} else {
				$message = "Mật khẩu mới và mật khẩu xác nhận không giống!";
			}
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
        <title>Change Password</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Lineawesome CSS -->
		<link rel="stylesheet" href="assets/css/line-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
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
            <?php include_once("includes/header.php");?>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <?php include_once("includes/sidebar.php");?>
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content">
						<div class="col-md-12 ">
						
							<!-- Page Header -->
							<div class="page-header">
								<div class="row">
									<div class="col-sm-12">
										<h3 class="page-title">Change Password</h3>
									</div>
								</div>
							</div>
							<!-- /Page Header -->
							<?php // Verify current password
								if(isset($message)) {
									if($message == "Đổi mật khẩu thành công!") {
										echo ' <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" >
										<strong>Success!</strong> '.$message.'
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
									} else {
										echo '  <div class="alert alert-warning alert-dismissible fade show" role="alert" id="delete-alert" >
										<strong>Warning!</strong> '.$message.'
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
									}
								}
								
							?>
							<form method="POST" enctype="multipart/form-data"> 
								<div class="form-group">
									<label>Mật khẩu cũ</label>
									<input  name="password" type="password" class="form-control">
								</div>
								<div class="form-group">
									<label>Mật khẩu mới</label>
									<input required name="newpassword" type="password" class="form-control">
								</div>
								<div class="form-group">
									<label>Mật khẩu xác nhận</label>
									<input required name="confirmpassword" type="password" class="form-control">
								</div>
								<div class="submit-section">
									<button type="submit" name="change_pass" class="btn btn-primary submit-btn">Lưu</button>
								</div>
							</form>
						</div>
				</div>
				<!-- /Page Content -->
				
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
		
		<!-- Select2 JS -->
		<script src="assets/js/select2.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/app.js"></script>

    </body>
</html>
