<?php 

if ($action == "trades" || $page == "dashboard") {
    $more = "";
    $more_value = "";

    $type = "";
    $userinfo = "userID = ? and ";
    $uid = $userID;
    if(isset($_GET['type'])) {
        $type = htmlspecialchars($_GET['type']);
        if($type == "global") {
          $userinfo = "";
          $uid = "";
        }
    }

    if(isset($_GET['date']) && $_GET['date'] != "") {
      $date = htmlspecialchars($_GET['date']);
      $more = "trade_date = ? and ";
      $more_value = $date;
    }
  
  
  
    $trade_table_title = "All Trades";
    $trade_table_des = "List of all trades taken.";
    $trades = $d->getall("trades", "$userinfo $more  status = ?  order by trade_time DESC", array_values(array_filter([$uid, $more_value, "closed"], 'strlen')), fetch: "moredetails");
    $lost = $d->getall("trades", "$userinfo  intrest_amount < ? and $more  status = ?  order by trade_time DESC", array_values(array_filter([$uid, 0, $more_value, "closed"], 'strlen')), "SUM(intrest_amount) as amount");
    $profit = $d->getall("trades", "$userinfo  intrest_amount > ? and $more  status = ?  order by trade_time DESC", array_values(array_filter([$uid, 0, $more_value, "closed"], 'strlen')), "SUM(intrest_amount) as amount");
    $trade_no = $trades->rowCount();
  
  
  
  }
  
  if(isset($_GET['tradeID'])) {
    $trade_table_title = "All Trades";
    $trade_table_des = "List of all trades taken.";
    $tradeid = htmlspecialchars($_GET['tradeID']);
    $trade = $d->getall("trades", "ID = ? and status = ? order by trade_time DESC", [$tradeid, "closed"], fetch: "details");
    $trades = $d->getall("trades", "ID = ? and status = ? order by trade_time DESC", [$tradeid, "closed"], fetch: "moredetails");
  }
