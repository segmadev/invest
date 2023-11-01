<?php
class chat extends user
{


    function bot_generate_message(array $messages, $groupID = 2,) {
        // get all messages
        $messages = [
           
        ];
        foreach ($messages as $key => $message) {
            $i = 0;
            if($this->getall("message", "message = ?", [$message],  fetch: "") > 0) { continue; }
            $user = $this->getall("users", "acct_type = ? and status =  ? ORDER BY RAND()", ["bot", "active"]);
            $date = $this->generateRandomDateTime();
            $data = ["chatID"=>"", "senderID" => $user['ID'], "receiverID" => $groupID, "message" => $message, "is_group" => "yes", "time_sent" => strtotime($date), "date" => $date];
            if($this->quick_insert("message", $data)) { $i++; }
            $this->message("$i messages genrated.", "success");
        }
    }



    function create_bot_conversation(array $messages, $groupID = 2,)
    {
        $i = 0;
        foreach ($messages as $message) {
            $user = $this->getall("users", "acct_type = ? and status =  ? ORDER BY RAND()", ["bot", "active"]);
            $date = $this->generateRandomDateTime();
            $data = ["chatID" => "", "senderID" => $user['ID'], "receiverID" => $groupID, "message" => "", "is_group" => "yes", "time_sent" => strtotime($date), "reply_to" => "", "date" => $date];
            if (is_array($message) && isset($message['main_message']) || isset($message['response'])) {
                $data['message'] = $message['main_message'];
                if($this->getall("message", "message = ?",  [$message['main_message']], fetch: "") > 0) { continue; }
                if (!$this->quick_insert("message", $data)) {
                    continue;
                }
                if (isset($message['response']) && !$this->reply_to_message($data['message'], $message['response'])) {
                    continue;
                }
                if (isset($message['message']) && !$this->reply_to_message($message['response'], $message['message'], $user['ID'])) {
                    continue;
                }
            }else if(isset($message['message'])){
                $data['message'] = $message['message'];
                if($this->getall("message", "message = ?",  [$message['message']], fetch: "") > 0) { continue; }
                if (!$this->quick_insert("message", $data)) {
                    continue;
                }
            }
            $i++;
        }
        $this->message("$i of conversations created", "success");
    }
    

    function reply_to_message($message, $response, $userID = "admin") {
        $data = $this->getall('message', "message = ?", [$message]);
        if(!is_array($data)) { return false; }
        $data['date'] = $this->addMinutes($data['date'], rand(1, 5));
        $replyID = $data["ID"];
        $data['message'] = $response;
        $data['reply_to'] = $replyID;
        $data["time_sent"] = strtotime($data['date']);
        $data['senderID'] = $userID;
        unset($data['ID']);
        if($this->quick_insert("message", $data)) { return true; }
        return false;
    }
    function delete_message($id)
    {
        if (!$this->validate_admin()) {
            return false;
        }
        $message = $this->getall("message", "ID = ?", [$id]);
        if (!is_array($message)) {
            return false;
        }
        $message = $message['message'];
        $this->delete("message", "ID = ?", [$id]);
        $this->delete("notifications", "n_for = ? and description = ?", ["message", $message]);
        // removediv(id, type="id")
        $return = [
            "message" => ["Success", "Message Deleted. You might have to repload page to see update.", "success"],
            "function" => ["removediv", "data" => ["#chat-ID-".$id, "placeholder"]],
        ];
        return json_encode($return);
    }

    function new_chat($data, $action  = "insert")
    {
        $info = $this->validate_form($data, "chat", $action);
        if (is_array($info)) {
            return null;
        }
        return true;
    }

    function get_chat($chatID, $userID)
    {
        if (isset($_SESSION['adminSession']) && !isset($_SESSION['userSession'])) {
            return $this->getall("chat", "ID = ?", [$chatID]);
        } else {
            $chat =  $this->getall("chat", "ID = ?", [$chatID]);
            if($chat["user1"] == $userID || $chat['user2'] == $userID ||  $chat['user2'] == "all") {
                return $chat;
            }
            return [];
        }
    }
    function get_sender($chat, $userID)
    {
        if ($userID !=  "admin") {
            if ($chat['user1'] == $userID) {
                $message_form['input_data']['receiverID'] = $chat['user2'];
            } else {
                $message_form['input_data']['receiverID'] = $chat['user1'];
            }
        } else {
            if ($chat['is_group'] == "yes") {
            }
        }
    }
    function new_message($data, $action = "insert")
    {
        $data['time_sent'] = [];
        $_POST['time_sent'] = time();
        $info = $this->validate_form($data, "message", $action);
        // var_dump($info);
        if (!is_array($info)) {
            return false;
        }
        if ($info['is_group'] == "yes") {
            $this->group_chat_notification($info['senderID'], $info['message'],  time(),   $info['receiverID']);
        } else {
            $this->user_chat_notification($info, time());
        }
        return true;
    }

