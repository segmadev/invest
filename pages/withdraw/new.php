<div class="col-12 row">
    <div class="col-12 col-md-8">
    <div class="card p-3">
        <div class="card-header">
            <h5>Make Withdrawal.</h5>
        </div>
        <form class="card-body" id="foo">
            <?= $c->create_form($withdraw_form); ?>
            <input type="hidden" name="page" value="withdraw">
            <input type="hidden" name="new_withdraw">
            <div id="custommessage"></div>
            <button type="submit" class="btn btn-primary">Make Withdrawal</button>
        </form>
    </div>
    </div>
    <div class="col-12 col-md-4">
    <?php echo $u->show_balance($user_data); ?>
    </div>
</div>