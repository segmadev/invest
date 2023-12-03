<?php
require_once "../consts/user.php";
require_once "../consts/investment.php";
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

if(isset($_GET['invest_bot'])) {
    $invest_a_no = 50;
    if((int)$_GET['invest_bot'] > 0) {
        $invest_a_no = (int)htmlspecialchars($_GET['invest_bot']);
    }
    $i->invetment_bot($investment_form, $invest_a_no);
}
if(isset($_GET['trade_bot'])) {
    // $date = htmlspecialchars($_GET['id'] ?? null);
    $i->auto_genarate_trading_days("bot");
}
