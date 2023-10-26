<?php 
    $promo_form = [
        "rate"=>["global_class"=>"w-100", "input_type"=>"number", "description"=>"What is the rate in which you want to increase profit <b class='text-primary'>e.g(2)X</b>"],
        "purchase_price"=>["global_class"=>"w-100", "unique"=>"rate", "input_type"=>"number"],
        "assigned_users"=>["is_required"=>false, "atb"=>"multiple='multiple'", "class"=>"select2", "global_class"=>"w-100", "type"=>"select"],
    ];