    function read_all_message($userID, $chatID)
    {
        $chat = $this->getall("chat", 'ID = ?', [$chatID], "is_group");
        if (!is_array($chat)) {
            return 0;
        }
        if ($chat['is_group'] == "yes") {
            $chat = $this->getall("chat", "ID = ?", [$chatID], "user2");
            if (is_array($chat)) {
                $groupID = $chat['user2'];
                return $this->update("message",  ["seen_by" => $userID], " senderID != '$userID' and receiverID = '$groupID' and seen_by = 'null'");
                // return $this->getall("message", "senderID != ? and receiverID = ? and seen_by = ?", [$userID, $chat['user2'], 'null'], fetch: "");
            }
        }

        // $this->blulk_exclude_user($chatID, $userID);
        $update =  $this->update("message", ["seen_by" => $userID], "chatID = '$chatID' and receiverID = '$userID' and seen_by = 'null'");
        return $update;
    }

    function get_unseen_message($userID, $chatID)
    {
        // get all from messages where chatid =  $chatID join seen_messages  id is not
        $chat = $this->getall("chat", 'ID = ?', [$chatID], "is_group");
        if (!is_array($chat)) {
            return 0;
        }
        if ($chat['is_group'] == "yes") {
            $chat = $this->getall("chat", "ID = ?", [$chatID], "user2");
            if (is_array($chat)) {
                return $this->getall("message", "senderID != ? and receiverID = ? and seen_by = ?", [$userID, $chat['user2'], 'null'], fetch: "");
            }
        }
        return $this->getall("message", "chatID = ? and receiverID = ? and seen_by = ?", [$chatID, $userID, 'null'], fetch: "");
        // return $this->getall("message as m join (SELECT * FROM seen_messages as sm GROUP BY sm.ID) sm", 'm.chatID = ? and m.receiverID = ?',[$chatID, $userID], "m.*", fetch: "");
        // return $this->getall("message as m join seen_messages", 'seen_messages.messageID and m.chatID = ? and m.receiverID = ?',[$chatID, $userID], "m.*", fetch: "");

    }

    function list_chat_users($chats, $userID)
    {
        if ($chats->rowCount() > 0) {
            foreach ($chats as $row) {
                $active = "";
                if (isset($chatID) && $chatID == $row['ID']) {
                    $active = "bg-light";
                }
                echo $this->list_user($row, $userID, $active);
            }
        }
    }

    function get_chats($userID)
    {
        if (isset($_SESSION['adminSession'])) {
            $chats = $this->getall("chat c LEFT JOIN ( SELECT m.chatID, message, MAX(m.date) AS min_date FROM message m GROUP BY m.chatID ) m ON c.ID = m.chatID", "c.user1 = ? or c.is_group = ? ORDER BY m.min_date DESC", ["admin", "no"], select: "c.*", fetch: "moredetails");
            return $chats;
        }
        $chats = $this->getall("chat c LEFT JOIN ( SELECT m.chatID, message, MAX(m.date) AS min_date FROM message m GROUP BY m.chatID ) m ON c.ID = m.chatID", "c.user1 = ? or c.user2 = ? ORDER BY m.min_date DESC", [$userID, $userID], "c.*", fetch: "moredetails");
        // $chats = $this->getall("chat", "ID = ? ORDER BY date DESC LIMIT $start, $limit", [], fetch: 'moredetails');
        return $chats;
    }

    // $2y$10$04dmPY/uRtiOJ2UIChW4/eGQA4cVYeQX5RPGnJqfQe/Xz.1E6ob7a
    function get_last_seen($userID)
    {
        $last_seen = $this->getall("users", "ID = ?", [$userID], "last_seen");
        if (!is_array($last_seen)) {
            return "";
        }
        return $this->proccess_last_seen($last_seen['last_seen']);
    }

