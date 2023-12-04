<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $trade_table_title = "Trade History";
  $trade_table_des = "Trades taken for this investment.";
  $id = htmlspecialchars($_GET['id']);
  // echo $i->total_daily_profit($id, date("Y-m-d"));
  $invest = $d->getall("investment", "ID = ? and userID = ?", [$id, $userID]);
  if (is_array($invest)) {
    // if(isset($_GET['no']) && $_GET['no'])
    $no = htmlspecialchars($_GET['start'] ?? 0);
    $trades = $d->getall("trades", "investmentID = ? and status = ? order by trade_time DESC LIMIT $no, 20", [$id, "closed"], fetch: "moredetails");
  }
}

if ($action == "list") {
  $trade_table_title = "Recent Trades";
  $trade_table_des = "Some recent trades taken. <a href='index?p=investment&action=trades' class='btn text-primary'>View All Trades</a>";
  $trades = $d->getall("trades", "userID = ? and status = ?  order by trade_time DESC limit 10", [$userID, "closed"], fetch: "moredetails");
  $invests = $d->getall("investment", "userID = ? order by date DESC", [$userID], fetch: "moredetails");
}
require_once "pages/investment/ini-trades.php";
$script[] = "fetcher";
// $i->apply_daily_compound_profits();
// $i->auto_genarate_trading_days();
// $i->take_pending_trades();
// var_dump($user_data);
    // $total_sum = $d->getall("investment", "userID = ?", ["oo"], "SUM(amount) as total_amount");


    // if($trades->rowCount() > 0) {
    //     foreach ($trades as $row) {
    //         $candles = json_decode($row['trade_candles']);
    //         $chart_info = [];
    //         $no =  count($candles) - 1;
    //         $open = $candles[0][0];
    //         $open = $candles[$no][0];
    //         $i = 0;
    //         foreach($candles as $candle) {
    //             if($i == 0) {
    //                 $chart_info[] = [$candle[0], $candle[3]];
    //                 continue ;
    //             }

    //             if($i == $no) {
    //                 $chart_info[] = [$candle[6], $candle[2]];
    //                 continue ;
    //             }
    //             $chart_info[] = [$candle[0], $candle[1]];
    //         }
    //         // var_dump(json_encode($chart_info));
    //         // echo $row['ID']."<br>";
    //         // echo date("Y-m-d H:i:s", '1633417200000' / 1000)."<br>";
    //         // echo date("Y-m-d H:i:s", '1693597137');
    //         // echo "<hr>";
    //     }
    // }