<?php
$data = ["ID"=>uniqid(), "max_amount"=>0];
if(isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $data = $d->getall("plans", "ID = ?", [$id], fetch: "details");
}
require_once "consts/plans.php";
require_once "functions/plans.php";
$p = new plans;