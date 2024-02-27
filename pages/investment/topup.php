<div class="card card-body">
    <h1>Top Up Invesment</h1>
    <form id="foo" action="">
        
        <?php 
        if(!isset($_GET['ID'])) {
            $d->message("No ID passed. Reload page and try again.", "error");
            exit();
        }
        $topup_form['input_data']['ID'] = htmlspecialchars($_GET['id']);
        $c->create_form($topup_form) ?>
        <input type="hidden" name="page" value="investment">
        <input type="hidden" name="top_up" value="">
        <div id="custommessage"></div>
        <input type="submit" class="btn btn-primary" value="Top Up">
    </form>
</div>