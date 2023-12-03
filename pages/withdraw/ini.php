<?php
    require_once "include/phpmailer/PHPMailerAutoload.php";
    require_once "functions/wallets.php";
    $wa = new wallets;
    $withdraw = $d->getall("withdraw", "userID = ? order by date DESC", [$userID], fetch:"moredetails");
