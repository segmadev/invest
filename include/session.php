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
        unset($_SESSION['userSession']);
        header("location: login.php");
    }
    
    if(isset($_SESSION['userSession'])){
        $userID = $_SESSION['userSession'];
    }else{
        session_destroy();
        $_SESSION['urlgoto'] = $redirect;
        echo '<script>window.location.href = "'.$redirect.'";</script>';
        exit();
    }

   
?>