    function proccess_last_seen($last_seen)
    {

        $now = time();
        $difference     = $now - (int)$last_seen;
        if ($difference < 10) {
            return '<span class="p-1 badge rounded-pill bg-success"><span class="visually-hidden">kdkd</span></span> Online';
        }


        return '<span class="p-1 badge rounded-pill bg-dark"><span class="visually-hidden">kdkd</span></span> Offline ' . $this->ago($last_seen);
    }

    function no_users_in_group($groupID)
    {
        return $this->getall("chat", "user2 = ? and is_group = ? and is_bot = ?", [$groupID, "yes", "yes"], fetch: "");
    }
    function get_all_messages($chatID, $userID,  $start = 0, $limit = 50, $chat = "", $orderby = "date ASC", $where = "time_sent > ?")
    {
        if($this->validate_admin()) {
            $chat = $this->get_chat($chatID, $userID);
        }

        if ($chat == "") {
            $chat =  $this->getall("chat", "ID = ? and user1 = ? or user2 = ? or user2 = ?", [$chatID, $userID, $userID, "all"]);
        }


        if ($chat['is_group'] == 'yes') {
            if($start == "first") {
                $start = $this->getall("message", "receiverID = ?", [$chat['user2']], fetch: "") - 100;
                if($start < 0) {$start = 0;}
                $messages = $this->getall("message", "receiverID = ? order by $orderby LIMIT $start, $limit", [$chat['user2']], fetch: "moredetails");
            }else {
                $messages = $this->getall("message", "receiverID = ? and $where order by $orderby LIMIT  $limit", [$chat['user2'], $start], fetch: "moredetails");
            }
        }else{
            if($start == "first") {
                $start = $this->getall("message", "chatID = ?", [$chatID], fetch: "") - 100;
                if($start < 0) {$start = 0;}
            }
            $messages = $this->getall("message", "chatID = ? and $where order by $orderby LIMIT $limit", [$chatID, $start], fetch: "moredetails");
        }
        return $messages;
    }
    function delete_chat($messageID, $userID)
    {
        $delete = $this->delete("message", "ID = ? and userID = ?", [$messageID, $userID]);
        if (!$delete) {
            return false;
        }
        return $this->message("Chat deleted", "success", "json");
    }

    function group_chat_notification($userID, $message, $time_sent, $groupID)
    {
        $group = $this->getall("groups", "ID = ?", [$groupID]);
        if (!is_array($group)) {
            return false;
        }
        $data = [];
        $data['userID'] = $group['users'];
        $data['n_for'] = "message";
        $data['url'] = "index?p=chat&action=view&groupID=" . $groupID;
        $data['title'] = "New Message from " . $group['name'];
        $data['description']  = $this->short_text($message);
        $data['exclude'] = $userID;
        $data['time_set'] = $time_sent;
        $data['icon'] = $this->get_profile_icon_link($groupID, "groups");
        $this->new_notification($data);
    }

    function user_chat_notification($message, $time_sent)
    {
        $data = [];
        $user = $this->getall("users", "ID = ?", [$message['senderID']], "first_name");
        if (!is_array($user)) {
            return false;
        }
        $data['userID'] = $message['receiverID'];
        $data['n_for'] = "message";
        $data['forID'] = $message['chatID'];
        $data['url'] = "index?p=chat&action=view&userid=" . $message['senderID'];
        $data['title'] = "New Message from " . $user['first_name'];
        $data['description']  = $this->short_text($message['message']);
        $data['time_set'] = $time_sent;
        $data['icon'] = $this->get_profile_icon_link($message['senderID']);
        $this->new_notification($data);
    }


    function get_chat_message($chatID, $no = 0, $limit = 100)
    {
        $message = $this->getall("message", "chatID = ? order by date DESC LIMIT $no, $limit", [$chatID], "moredetails");
    }

    function display_message(array $message, $userID)
    {
        if ($message['senderID']  == $userID) {
            $this->display_send_message($message);
        } else {
            $this->display_receive_message($message);
        }
    }

    function get_group_users($groupID, $start, $limit)
    {
        if($this->getall("groups", "ID = ? and users = ?", [$groupID, "all"], fetch: "") > 0){
            $chats = $this->getall("users", "acct_type = ? order by date DESC LIMIT $start, $limit", ['bot'], "ID as user1", fetch: "moredetails");
        }else{
            $chats = $this->getall("chat", "user2 = ? and is_group = ? and is_bot = ? order by date DESC LIMIT $start, $limit", [$groupID, "yes", "yes"], fetch: "moredetails");
        }
        if ($chats->rowCount() > 0) {
            // echo $chats->rowCount();
            foreach ($chats as $row) {
                echo $this->display_chat_users_list($row);
            }
            return;
        }
        return "null";
    }

