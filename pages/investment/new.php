<?php
$script[] = "modal";
if (isset($_GET['planid']) && $_GET['planid'] != "") {
    $plan = $d->getall("plans", "ID = ?", [htmlspecialchars($_GET['planid'])]);
    if (!is_array($plan)) {
        require_once "pages/investment/plan-list.php";
    } else {
        require_once "pages/investment/create.php";
    }
} else {
        require_once "pages/investment/plan-list.php";
}
 