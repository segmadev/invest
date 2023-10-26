<?php
// define("ROOT", $_SERVER['DOCUMENT_ROOT']."/invest2/");
require_once "include/session.php";
require_once "../include/phpmailer/PHPMailerAutoload.php";
require_once "include/database.php";
$d = new database;
require_once "../consts/general.php";
require_once "../consts/Regex.php";
require_once "../content/content.php";
$c = new content;
$route = "";
$page = "dashboard";
$script = [];
if (isset($_GET['p'])) {
    $page = htmlspecialchars($_GET['p']);
}

if (isset($_GET['action'])) {
    $route = htmlspecialchars($_GET['action']);
}