    function last_message($chatID, $userID, $is_group = "no")
    {
        $message = "";
        $last = "";
        if ($is_group == "no") {
            $last = $this->getall("message", "chatID = ? order by date DESC", [$chatID], "message, senderID");
        } else {
            $chat = $this->getall("chat", "ID = ?", [$chatID], "user2");
            if (is_array($chat)) {
                $last = $this->getall("message", "receiverID = ? order by date DESC", [$chat['user2']], "message, senderID");
            }
        }

        if (is_array($last)) {
            if ($last['senderID'] == $userID) {
                $message = "You: ";
            }
            $message = $message . $last['message'];
        }
        return $message;
    }
    function display_chat_users_list($row)
    {

        $id = $row['user1'];
        $what = "users";
        return '
            <a href="index?p=chat&action=view&userid=' . $row['user1'] . '"
                class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user"
                >
                <div class="d-flex align-items-center">
                    <span class="position-relative">
                        <img src="' . $this->get_profile_icon_link($id, $what) . '" alt="user1" width="48" height="48" class="rounded-circle" />
                        
                    </span>
                    <div class="ms-3 d-inline-block w-75">
                        <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">' . $this->get_name($id, $what) . '</h6>
                        <span class="fs-3 text-truncate text-body-color d-block"></span>
                    </div>
                </div>
            </a>
        ';
    }
    function display_image_message($message)
    {
        echo '<div data-chat-id="' . $message['ID'] . '" class="hstack gap-3 align-items-start mb-7 justify-content-start">
            <img src="dist/images/profile/user-8.jpg" alt="user8" width="40" height="40"
                class="rounded-circle" />
            <div>
                <h6 class="fs-2 text-muted">Andrew, 2 hours ago</h6>
                <div class="rounded-2 overflow-hidden">
                    <img src="dist/images/products/product-1.jpg" alt="" class="w-100">
                </div>
            </div>
        </div>       
       ';
    }
    function display_receive_message($message)
    {
        $upload = "";
        if ($message['upload'] != "" || $message['upload'] != null) {
            $upload =  $upload = $this->display_img($message);
        }
        echo '<div  id="chat-ID-'.$message['ID'].'" data-chat-id="' . $message['time_sent'] . '" class="hstack gap-3 align-items-start mb-7 justify-content-start">
            <a href="index?p=chat&action=view&userid='.$message['senderID'].'"><img src="' . $this->get_profile_icon_link($message['senderID']) . '" alt="user8" width="40" height="40"
                class="rounded-circle"></a>
            <div>
            <a href="index?p=chat&action=view&userid='.$message['senderID'].'"><h6 class="fs-2 text-muted">' . $this->get_name($message['senderID'], "users") . ', ' . $this->ago($message['time_sent']) . '</h6></a>
            '.$this->display_reply_to($message).'
                ' . $upload . '
                
                <div class="p-2 bg-light rounded-1 d-inline-block text-dark fs-3"> ' . $message['message'] . ' </div>
                '.$this->reply_message($message).'
                </div>
            ' . $this->message_options_btn($message) . '
        </div>';
    }

function reply_message(array $message) {
    return '<button onclick="reply_to(\''.$message['ID'].'\', \''.addslashes($message['message']).'\')" class="text-success btn"><i class="ti ti-arrow-back-up"></i> Reply</button>';
}
    function message_options_btn($message)
    {
        if(!$this->validate_admin()) { return ""; }
        return '<div class="btn-group mb-2">
            <button type="button" class="bg-none border-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">View Profile</a></li>
                <li>
                    <a class="dropdown-item text-success" href="index?p=users&action=access&id=' . $message['senderID'] . '">Gain Access to Account</a>
                </li> 
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                <form action="" id="foo">
                                    <input type="hidden" name="delete_message" value="'.$message['ID'].'">
                                    <input type="hidden" name="confirm" value="Are you sure you want to delete this message?">
                                    <input type="hidden" name="page" value="chat" />
                                    <div id="custommessage"></div>
                                <input type="submit" name="delete_message" class="dropdown-item text-danger" value="Delete Message">
                    </form>
                    <form action="" id="foo">
                        <input type="hidden" name="block_chat_account" value="'.$message['senderID'].'">
                        <input type="hidden" name="confirm" value="Are you sure you want to block this user from accessing chat?">
                        <input type="hidden" name="page" value="users"/>
                        <div id="custommessage"></div>
                        <input type="submit" name="block_user_chat" class="dropdown-item text-danger" value="Block chat account">
                    </form>
                    <form action="" id="foo">
                        <input type="hidden" name="block_account" value="'.$message['senderID'].'">
                        <input type="hidden" name="confirm" value="Are you sure you want to block this user?">
                        <input type="hidden" name="page" value="users"/>
                        <div id="custommessage"></div>
                        <input type="submit" name="block_account" class="dropdown-item text-danger" value="Block account">
                    </form>
                    </li>
            </ul>
        </div>';
    }
    function display_img(array $message)
    {
        return '<div id="image-' . $message['ID'] . '" data-url="modal?p=viewer&path=assets/images/chat/' . $message['upload'] . '" data-title="Image Viewer" onclick="modalcontent(this.id)" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md" class="rounded-2 overflow-hidden">
                <img src="assets/images/chat/' . $message['upload'] . '" alt="uploaded" class="w-30">
            </div>';
    }
    function display_send_message($message)
    {
        $upload = "";
        if ($message['upload'] != "" || $message['upload'] != null) {
            $upload = $this->display_img($message);
        }

        echo '


        <div id="chat-ID-'.$message['ID'].'" data-chat-id="' . $message['time_sent'] . '" class="hstack gap-3 align-items-start mb-7 justify-content-end">
           
        <div class="text-end">
        <div class="p-2  text-dark fs-2 m-0">
        
                '.$this->display_reply_to($message).'
                </div>
                ' . $upload . '
                <div class="p-2 bg-light-info text-dark rounded-1 d-inline-block fs-3 m-0"> ' . $message['message'] . '</div>
                <br>
                ' . $this->ago($message['time_sent']) . '
                '.$this->reply_message($message).'
            </div>
            ' . $this->message_options_btn($message) . '
        </div>';
    }
    function display_reply_to($message) {
        if(empty($message['reply_to']) ||  $message['reply_to'] == null) {
            return  "";
        }
        $reply_message = $this->getall("message", "ID = ?", [$message['reply_to']]);
        if(!is_array($reply_message)) { return ""; }
        return '<h6 class="fs-3 text-muted bg-dark p-2 m-0">
        <p class="text-success fs-1 m-0 p-0">'.$this->get_name($reply_message['senderID']).'</p>
         ' . $reply_message['message'] . '
         
        </h6>';

    }

