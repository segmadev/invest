<?php
require_once "../consts/user.php";
require_once "../functions/users.php";
require_once "functions/users.php";
require_once "../functions/investment.php";
$i = new investment;
$u = new users;
$invests  =  $d->getall("investment", "status != ? order by date DESC", [""], fetch: "moredetails");
?>