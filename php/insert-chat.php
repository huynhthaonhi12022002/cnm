<?php 
    session_start();
    if (strlen($_SESSION["userlogin"]) > 0) {
        include_once "config.php";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $created_at =  date('Y-m-d H:i:s');
        $outgoing_id = $_SESSION['user_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, created_at)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$created_at}')") or die();
        }
    }else{
        header("location: ../login.php");
    }


    
?>