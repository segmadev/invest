<?php 
    require_once "functions/plans.php";
    $p = new plans;
    require_once "pages/settings/ini.php";
    if(isset($action) && $action == "list") {
        $compound_profitss = $d->getall("compound_profits", fetch: "moredetails");
    }

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        $compound_profits = $d->getall("compound_profits", "ID = ?", [$id]);
    }
    