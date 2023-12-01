<?php 
$test_from = [
    "upload_image"=>["input_type"=>"file", "path"=>"upload/", "file_name"=>"profile_".$userID, "formart"=>["pdf", "doc", "php"]]
]
?>
<form action="" id="foo">
    <?= $c->create_form($test_from); ?>
    <input type="hidden" name="upload_image">
    <input type="hidden" name="page"  value="settings">
    <div id="custommessage"></div>
    <input type="submit" value="Upload" class="btn btn-primary">
</form>