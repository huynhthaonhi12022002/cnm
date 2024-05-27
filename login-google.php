<?php
require('./config.php');
# the createAuthUrl() method generates the login URL.
$login_url = $client->createAuthUrl();
/* 
 * After obtaining permission from the user,
 * Google will redirect to the login.php with the "code" query parameter.
*/
if (isset($_GET['code'])):

  session_start();
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  if(isset($token['error'])){
    header('Location: login.php');
    exit;
  }
  $_SESSION['token'] = $token;

  /* -- Inserting the user data into the database -- */

  # Fetching the user data from the google account
  $client->setAccessToken($token);
  $google_oauth = new Google_Service_Oauth2($client);
  $user_info = $google_oauth->userinfo->get();

  $google_id = trim($user_info['id']);
  $f_name = trim($user_info['given_name']);
  $l_name = trim($user_info['family_name']);
  $fullname = $f_name." ".$l_name;
  $email = trim($user_info['email']);
  $gender = trim($user_info['gender']);
  $local = trim($user_info['local']);
  $picture = trim($user_info['picture']);

  # Database connection
  $db_host = 'localhost';
  $db_user = 'root';
  $db_password = '';
  $db_name = 'smarthr';
  
  $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
  
  if ($db_connection->error) {
    echo "Connection Failed - " . $db_connection->connect_error;
    exit;
  }

# Checking whether the email already exists in our database.
$check_email = $db_connection->prepare("SELECT `id`,`email`,`role`, `employee_id` FROM `users` WHERE `email`=? AND status = 1");
$check_email->bind_param("s", $email);
$check_email->execute();
$check_email->store_result();
$password = "";
$role = 2;
$status = 1;
$employee_id = "null";

if ($check_email->num_rows === 0) {
    # Inserting the new user into the database
    $query_template = "INSERT INTO `users` (`name`,`email`,`password`,`avatar`,`role`, `status`,`employee_id`) VALUES (?,?,?,?,?,?,?)";
    $insert_stmt = $db_connection->prepare($query_template);
    $insert_stmt->bind_param("sssssss", $fullname , $email, $password ,$picture, $role,$status, $employee_id);
    if (!$insert_stmt->execute()) {
        echo "Failed to insert user.";
        exit;
    }

    // Fetch the inserted user's information
    $_SESSION['user_id'] = $insert_stmt->insert_id;
    $_SESSION['userlogin'] = $email;
    $_SESSION['user_role'] = $role; // Set the user's role as the default role
	if ($role == 2) {
        header('Location: job-list.php');
    }
    header('Location: login.php');
    exit;
} else {
    // Fetch the existing user's information
    $check_email->bind_result($user_id, $user_email, $user_role, $user_employee_id);
    $check_email->fetch();

    // Store the user's information in the session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['userlogin'] = $user_email;
    $_SESSION['user_role'] = $user_role;
    $_SESSION['employee_id'] = $user_employee_id;
    // Redirect the user based on their role
    if ($_SESSION['user_role'] == 1) {
        header('Location: index.php');
    } elseif ($_SESSION['user_role'] == 2) {
        header('Location: job-list.php');
    } elseif($_SESSION['user_role'] == 0) {
        header('location:./employee/dashboard.php');
    }
    exit;
}


endif;
?>