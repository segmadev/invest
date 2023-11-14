<?php
$script[] = "chart";
$script[] = "modal";
if (isset($_SESSION['newuser'])) {
    require_once "pages/dashboard/new.php";
}
?>
<div class="container-fluid">
    <div class="row">
        <?php require_once "content/slide-notify.php"; ?>
        <?php require_once "pages/promo/overview.php"; ?>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100 bg-light-info overflow-hidden shadow-none">
                <div class="card-body position-relative">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center mb-7">
                                <div class="rounded-circle overflow-hidden me-6">
                                    <img src="<?= $u->get_profile_icon_link($userID) ?>" alt="" width="40" height="40">
                                </div>
                                <h5 class="fw-semibold mb-0 fs-5">Welcome <?= $full_name ?>!</h5>
                            </div>
                            <div class="d-flex">
                                <div><a href="index?p=deposit&action=new" class="btn btn-primary"><i class='ti ti-plus'></i> Make Deposit</a></div>
                                <?php if ($user_data['balance'] > 0 || $user_data['trading_balance'] > 0) { ?>
                                    <div>
                                        <button id="new-fund" data-url="modal?p=investment&action=transfer" data-title="Transfer Funds" onclick="modalcontent(this.id)" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md" class='btn btn-success ms-1'><i class='ti ti-arrows-down-up'></i> Transfer Funds</button>

                                    </div>
                                <?php } ?>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <div class="border-end pe-4 border-muted border-opacity-10">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center"><?= $d->money_format($user_data['balance'], currency) ?></h3>
                                    <p class="mb-0 text-dark">Balance</p>
                                </div>
                                <div class="ps-4">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center"><?= $d->money_format($user_data['trading_balance'], currency) ?></h3>
                                    <p class="mb-0 text-dark">Trading Balance</p>
                                    <!-- <p class="mb-0 text-dark">Overall Profit minus lost</p> -->
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="welcome-bg-img mb-n7 text-end">
                                <img src="http://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/welcome-bg.svg" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 d-flex align-items-strech card bg-light-success">
            <div class="card-body">
                <div class="text-dark card p-3 d-flex m-0"><b>Invested: <?= $d->money_format($user_data['amount_invest'], currency) ?></b></div>
                <hr>
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="mb-2">Total Profit</h5>
                        <h4 class="mb-3"><?= $d->money_format($user_data['profit_invest_total'], currency) ?></h4>
                        <div class="d-flex align-items-center mb-3">
                            <?= $c->arrow_percentage($user_data['total_pecent_profit_invest']) ?>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-center">
                            <div id="invest-profit-chart"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card p-3">
                    <div class="card-header">
                        <h5>Recent Trades</h5>
                        <p>Chart of recent trades taken for you.</p>
                    </div>
                    <div id="invest-chat"></div>
                </div>

                <?php /// require_once "pages/activities/list.php"; 
                ?>
            </div>

            <div class="col-md-4 col-12">
                <div class="card w-100">
                    <div class="card-header">
                        <h6>Today's Trades</h6>
                        <p>Overview of today's trades.
                            <a href="index?p=investment&action=trades" class='btn btn-sm btn-success'>See all trades</a>
                        </p>

                    </div>

                    <?php
                    $divsize = "w-100";
                    require_once "pages/investment/trade_overview.php";
                    ?>


                </div>

            </div>

        </div>
        <!-- tradeviiew chart -->
        <?php require_once "pages/tradeview-widgets/horizontal-chart.php" ?>
        <?php // var_dump($user_data); 
        ?>
        <div class="col-12">
            <!-- Recent Trades -->
            <?php require_once "pages/investment/trade_table.php"; ?>
        </div>
    </div>
    <div class="col-12">
        <?php require_once "pages/deposit/table.php";
        require_once "pages/activities/list.php";
        ?>
    </div>
</div>