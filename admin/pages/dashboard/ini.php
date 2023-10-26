<?php
require_once "pages/users/ini.php";
require_once "pages/deposit/ini.php";
require_once "pages/withdraw/ini.php";
// Recent users
$recent_users = $d->getall("users", "ID != ? ORDER BY date DESC LIMIT 10", [""], fetch: "moredetails");
// trades
$recent_trades = $d->getall("trades", "ID != ? ORDER BY date DESC LIMIT 10", [""], fetch: "moredetails");
// investment
$recent_invest = $d->getall("investment", "ID != ? ORDER BY date DESC LIMIT 5", [""], fetch: "moredetails");

$users_data = $u->users_data();

$deposit = $d->getall("deposit", "status = ?", ["pending"], fetch: "moredetails");
$withdraw = $d->getall("withdraw", "LIMIT 5", fetch: "moredetails");
$trade_table_title = "Recent Trades";
$trade_table_des = "List of all recent trades taken.";
$trades = $d->getall("trades", "status = ?  order by trade_time DESC LIMIT 10", ["closed"], fetch: "moredetails");
  
// var_dump($users_data);
// no of trades taken today
// total profit  made today
// no of users
// number of investment
// total amount invest
