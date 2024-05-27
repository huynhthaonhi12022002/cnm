<?php
declare(strict_types=1);
session_start();

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

require_once('../vendor/autoload.php');

error_reporting(0);
include('../includes/config.php');

if (strlen($_SESSION['userlogin']) == 0) {
	header('location: ../login.php');
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT id, name as name_user,email,avatar,employee_id, role FROM users WHERE id=:user_id";
$query = $dbh->prepare($sql);
$query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$id_user = $result["employee_id"];

$options = new QROptions([
    'eccLevel' => QRCode::ECC_L,
    'outputType' => QRCode::OUTPUT_MARKUP_SVG,
    'version' => 5,
]);
$qrcode = (new QRCode($options))->render("{$result['employee_id']}");

if(isset($_POST['update_profile'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $id = $_SESSION['user_id'];
    $avatar_name = $_FILES["avatar"]["name"];

    if($avatar_name) {
        $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
        $new_avatar_name = md5($avatar_name . time()) . '.' . $extension;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/users/" . $new_avatar_name);
        $update_sql = "UPDATE users SET email=:email, name=:name, avatar=:avatar WHERE id=:id";
        $update_query = $dbh->prepare($update_sql);
        $update_query->bindParam(':email', $email, PDO::PARAM_STR);
        $update_query->bindParam(':name', $name, PDO::PARAM_STR);
        $update_query->bindParam(':id', $id, PDO::PARAM_STR);
        $update_query->bindParam(':avatar', $new_avatar_name, PDO::PARAM_STR); // Sử dụng tên mới của ảnh đại diện
        $update_query->execute();
    } else {
        $update_sql = "UPDATE users SET email=:email, name=:name WHERE id=:id";
        $update_query = $dbh->prepare($update_sql);
        $update_query->bindParam(':email', $email, PDO::PARAM_STR);
        $update_query->bindParam(':name', $name, PDO::PARAM_STR);
        $update_query->bindParam(':id', $id, PDO::PARAM_STR);
        $update_query->execute();
    }

    $message = "Cập nhật thành công!";
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
        <title>Employee Profile </title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
		
		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="../assets/css/line-awesome.min.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="../assets/css/select2.min.css">
		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
		
		<!-- Tagsinput CSS -->
		<link rel="stylesheet" href="../assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
		
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
            <?php include_once("../includes/header_employee.php");?>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <?php include_once("../includes/sidebar_employee.php");?>
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Profile</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Profile</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					
					<div class="card mb-0">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="profile-view">
					<div class="profile-img-wrap">
						<div class="profile-img">
							<a href="#">
							<?php if (substr($result["avatar"], 0, 5) === 'https'): ?>
							<img src="<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar">
							<?php else: ?>
							<img src="../upload/users/<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar">
							<?php endif; ?>
							</a>
						</div>
					</div>
					<div class="profile-basic">
						<div class="row">
							<div class="col-md-5 profile-info-left">
								<div class="">
									<h3 class="user-name m-t-0 mb-0"><?=$result["name"]?></h3>
									
								</div>
							</div>
							<div class="col-md-7 mb-5">
								<ul class="personal-info">
									<li>
										<div class="title">Role:</div>
										<div class="text">
											<?php 
											if($result["role"] == 1) {
												echo "Admin";
											} elseif($result["role"] == 0) {
												echo "Employee";
											}
											?></div>
									</li>
									<li>
										<div class="title">Email:</div>
										<div class="text"><?=$result["email"]?></div>
									</li>
									<li>
										<div class="title">Mã QR chấm công:</div>
										<div class="text">
                                        <img src="<?=$qrcode ? $qrcode :'' ?>" alt="" srcset="" width="150" height="150">    

                                        </div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" data-avatar="{{ auth()->user()->avatar }}" data-id="{{ auth()->user()->id }}" ><i class="fa fa-pencil"></i></a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Profile Modal -->
<div id="profile_info" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Profile Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" action="" id="form-edit">
					<div class="row">
						<div class="col-md-12">
							<div class="profile-img-wrap edit-img">
								<?php if (substr($result["avatar"], 0, 5) === 'https'): ?>
                                <img src="<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar" class="inline-block">
                                <?php else: ?>
                                <img src="upload/users/<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar" class="inline-block">
                                <?php endif; ?>
							</div>
							<label class="col-form-label">Hình ảnh<span class="text-danger">*</span></label>
							<div class="input-group">
                                <input type="file" name="avatar" id="">
							  </div>
							  <img id="holder" style="margin-top:15px;max-height:100px;">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Full Name</label>
										<input type="text" class="form-control" name="name" value="<?=$result["name"]?>">
									</div>
								</div>
								
								<div class="col-md-12">
									<div class="form-group">
										<label>Email</label>
										<input type="email" class="form-control" name="email" value="<?=$result["email"]?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" name="update_profile">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
					
						<!-- /Projects Tab -->
						
						<!-- Bank Statutory Tab -->
						
				<!-- /Experience Modal -->
				
            </div>
			<!-- /Page Wrapper -->

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
		
		<!-- Tagsinput JS -->
		<script src="../assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

		<!-- Custom JS -->
		<script src="../assets/js/app.js"></script>
		<script>
	$(document).ready(function(){
		$("#form-edit").validate({
			rules: {
				name: "required",
				email: "required",

			},
			messages: {
				name: "*Vui lòng nhập tên!",
				email: "*Vui lòng nhập email!",
			},
      
   		});
	})
</script>
    </body>
</html>