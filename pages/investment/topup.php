<div class="row">
    <div class="col-md-8">
        <form id="foo" class='card p-3 shadow-lg' onsubmit="return false;">
            <?php
            if (!isset($_GET['id'])) {
                $d->message("No ID passed. Reload page and try again.", "error");
                exit();
            }
            $topup_form['input_data']['ID'] = htmlspecialchars($_GET['id']);
            echo $c->create_form($topup_form); ?>
            <input type="hidden" name="page" value="investment">
            <input type="hidden" name="top_up" value="">
            <div id="custommessage"></div>
            <input type="submit" class="btn btn-primary" value="Top Up">
        </form>
    </div>
    <div class="col-md-4 m-0">
        <?php echo $u->show_balance($user_data); ?>
    </div>
</div>