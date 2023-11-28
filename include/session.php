<?php 
// error_reporting(0);
// ini_set('display_errors', 0);
// if($_SERVER[‘HTTPS’] != "on") {
 $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// header("Location:$redirect");
// }
// if (!isset($_SESSION['userSession'])) {
//     $_SESSION['urlgoto'] = $redirect;
//     header("location: login?urlgoto=$redirect");
// }
    
    if(isset($_GET['logout'])) {
        session_destroy();
        unset($_COOKIE['userSession']);
        header("location: login.php");
    }
    
    if(isset($_COOKIE['userSession'])){
        $userID = $_COOKIE['userSession'];
    }else{
        // session_destroy();
        $_SESSION['urlgoto'] = $redirect;
        echo '<script>window.location.href = "login.php?urlgoto='.$redirect.'";</script>';
        exit();
    }

   
?>