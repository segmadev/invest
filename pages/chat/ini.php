<?php
$script[] = "chat";
$script[] = "sweetalert";
$chat_form = [
    "user1" => ["unique" => "user2"],
    "user2" => ["unique" => "user1"],
    "is_group" => [],
];
if (isset($_SESSION['adminSession']) && !isset($_COOKIE['userSession'])) {
    $userID =  "admin";
}
$u->create_default_group_chat($chat_form, $userID);
$u->insert_default_message($userID, "2");
if (isset($_GET['id'])) {
    $chatID = htmlspecialchars($_GET['id']);
    $chat =  $ch->get_chat($chatID, $userID);
    $messages = $ch->get_all_messages($chatID, $userID, start: "first",   limit: "20", chat: $chat, orderby: "time_sent ASC");
    $uID = $chat['user1'];
    $what = "users";
    if ($chat['user1'] == $userID) {
        $uID = $chat['user2'];
    }

    if ($chat['is_group'] == "yes") {
        $what = "groups";
    }
    // read all this chat messages for this current user
    // this should have it's own passer totally
    $ch->read_all_message($userID, $chatID);
}
// select * from chat join ( select * from message order by date desc ) as recent_message on chat.ID = recent_message.chatID;
$chats = [];
// var_dump($ch->get_unseen_message($userID, $chatID));
if (isset($_GET['genrate_chat'])) {
    require_once "pages/chat/chat-bot.php";
}
