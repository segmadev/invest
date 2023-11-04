<?php

if ($action == "trades" || $page == "dashboard") {
  $type = "My Report";
  if (isset($_GET['type'])) {
    $type = htmlspecialchars($_GET['type']);
  }

  if (isset($_GET['date']) && $_GET['date'] != "") {
    $date = htmlspecialchars($_GET['date']);
  }



  $trade_table_title = "All Trades";
  $trade_table_des = "List of all trades taken.";
  $tradeUserID = htmlspecialchars($_GET["userID"] ??  $userID);
  $get_report = $i->get_trade_report($tradeUserID, $date ?? "", $type ?? "", start: htmlspecialchars($_GET["start"] ?? 0));
  foreach ($get_report as $key => $value) {
    ${$key} = $value;
  }
}

if (isset($_GET['tradeID'])) {
  $trade_table_title = "All Trades";
  $trade_table_des = "List of all trades taken.";
  $tradeid = htmlspecialchars($_GET['tradeID']);
  $trade = $d->getall("trades", "ID = ? and status = ? order by trade_time DESC", [$tradeid, "closed"], fetch: "details");
  $trades = $d->getall("trades", "ID = ? and status = ? order by trade_time DESC", [$tradeid, "closed"], fetch: "moredetails");
}

// $i->daily_report_notification($userID);
