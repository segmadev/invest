<?php 
    require_once "include/cron-ini.php";
    $i = new investment;
    if(isset($_GET['update'])) {
        $i->change_trade_date();
        exit;
    }
    $i->auto_genarate_trading_days();
    
?>