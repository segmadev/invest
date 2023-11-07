<?php 
$script[] = "chat";
$from_generate = [
    "startDate"=>["input_type"=>"datetime-local"],
    "endDate"=>["input_type"=>"datetime-local"],
    "groupID"=>["type"=>"select"],
    "message_file"=>["input_type"=>"file", "path"=>"upload/temp/", "file_name"=>"message", "formart"=>["json"], "global_class"=>"w-100 h-10"],
];

$from_generate['groupID']['options'] = $d->options_list($d->getall("groups", fetch: "moredetails"));
require_once "../functions/chat.php";
$ch = new chat;
require_once "../pages/chat/ini.php";
require_once "../consts/chat.php";
// exit();
?>