    function list_user($row, $userID, $active = "")
    {
        $id = $row['user1'];
        $what = "users";
        if ($row['user1'] == $userID) {
            $id = $row['user2'];
        }

        if ($row['is_group'] == "yes") {
            $what = "groups";
        }
        $no = $this->get_unseen_message($userID, $row['ID']);
        $nameclass = "";
        $badge = "";
        if ($no > 0) {
            $nameclass = "fw-semibold";
        }
        if ($no == 0) {
            $no = "";
        }
        if ($no > 99) {
            $no = "99+";
        }
        if ($no != "") {
            $badge = '<div class="text-danger  text-align-right bg-light-danger badge p-1 mt-2 fs-2 bg-light-danger"><b>' . $no . '</b></div>';
        }
        echo '<li>
            <a href="index?p=chat&id=' . $row['ID'] . '"
                class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user ' . $active . ' w-100"
                id="chat_user_' . $row['ID'] . '" data-user-id="' . $row['ID'] . '">
                <div class="d-flex align-items-center">
                    <span class="position-relative">
                        <img src="' . $this->get_profile_icon_link($id, $what) . '" alt="user1" width="40" height="40" class="rounded-circle" />
                        
                    </span>
                    <div class="ms-3 d-inline-block w-100">
                        <h6 class="mb-1 chat-title ' . $nameclass . '" data-username="James Anderson">' . $this->short_text($this->get_name($id, $what), 23) . '</h6>
                        <span class="fs-3 text-truncate ' . $nameclass . ' text-body-color d-block">' . $this->short_text($this->last_message($row['ID'], $userID, $row['is_group']), 20) . '</span>
                    </div>
                    </div>
                    ' . $badge . '
            </a>
        </li>';
    }
}
