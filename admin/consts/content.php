<?php 
    $banner_path = "../assets/images/banners/";
    $content_home_header =  [
        "home_header_sub_title"=>["global_class"=>"w-100"],
        "home_header_title"=>["global_class"=>"w-100", "type"=>"textarea"],
        "home_header_short_description"=>["global_class"=>"w-100", "type"=>"textarea"],
        "home_header_btn_name"=>[],
        "home_header_btn_url"=>[],
        "home_header_img"=>["input_type"=>"file", "is_required"=>false, 'path'=>"$banner_path"],
    ];
    $content_home_header['input_data'] = $s->getdata($content_home_header, "content");  
    // $d->create_settings($home_header, "content");

    
    // $d->create_table("key_features", $key_features);
?>