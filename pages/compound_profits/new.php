<div class="d-felx row">
    <div class="col-md-8 col-12">
        <div class="card p-4">
            <h6>Activate Compound profits for:</h6>
            <form action="" id="foo">
                <?php echo $c->create_form($compound_profits_form); ?>
                <input type="hidden" name="investmentID" value="<?= $investID ?>">
                <input type="hidden" name="new_compound_profits">
                <input type="hidden" name="page" value="compound_profits">
                <dic id="custommessage"></dic>
                <input type="submit"class="btn btn-primary" value="Activate compound profit">
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <?php echo $u->show_balance($user_data); ?>
    </div>
</div>