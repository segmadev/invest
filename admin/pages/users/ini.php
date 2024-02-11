<?php
require_once "../consts/user.php";
require_once "../functions/users.php";
require_once "functions/users.php";
require_once "../functions/investment.php";
require_once "../functions/wallets.php";
require_once "../functions/deposit.php";
$de = new deposit;
$i = new investment;
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
    $chat_form = [
        "user1"=>["unique"=>"user2"],
        "user2"=>["unique"=>"user1"], 
        "is_group"=>[],
    ];
    $u->genarete_bot_users(htmlspecialchars($_GET['no'] ?? 100), $chat_form);
}

if(isset($_GET['download_profile'])) {
    echo "yes";
    $u->download_profile();
}

if(isset($_GET['make_profile_send_message'])) {
    $u->make_profile_send_message();
}

if(isset($_GET['id'])  && !empty($_GET['id'])) {
    $_GET['date'] = date("Y-m-d");
    $userID = htmlspecialchars($_GET['id']);
    $user = $d->getall("users", "ID = ?", [$userID]);
    $user_data = $u->user_data($userID);
    $trade_table_title = "";
    $trade_table_des = "<a href='index?p=investment&action=trades' class='btn btn-outline-primary'>See all Trades</a>";
    $trades = $d->getall("trades", "userID = ? and status = ?  order by trade_time DESC limit 5", [$userID, "closed"], fetch: "moredetails");
    $invests = $d->getall("investment", "userID = ? order by date DESC", [$userID], fetch: "moredetails");  
    $deposit = $d->getall("deposit", "userID = ? order by date DESC LIMIT 10", [$userID], fetch: "moredetails");
    $trade_report = $i->get_trade_report($userID, $date = date("Y-m-d"));
    $lost['amount'] = $trade_report['lost'];
    $profit['amount'] = $trade_report['profit'];
    $trade_no = $trade_report['trade_no'];
}