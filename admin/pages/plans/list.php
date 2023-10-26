<?php 
    $script[] = "sweetalert";
    $plans = $p->getallplans();
    if($plans != "") {
        require_once "pages/plans/table.php";
    }