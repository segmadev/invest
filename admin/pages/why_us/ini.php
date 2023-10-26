<?php 
    if(isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        $details = $d->getall("why_us", "ID = ?", [$id]);
    }

    if($action == "list") {
        $why_uss = $d->getall("why_us", fetch:  "moredetails");
    }
    require_once "pages/content/ini.php";
