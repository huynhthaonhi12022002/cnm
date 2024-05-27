<?php 
include_once ('includes/config.php');
function generateRandomPassword($length = 8) {
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialChars = '!@#$%^&*()-_+=\/{}[]|';
    $allChars = $uppercase . $lowercase . $numbers . $specialChars;
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $char = $allChars[rand(0, strlen($allChars) - 1)];
        $password .= $char;
    }
    $password = str_shuffle($password);
    return $password;
}

function sendMail($email,$password) {
	require "PHPMailer-master/src/PHPMailer.php"; 
    require "PHPMailer-master/src/SMTP.php"; 
    require 'PHPMailer-master/src/Exception.php'; 
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);//true:enables exceptions
    try {
        $mail->SMTPDebug = 0; //0,1,2: chế độ debug
        $mail->isSMTP();  
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com';  //SMTP servers
        $mail->SMTPAuth = true; // Enable authentication
        $mail->Username = 'dungtanthuy512@gmail.com'; // SMTP username
        $mail->Password = 'tzuhafujugzcobzd';   // SMTP password
        $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
        $mail->Port = 465;  // port to connect to                
        $mail->setFrom('dungtanthuy512@gmail.com', 'ADMIN QLNS' ); 
        $mail->addAddress($email); 
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Thư gửi lại thiết lập mật khẩu';
        $noidungthu = "<p>Bạn nhận được thư này do có ai đó yêu cầu thiết lập mật khẩu mới. Mật khẩu mới của bạn là: {$password} </p>";
        $mail->Body = $noidungthu;
        $mail->smtpConnect( array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        ));
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo 'Error: ', $mail->ErrorInfo;
		return false;
    }
}

if(isset($_POST['btn-forgot'])) {
	$email = $_POST['email'];
	$sql = "SELECT password FROM users WHERE email=:email";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->execute();
	$result = $query->rowCount();
	if($result == 0) {
		$error = "Email của bạn đã nhập không tồn tại!";
	} else {
		$password = generateRandomPassword();
		$new_password = password_hash( $password, PASSWORD_DEFAULT);
		$sql = "UPDATE users SET password =:password WHERE email=:email";
		$query = $dbh->prepare($sql);
		$query->bindParam(':password', $new_password, PDO::PARAM_STR);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$kq = sendMail($email,$password); 
		if($kq) {
			$success = "Đã gửi mật khẩu mới qua email của bạn. Vui lòng kiểm tra email!";
		} else {
			$error = "Gửi không thành công!";
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
        <meta name="robots" content="noindex, nofollow">
        <title>Forgot Password</title>
		
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
						<a href="index.php"><img src="assets/img/logo2.png" alt="Dreamguy's Technologies"></a>
					</div>
					<!-- /Account Logo -->
					
					<div class="account-box">
						
						<div class="account-wrapper">
						<?php if(isset($error)):?>
							<div class="alert alert-danger text-center">	
								<?=$error?>
							</div>
						<?php endif;?>
						<?php if(isset($success)):?>
							<div class="alert alert-success text-center">	
								<?=$success?>
							</div>
						<?php endif;?>
							<h3 class="account-title">Bạn quên mật khẩu?</h3>
							<p class="account-subtitle">Hãy nhập email để thiết lập lại mật khẩu</p>
							
							<!-- Account Form -->
							<form method="POST">
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" name="email" type="email">
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" name="btn-forgot" type="submit">Thiết lập mật khẩu</button>
								</div>
								<div class="account-footer">
									<p>Bạn nhớ mật khẩu? <a href="login.php">Đăng nhập</a></p>
								</div>
							</form>
							<!-- /Account Form -->
							
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
<!-- Copied from https://dreamguys.co.in/smarthr/orange/forgot-password.php by Cyotek WebCopy 1.8.0.652, Friday, August 28, 2020, 10:33:50 AM -->
</html>