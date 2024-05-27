<?php 
    session_start();
    if (strlen($_SESSION["userlogin"]) > 0) {
        include_once "config.php";
        // Kiểm tra xem message_id có tồn tại không
        if(isset($_GET['message_id'])) {
            $id = mysqli_real_escape_string($conn, $_GET['message_id']);
            $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
           
                $sql = mysqli_query($conn, "DELETE FROM messages WHERE id = {$id}");
                if ($sql) {
                    header("location: chat.php?user_id=$user_id");
                } else {
                    echo "Lỗi: " . mysqli_error($conn);
                }
        
        } else {
            echo "Không có message_id được cung cấp.";
        }
    } else {
        header("location: ../login.php");
    }
?>