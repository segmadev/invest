<?php 
    require_once 'consts/Regex.php';
    require_once 'admin/include/database.php';
    $d = new database;
    require_once "consts/general.php";
    require_once 'content/content.php';
    $c = new content;
    require_once 'functions/autorize.php'; 
    require_once 'consts/user.php';
    $a = new autorize;    
?>