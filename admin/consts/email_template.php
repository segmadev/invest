<?php 
    if(!isset($template)) {
        $template = [];
    }
    $email_template_from = [
        "ID"=>['input_type'=>'hidden'],
        "name"=>["atb"=>"disabled",],
        "template"=>["type"=>"textarea", "id"=>"richtext", "global_class"=>"col-md-12"],
        "input_data"=>$template,
    ];