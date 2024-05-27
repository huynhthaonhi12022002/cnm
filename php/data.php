<?php
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id']}
                OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }
        ($row['status'] == "0") ? $offline = "offline" : $offline = "";
        ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";

        $output .= '<li>
        <a href="chat.php?user_id='. $row['id'] .'">
                    <div class="chat-block d-flex">
                        <span class="avatar align-self-center flex-shrink-0">';
                            if (substr($row["avatar"], 0, 5) === 'https') {
                                $output .= '<img src="' . htmlentities($row["avatar"]) . '" alt="Avatar" class="rounded-circle">';
                            } else {
                                $output .= '<img src="upload/users/' . htmlentities($row["avatar"]) . '" alt="Avatar" class="rounded-circle">';
                            }
                            
                            $output .= ' </span>
                        <div class="media-body align-self-center text-nowrap flex-grow-1">
                            <div class="user-name">'. $row['name'] .'</div>
                        </div>

                    </div>
                </a>
            </li> ';
    } 
?>