<?php
require_once "../content/textarea.php"; 
if ($compound_profitss->rowCount() == 0) {
    echo $c->empty_page("You have no compound_profits created yet.", "<a href='index?p=compound_profits&action=new' class='btn btn-primary'>Create Compound profits</a>");
} else {
    require_once "pages/compound_profits/table.php";
}
?>
<div class="card">
    <div class="card-header">
        <h5>Compound profits</h5>
        <p>This infomation will be shown to investors at the point of activating the compound profit.</p>
    </div>
    <form action="" id="foo" class="card-body">
        <?= $c->create_form($compound_profits_details); ?>
        <input type="hidden" name="updatesettings" value="" id="">
        <input type="hidden" name="page" value="settings" id="">
        <input type="hidden" name="settings" value="compound_profits">
        <div id="custommessage"></div>
        <!-- <input type="hidden" name="page" value='settings'> -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>