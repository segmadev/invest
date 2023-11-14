<div class="d-felx row">
    <div class="col-md-8 col-12">
        <div class="card p-4">
            <h6>Activate Promo</h6>
            <form action="" id="foo">
                <?php echo $c->create_form($assign_promo); ?>
                <input type="hidden" name="new_promo">
                <input type="hidden" name="page" value="promo">
                <div id="custommessage"></div>
                <input type="submit"class="btn btn-primary" value="Activate Promo">
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <?php echo $u->show_balance($user_data); ?>
    </div>
</div>