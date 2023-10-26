<?php
require_once "../consts/user.php";
require_once "../functions/users.php";
require_once "functions/users.php";

$u = new users;
if (isset($_GET['action'])) {
    $route = htmlspecialchars($_GET['action']);
}

if($action == "list" || $action == "table") {
    $users = $d->getall("users", fetch: "moredetails");
}