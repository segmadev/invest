<?php
    if (isset($_GET['id'])) {
        unset($_SESSION['userSession']);
        unset($_SESSION['newuser']);
        $id = htmlspecialchars($_GET['id']);
        // set cookies and session for user so adim can access account.
        unset($_COOKIE['userSession']);
        setcookie("userSession", $id, time() + 60 * 2, "/", "", true, true);
        $_SESSION['userSession'] = $id;
        $_SESSION['anonymous'] = "admin";
        $d->loadpage("../");
    }
