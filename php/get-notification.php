<?php 
    session_start();
    if(strlen($_SESSION['userlogin']) > 0){
        include_once "config.php";
        $outgoing_id = $_SESSION['user_id'];
        $output1 = "";
        $sql = "SELECT msg.*, us.name,us.id as user_id, us.created_at as time , us.avatar FROM messages as msg LEFT JOIN users as us ON us.id = msg.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id}) AND msg.seen = 0
                ORDER BY msg.id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output1 .= '<li class="notification-message">
                                    <a href="chat.php?user_id="'.$row['incoming_msg_id'].'>
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">;
                                                ';
                                                if (substr($row["avatar"], 0, 5) === 'https') {
                                                    $output1 .= '<img src="' . htmlentities($row["avatar"]) . '" alt="Avatar" class="rounded-circle">';
                                                } else {
                                                    $output1 .= '<img src="upload/users/' . htmlentities($row["avatar"]) . '" alt="Avatar" class="rounded-circle">';
                                                }
                                                 
                                            $output1 .= '</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">'.$row["name"].'</span>
                                                <span class="message-time">'.date("d-m-Y H:i:s", strtotime($row['created_at'])).'</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">'.$row["msg"].'</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>';
                }
            }
        }else{
            $output1 .= '<div class="text text-center">No messages are available</div>';
        }
        echo $output1;
    }else{
        header("location: ../login.php");
    }

?>