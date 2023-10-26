<?php 
    if($action == "list") {
        $deposit = $d->getall("deposit", "userID = ? order by date DESC", [$userID], fetch: "moredetails");
        $rejected = $de->get_total_pending($userID, "rejected");
        $Approved = $de->get_total_pending($userID, "Approved");
        $pending = $de->get_total_pending($userID, "pending");
    }
?>