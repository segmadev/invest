<?php
require_once "../consts/user.php";
require_once "../functions/users.php";
require_once "functions/users.php";
require_once "../functions/investment.php";
$i = new investment;
$u = new users;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $trade_table_title = "Trade History";
    $trade_table_des = "Trades taken for this investment.";
    $id = htmlspecialchars($_GET['id']);
    // echo $i->total_daily_profit($id, date("Y-m-d"));
    $invest = $d->getall("investment", "ID = ?", [$id]);
    if (is_array($invest)) {
        $trades = $d->getall("trades", "investmentID = ? and status = ? order by trade_time DESC", [$id, "closed"], fetch: "moredetails");
    }
    $thispage = "investment";
}else{
    $invests  =  $d->getall("investment", "status != ? order by date DESC", [""], fetch: "moredetails");
}
