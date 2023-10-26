<?php
$why_us = [
    "ID"=>["input_type"=>"hidden", "is_required"=>false],
    "image"=>["input_type"=>"file", "file_name"=>uniqid(), "path"=>"../assets/images/banners/"],
    "title"=>["unique"=>""],
    "description"=>["type"=>"textarea"],
    "link"=>["is_required"=>false],
];
if(isset($details)) {
    $why_us['input_data'] = $details;
    if(isset($why_us['image']['file_name']) && isset($why_us['input_data']['image']))  {
        $why_us['image']['file_name'] = $why_us['input_data']['image'];
    }
}
// $d->create_table("why_us", $why_us);
?>