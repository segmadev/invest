<?php
    require_once "../functions/users.php";
    require_once "functions/users.php";
    require_once "../functions/wallets.php";
    $wa = new wallets;
    $u = new users;

    if(isset($_GET['id'])) {
        $details = $d->getall("withdraw", "ID = ?", [htmlspecialchars($_GET['id'])]);
    }else{
        $withdraw = $d->getall("withdraw", fetch:"moredetails");
    }

