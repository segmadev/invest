<?php 
$referral_from = [
    "ID"=>["input_type"=>"number"],
    "planID"=>["type"=>"select", "options"=>$d->options_list($d->getall("plans", fetch: "moredetails"), value: ["min_amount","max_amount","plan_name"])],
    "plan_amount"=>["input_type"=>"number", "unique"=>"planID", "description"=>"Amount for plan invesment for the referral."],
    "no_of_users"=>["input_type"=>"number", "unique"=>"planID"],
    "percentage_return_on_deposit"=>["input_type"=>"number", "unique"=>"planID", 'description'=>'The (%) user will get on referral\'s first deposit.'],
    "status"=>["placeholder"=>"Select Status","atb"=>"data-flag=\"ad\"", "options"=>["active"=>"Active", "disable"=>"Disable"],"type"=>"select"],
    // "input_data"=>[]
];
$d->create_table("referral_programs", $referral_from);
if(!isset($ref_p_s['ID'])){
    unset($referral_from["ID"]);
}else{
    $referral_from["ID"]["input_type"] = "hidden";
}
$referral_from["input_data"] = $ref_p_s;