<?php 
// error_reporting(0);
// ini_set('display_errors', 0);
// if($_SERVER[‘HTTPS’] != "on") {
// $redirect= "https://".$_SERVER[‘HTTP_HOST’].$_SERVER[‘REQUEST_URI’];
// header("Location:$redirect");
// }
    if(!isset($_SESSION['adminSession']) ){
        header('location: login'); 
    }
    
    if(isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['adminSession']);
        header("location: login");
    }
    
    if(isset($_SESSION['adminSession'])){
        $adminID = $_SESSION['adminSession'];
    }else{
        session_destroy();
        header("location: login");
    }
?>