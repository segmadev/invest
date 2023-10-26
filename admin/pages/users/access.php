<?php 
    if(isset($_GET['id'])) {
        unset($_SESSION['userSession']);
        unset($_SESSION['newuser']);
        $id = htmlspecialchars($_GET['id']);
        $_SESSION['userSession'] = $id;
        $_SESSION['anonymous'] = "admin";
        $d->loadpage("../");
    }
?>