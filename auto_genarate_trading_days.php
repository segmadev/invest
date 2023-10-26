<?php 
    require_once "include/cron-ini.php";
    $i = new investment;
    $i->auto_genarate_trading_days();
?>