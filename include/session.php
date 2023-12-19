<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// if($_SERVER[‘HTTPS’] != "on") {
 $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// header("Location:$redirect");
// }
// if (!isset($_SESSION['userSession'])) {
//     $_SESSION['urlgoto'] = $redirect;
//     header("location: login?urlgoto=$redirect");
// }
    
    if(isset($_GET['logout']) && isset($_COOKIE['userSession'])) {
        unset($_COOKIE['userSession']);
        setcookie('userSession', "", -1, '/');
        echo '<script>window.location.href = "login.php";</script>';
        exit();
    }
    
    if(isset($_COOKIE['userSession']) && $_COOKIE['userSession'] != ""){
        $userID = $_COOKIE['userSession'];
        // exit();

    }else{
        // session_destroy();
        $_SESSION['urlgoto'] = $redirect;
        // echo '<script>window.location.href = "login.php?urlgoto='.$redirect.'";</script>';
        echo '<script>window.location.href = "index?logout=";</script>';
        exit();
    }

   
?>