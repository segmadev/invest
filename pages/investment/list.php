<?php
// $i->take_pending_trades();
if ($invests->rowCount() == 0) {
    echo  $c->empty_page("You haven't made any investment yet.", "<a class='btn btn-primary' href='index?p=investment&action=overview'>Invest Now</a>", "No Investment!");
} else {
?>
    <?php require_once "pages/investment/head.php"; ?>
    <div class="d-flex row">
        <?php
        $script[] = "chart";
        $invest_new_list = [];
        foreach ($invests as $row) {
            $plan = $d->getall("plans", "ID = ?", [$row['planID']]);
            if (!is_array($plan)) {
                continue;
            }
            $invest_new_list[] = $row;
        ?>

            <div class="col-lg-4 col-12">
                <?php require "pages/investment/single.php"; ?>
            </div>

        <?php } ?>
        <?php require_once "pages/investment/trade_table.php"; ?>

    </div>
<?php } ?>