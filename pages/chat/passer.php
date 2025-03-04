<?php
require_once "pages/chat/video-chat.php";
if (isset($_POST['send_message']) && !isset($_GET['video'])) {
    $send = send_message($ch, $message_form);
    if ($send) {
        $return = [
            "function" => ["onset_chat", "data" => ["message-input-box", $send]]
        ];
        echo json_encode($return);
    }
}

function send_message($ch, $message_form) {
    return $ch->new_message($message_form);
}
// delete a message
if(isset($_POST['delete_message'])) {
    $message_id = htmlspecialchars($_POST['delete_message']);
    echo $ch->delete_chat($message_id, $userID);
}

    // get users in groups
    if(isset($_POST['get_group_users'])) {
        $groupID = htmlspecialchars($_POST['get_group_users']);
        $start = htmlspecialchars($_POST['start']);
        $limit = htmlspecialchars($_POST['limit']);
        echo $ch->get_group_users($groupID, $start, $limit);
    }
    if(isset($_POST['loadmedia']) && !empty($_POST['loadmedia'])) {
        $chatID = htmlspecialchars($_POST['loadmedia']);
        
    }
    if(isset($_POST['update_last_seen'])) {
        $update_last_seen = $ch->update_last_seen($userID, time()); 
    }
    if(isset($_POST['get_user_chat_list'])) {
        // $chat_lists =  $ch->list_chat_users($ch->get_group($userID, "2"), $userID);
         $chats = $ch->get_chats($userID, htmlspecialchars($_POST['time'] ?? 0)); 
        //  var_dump($chats->rowCount());
        $chat_lists = $ch->list_chat_users($chats, $userID);
        echo $chat_lists;
    }
    if(isset($_POST['get_last_seen'])) {
        echo $ch->get_last_seen(htmlspecialchars($_POST['get_last_seen']));
    }
    // if(isset($_POST['get_chat']) && isset($_POST['lastchat'])) {
    //     $lastchat = htmlspecialchars($_POST['lastchat']);
    //     $chatID =  htmlspecialchars($_POST['chatID']);
    //     $limit = htmlspecialchars($_POST['get_chat']);
    //     $messages =  $ch->get_all_messages($chatID, $userID, $lastchat, $limit);
    
    //         if (isset($messages) && $messages->rowCount()  > 0) {
    //             foreach ($messages as $row) {
    //                 echo $ch->display_message($row, $userID);
    //             }
    //         }else {
    //             echo "null";   
    //         }
        
    // }
    
        // get old messages
        echo $ch->get_old_messages($userID);
        // get recent messages
        echo $ch->get_new_messages($userID);
?>