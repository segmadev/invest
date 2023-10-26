<div class="d-flex justify-content-center">
    <div class="col-12 col-md-10 p-3 card">
        <?= $c->plan_list($plan); ?>
        <div class="m-2">
            <a href="?p=investment&action=new">Change plan</a>
            <form action="" id="foo" class='mt-3'>
                <?php 
                    $investment_form['input_data'] = ["planID"=>$plan['ID']];
                    echo $c->create_form($investment_form);
                    ?>
                    <input type="hidden" name="newinvestment" value="">
                    <input type="hidden" name="page" value="investment">
                <!-- <p><?= $c->terms_message(); ?></p> -->
                <div id="custommessage"></div>
                <button type="submit" class="btn btn-primary col-12 col-md-2">Create A Plan</button>
            </form>
            <?php if($plan['plan_instructions'] != "") {?><hr>
                <h5 class='text-primary'>Note:</h5>
                <p>Read the instructions below before investing in this plan.</p>
                <?= htmlspecialchars_decode($plan['plan_instructions']) ?>
            <?php } ?>
        </div>
    </div>
</div>