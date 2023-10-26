<?php 
    require_once "functions/users.php";
    require_once "functions/investment.php";
    $i = new investment;
    if(isset($_GET['investID'])) {
        $investID = htmlspecialchars($_GET['investID']);
    }