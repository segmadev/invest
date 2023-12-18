<?php 
$ref_p = $d->getall("referral_programs", fetch: "moredetails");
$ref_p_s = [];
if(isset($_GET['id']) && $_GET['id'] != "") {
    $ref_p_s = $d->getall("referral_programs", "ID = ?", [htmlspecialchars($_GET['id'])]);
}