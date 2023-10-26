<?php 
    // $logo_path = ROOTFILE."assets/images/logos/";
    $logo_path = "../assets/images/logos/";
    $logo_from = [
        "light_logo"=>["input_type"=>"file", "is_required"=>false, "path"=>$logo_path],
        "dark_logo"=>["input_type"=>"file", "is_required"=>false, "path"=>$logo_path],
        "favicon"=>["input_type"=>"file", "is_required"=>false, "path"=>$logo_path],
    ];
    $logo_from['input_data'] = $s->getdata($logo_from);
    $settings_form = [
        "company_name"=>[],
        "website_url"=>[],
        "support_email"=>["input_type"=>"email"],
        "phone_number"=>["input_ype"=>"tel"],
        "address"=>["type"=>"textarea"],
        "default_currency"=>[],
        "trade_coins"=>["description"=>"<b class='text-danger'>Note:</b> only write the coin symbol not the coin full name and please seprate each coin with a comma(,).", "placeholder"=>"ETH, CYBER, NMR, AGLD, BTC, XRP"],
        "trade_stocks"=>["description"=>"<b class='text-danger'>Note:</b> only write the stock symbol not the stock full name and please seprate each stock with a comma(,).", "placeholder"=>"APPL", ],
        "welcome_note"=>["type"=>"textarea", "description"=>"Welcome note will display to new users who is logs into dashboard for the first time.", "global_class"=>"w-100"],
        "live_chat_widget"=>["type"=>"textarea", "global_class"=>"w-100"],
    ];

    $settings_form['input_data'] = $s->getdata($settings_form);
    // var_dump($settings_form);
    $settings_deposit_form = [
        "min_deposit"=>["input_type"=>"number"],
        "max_deposit"=>["input_type"=>"number", "is_required"=>false],
        "send_email_on_user_deposit"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "send_email_to_user_deposit_approved"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "send_email_to_user_deposit_rejected"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "user_deposit_live_notification"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "robot_deposit_live_notification"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
    ];
    $settings_deposit_form['input_data'] = $s->getdata($settings_deposit_form);

    $settings_withdraw_form = [
        "min_withdraw"=>["input_type"=>"number"],
        "max_withdraw"=>["input_type"=>"number", "is_required"=>false],
        "send_email_on_user_withdraw"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "send_email_to_user_withdraw_approval"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "send_email_to_user_withdraw_rejection"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "user_withdraw_live_notification"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "robot_withdraw_live_notification"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "contact_suuport_on_first_withdraw"=>["options"=>["yes"=>"Yes", "no"=>"No"],"type"=>"select"],
        "first_withdraw_after"=>["description"=>"value in <b class='text-primary'>days</b>"],
        "subsequent_withdraw_after"=>["description"=>"value in <b class='text-primary'>days</b>"]
    ];
    
    $settings_withdraw_form['input_data'] = $s->getdata($settings_withdraw_form);
    
    $term_and_policy_condition = [
        "terms_and_conditions"=>["type"=>"textarea", "id"=>"richtext", "global_class"=>"col-md-12"],
        "policy"=>["type"=>"textarea", "id"=>"richtext2", "global_class"=>"col-md-12"],
    ];
    $term_and_policy_condition['input_data'] = $s->getdata($term_and_policy_condition);
    
    $compound_profits_details = [
        "compound_profits_short_title"=>[""],
        "compound_profits_details"=>["type"=>"textarea", "id"=>"richtext", "global_class"=>"col-md-12"],
    ];
    $compound_profits_details['input_data'] = $s->getdata($compound_profits_details);

    