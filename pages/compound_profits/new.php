<div class="card bg-light-success">

    <div class="card-body">
        <h5>Compound Profit.</h5>
        <p><?= htmlspecialchars_decode($d->get_settings("compound_profits_short_title")) ?> <button class='btn p-0 text-primary' id="compound_profit" data-url="modal?p=compound_profits&action=overview" data-title="Compound profits" onclick="modalcontent(this.id)" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md">Read more</button></p>
    </div>
</div>

<?php
$script[] = "modal";
$compound_a = $i->get_compound_profits($userID);
if (is_array($compound_a)) {
    $compound = $d->getall("compound_profits", "ID = ?", [$compound_a['compound_profits']]); ?>
    <div class="card">
        <div class="card-header">
            <h5>Active compound profit.</h5>
        </div>
        <div class="card-body row">
        <div class="col-md-6 col-12 mt-1">
            <div class="card card-body border-2 border-success">
                <h4><b>Compounded Amount:</b></h4>
                <h2 class="m-0 text-success"><b><?= $i->compounded_profit($userID); ?></b></h2>
                <p class="m-0><small class="text-light">Total amount gained so far through compound profit. This will keep increasing overtime.</small></p>
            </div>
            </div>

            <div class="col-md-6 col-12 mt-1">
            <div class="card card-body p-0 p-3">
                <h4 class="m-0"><b>Compound profit details</b></h4>
                <p class="m-0 mb-2"><small>This compound profit is applied on all your active investments.</small></p>
                <p><b>Type:</b> <?= $compound['type'] ?></p>
                <p><b>Purchase price:</b> <?= $compound['purchase_price'] ?></p>
                <p><b>Bonus price:</b> <?= $compound['bonus_price'] ?></p>
                
            </div>
            </div>
           
        </div>
    </div>
<?php } ?>

<div class="d-felx row">
    <?php if (count($i->get_user_roll_over($userID)) == 0 ) {
        if (!is_array($compound_a)) {
        echo "<div id='newcompound' class='card p-2'>" . $c->empty_page("We regret to inform you that no compound profit has been allocated to your account at this time, <br> or you are presently running the highest compound profit. <br> If you have any inquiries or concerns, <br> please reach out to our dedicated customer support team via email at <br> <a href='mailto:" . $d->get_settings('support_email') . "'>" . $d->get_settings('support_email') . "</a>.", h1: "No compound profit allocated.") . "</div>";
        }
    } else {
    ?>
        <div class="col-md-8 col-12">
            <div class="card p-4">

                <h6>Activate Compound profits or upgrade on the one you have</h6>
                <form action="" id="foo">
                    <?php
                    $invest = $d->getall("investment", "userID = ?", [$userID]);
                    if (!is_array($invest)) {
                        echo $c->empty_page("You do not have an active investment." . $d->get_settings('support_email') . "</a>.", btn: "<a href='index?p=investment&action=overview' class='btn btn-success'>Invest Now!</a>", h1: "No Active Investment.");
                    } else {
                        $investID = $invest['ID'];
                        echo $c->create_form($compound_profits_form);

                    ?>
                        <input type="hidden" name="investmentID" value="<?= $investID ?>">
                        <input type="hidden" name="new_compound_profits">
                        <input type="hidden" name="page" value="compound_profits">
                        <dic id="custommessage"></dic>
                        <input type="submit" class="btn btn-primary" value="Activate compound profit">
                    <?php } ?>
                </form>

            </div>
        </div>
        <div class="col-md-4">
            <?php echo $u->show_balance($user_data); ?>
        </div>
    <?php } ?>
</div>