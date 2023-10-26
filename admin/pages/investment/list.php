<?php 
    if($invests->rowCount() < 1) {
        $c->empty_page("No Investment found.");
    }else{
        // table goes in here
        require_once "pages/investment/table.php";
    }
?>