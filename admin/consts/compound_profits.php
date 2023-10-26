<?php 
    $compound_profits_form = [
        "type"=>["global_class"=>"w-100", "type"=>"select", "options"=>["daily"=>"Daily", "weekly"=>"Weekly"]],
        "purchase_price"=>["global_class"=>"w-100", "unique"=>"type", "input_type"=>"number"],
        "bonus_price"=>["global_class"=>"w-100", "input_type"=>"number"],
        "assigned_users"=>["is_required"=>false, "atb"=>"multiple='multiple'", "class"=>"select2", "global_class"=>"w-100", "type"=>"select"],
    ];