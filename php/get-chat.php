<?php 
    session_start();
    if(strlen($_SESSION['userlogin']) > 0){
        include_once "config.php";
        $outgoing_id = $_SESSION['user_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT msg.*, us.id as user_id, us.created_at as time , us.avatar FROM messages as msg LEFT JOIN users as us ON us.id = msg.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg.id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="chat chat-right">
                                    <div class="chat-body">
                                        <div class="chat-bubble">
                                            <div class="chat-content">
                                                <p>'.$row['msg'].'</p>
                                                <span class="chat-time">'.date("d-m-Y H:i:s", strtotime($row['created_at'])).'</span>
                                            </div>
                                            <div class="chat-action-btns">
                                                <ul>
                                                    <li><a href="#" class="del-msg" data-bs-toggle="modal" data-bs-target="#delete_message_'.$row['id'].'"><i
                                                                class="fa-regular fa-trash-can"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal custom-modal fade" id="delete_message_'.$row['id'].'" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="form-header">
                                                    <h3>Delete Asset</h3>
                                                    <p>Are you sure want to delete?</p>
                                                </div>
                                                <div class="modal-btn delete-action">
                                                    <div class="row">
                                                        <div class="col-6">
                                                        <form class="deleteMessageForm">
                                                                    <input type="hidden" class="messageIdInput" name="message_id" id="message-'.$row['id'].'" value="'.$row['id'].'">
                                                                    <!-- Các trường dữ liệu khác bạn muốn bổ sung cho form xóa -->
                                                             
                                                                <button type="submit">Xóa Tin Nhắn</button>
                                                                </form>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ';
                }else{
                    $output .= '<div class="chat chat-left">
                    <div class="chat-avatar">
                        <a href="profile.html" class="avatar">
                            ';
                            if (substr($row["avatar"], 0, 5) === 'https') {
                                $output .= '<img src="' . htmlentities($row["avatar"]) . '" alt="Avatar" class="rounded-circle">';
                            } else {
                                $output .= '<img src="upload/users/' . htmlentities($row["avatar"]) . '" alt="Avatar" class="rounded-circle">';
                            }
                    $output .= '</a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-bubble">
                                            <div class="chat-content">
                                                <p>' . $row['msg'] . '</p>
                                                <span class="chat-time">'.date('d-m-Y H:i:s', strtotime($row['created_at'])).'</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text text-center">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }

?>