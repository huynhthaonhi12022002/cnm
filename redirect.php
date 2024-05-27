<?php
session_start();

// Cài đặt thông tin OAuth 2.0 từ Google Developer Console
$client_id = '806943956-5i3jnf20h8dh6ra8mvmluo9qbs23kjjn.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'http://localhost/cnm/redirect.php';

define('LOCALHOST','localhost');
define('USERNAME','root');
define('PASSWORD','');
define('DATABASE','smarthr');

$conn = mysqli_connect(LOCALHOST,USERNAME,PASSWORD,DATABASE);
if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// Tải các thư viện Google API Client
require_once __DIR__ . '/vendor/autoload.php';

// Tạo một đối tượng Google Client
$google_client = new Google_Client();
$google_client->setClientId($client_id);
$google_client->setClientSecret($client_secret);
$google_client->setRedirectUri($redirect_uri);
$google_client->addScope('email');
$google_client->addScope('profile');


// Tải các thư viện Google API Client
if (isset($_GET['code'])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
   // print_r($token);
    $google_client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($google_client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;
    print_r($google_account_info);
   /**
    * CHECK EMAIL AND NAME IN DATABASE
    */
    $check = "SELECT * FROM `users` WHERE `email`='$email' LIMIT 1";
    $result = mysqli_query($conn, $check);
    $rowcount = mysqli_num_rows($result);
    
    if($rowcount>0){
        /**
         * USER EXITS
         */
        header('Location:index.php');
    }
    else{
        /**
         * INSERT USER TO DATABASE
         * AFTER INSERT, YOU CAN HEADER TO HOME
         */

    }
    
} else {
    /**
     * IF YOU DON'T LOGIN GOOGLE
     * YOU CAN SEEN AGAIN GOOGLE_APP_ID, GOOGLE_APP_SECRET, GOOGLE_APP_CALLBACK_URL
     */
    header('Location:login.php');
}
