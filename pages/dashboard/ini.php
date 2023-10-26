<?php
    require_once "functions/users.php"; 
    require_once "functions/investment.php"; 
    require_once "functions/deposit.php"; 
    $u = new user;
    $i =  new investment;
    $de =  new deposit;
    $_GET['date'] = date("Y-m-d");
    require_once "pages/investment/ini-trades.php";
    $trade_table_title = "";
    $trade_table_des = "<a href='index?p=investment&action=trades' class='btn btn-outline-primary'>See all Trades</a>";
    $trades = $d->getall("trades", "userID = ? and status = ?  order by trade_time DESC limit 5", [$userID, "closed"], fetch: "moredetails");
    $invests = $d->getall("investment", "userID = ? order by date DESC", [$userID], fetch: "moredetails");  
    $deposit = $d->getall("deposit", "userID = ? order by date DESC LIMIT 5", [$userID], fetch: "moredetails");
    $chat_trades = [];
    // var_dump($users_data);