<?php
$user_form = [
    "ID" => ["input_type"=>"hidden", "is_required"=>false],
    "first_name" => [],
    "last_name" => [],
    "email" => ["input_type"=>"email"],
    "phone_number" => ["input_type"=>"number"],
    "gender" => ["placeholder" => "Select your gender", "is_required" => true, "options" => ["Male" => "Male", "Female" => "Female"], "type" => "select"],
    "password" => ["input_type"=>"password"],
    "confrim_password" => ["input_type"=>"password"],
    "Referral_code" => ["placeholder" => "UX920", "is_required" => false,],  
    // "input_data" => ["full_name" => "seriki gbenga", "gender"=>"Male"],
];
