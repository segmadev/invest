<?php
session_start();
if (isset($_COOKIE['userSession']) && $_COOKIE['userSession'] != "") {
    $userID = $_COOKIE['userSession'];
} else {
    // exit
    return false;
}
require_once "consts/main.php";
require_once "admin/include/database.php";
require_once "functions/notifications.php";
require_once "functions/users.php";
require_once "functions/chat.php";
$d = new database;
$u = new user;
$ch = new chat;
$imgpath =  "assets/images/chat/";
$message_form = [
    "chatID" => ["input_type" => "hidden"],
    "senderID" => ["title" => "Select sender", "input_type" => "hidden", "global_class" => "w-5"],
    "receiverID" => ["input_type" => "hidden"],
    "message" => ["input_type" => "text", "title" => "", "class" => "form-control message-type-box text-muted border-0 p-0 ms-2", "placeholder" => "Type Message"],
    "upload" => ["input_type" => "file", "file_name" => uniqid("M-"), "path" => $imgpath, "is_required" => false],
    "is_group" => ["input_type" => "hidden"],
    "reply_to" => ["input_type" => "hidden", "is_required" => false],

];
require_once "pages/chat/passer.php";