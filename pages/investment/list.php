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
                <div class="card">
                    <div class="card-body p-4">
                        <!-- plan info -->
                        <?= $c->plan_list($plan, "w-100 border border-secondary shadow-0"); ?>
                        <?php 
                            if($row['status'] == "pending"){
                                echo "<small class='text-danger'>This is a pending investment waiting for deposited fund to be approved.<small>";
                            }
                        ?>
                        <div class="overflow-hidden mt-9">
                            <div id="invest-chat-<?= $row['ID'] ?>"></div>
                        </div>
                        <div class="card shadow-none mb-0">
                            <div class="card-body p-0">
                                <div class=" align-items-center mb-3">
                                    <p><small><b>Trade Amount</b></small></p>
                                    <h2 class="fw-semibold mb-0"><?= $d->money_format($row['trade_amount']) ?></h2>
                                    <!-- <div class="ms-auto">
                            <div class="dropdown">
                                <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots fs-4"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="balance-dd">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="ti ti-share me-1 fs-4"></i>Share </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="ti ti-download me-1 fs-4"></i>Download </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="ti ti-info-circle me-1 fs-4"></i>Get Info </a>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                                </div>
                                <p class='m-0'><small>Profit:</small></p>
                                <div class="d-flex align-items-center mt-0">
                                    <h5><?php $alltime = $i->total_profit($row['ID']);
                                        echo  $d->money_format($alltime['total']); ?></h5>
                                    <?php echo $c->arrow_percentage($alltime['percentage'], "") ?>
                                </div>
                                <a href="index?p=investment&action=view&id=<?= $row['ID'] ?>" class="btn btn-light-primary text-primary w-100 mt-3"> View Trades </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
        <?php require_once "pages/investment/trade_table.php"; ?>

    </div>
<?php } ?>