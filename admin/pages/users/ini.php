<?php
require_once "../consts/user.php";
require_once "../functions/users.php";
require_once "functions/users.php";

$u = new users;
if (isset($_GET['action'])) {
    $route = htmlspecialchars($_GET['action']);
}

if($action == "list" || $action == "table") {
    $acct_type = htmlspecialchars($_GET["acct_type"] ?? "all");
    if($acct_type == "all") {
        $users = $d->getall("users", fetch: "moredetails");
    }else{
        $users = $d->getall("users", "acct_type = ?", [$acct_type], fetch: "moredetails");
    }
}

if(isset($_GET['create_bot_users'])) {
    $u->genarete_bot_users(htmlspecialchars($_GET['no'] ?? 100));
}

