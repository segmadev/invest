
<div class="row">
<div class="col-md-4 m-0">
        <?php echo $u->show_balance($user_data); ?>
    </div>
    <div class="col-md-8">
        <form id="foo2" class='card p-3 shadow-lg' onsubmit="return false;">
            <!-- <h5 class='mb-3'>Transfer to trading account</h5> -->
            <?php
            echo $c->create_form($tranfer_from) ?>
            <input type="hidden" name="page" value="user">
            <input type="hidden" name="transfer_funds">
            <div id="custommessage"></div>
            <input type="submit" id="Button" onclick="submitform();" class="btn btn-primary col-6" value="Transfer Funds">
        </form>
    </div>
</div>