<?php 
    require_once "include/cron-ini.php";
    $i = new investment;
    if(isset($_GET['update'])) {
        $i->change_trade_date();
        exit;
    }

    if(isset($_GET['type'])) {
        $i->auto_genarate_trading_days(htmlspecialchars($_GET['type'] ?? null));   
    }
    
?>