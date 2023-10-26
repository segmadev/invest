<?php require_once "../content/slide-notify.php"; ?>
<?php require_once "pages/dashboard/scroll.php"; ?>
<div class="row">
    <div class="col-12">
        <div class="border-top">
            <div class="row gx-0">
                <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-danger mb-0">
                            <span class="text-danger">
                                <span class="round-8 bg-danger rounded-circle d-inline-block me-1"></span>
                            </span>Total Lost
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['lost_invest_total'], currency)  ?></h3>
                    </div>
                </div>
                <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-success mb-0">
                            <span class="text-success">
                                <span class="round-8 bg-success rounded-circle d-inline-block me-1"></span>
                            </span>Total Profits
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['profit_invest_total'], currency) ?></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-info mb-0">
                            <span class="text-info">
                                <span class="round-8 bg-info rounded-circle d-inline-block me-1"></span>
                            </span>Total Amount Invested
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['total_investment_amount'], currency) ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once "../pages/investment/trade_table.php" ?>
    </div>

    <div class="row">
    <div class="border-top">
            <div class="row gx-0">
                <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-dark mb-0">
                            <span class="text-dark">
                                <span class="round-8 bg-dark rounded-circle d-inline-block me-1"></span>
                            </span>All Balance
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['balance'], currency)  ?></h3>
                    </div>
                </div>
                <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-primary mb-0">
                            <span class="text-primary">
                                <span class="round-8 bg-primary rounded-circle d-inline-block me-1"></span>
                            </span>Trading Balance
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['trading_balance'], currency)  ?></h3>
                    </div>
                </div>
                <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-danger mb-0">
                            <span class="text-danger">
                                <span class="round-8 bg-danger rounded-circle d-inline-block me-1"></span>
                            </span>Total Trading Bonus
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['trade_bonus'], currency)  ?></h3>
                    </div>
                </div>
                <hr>
                <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-danger mb-0">
                            <span class="text-danger">
                                <span class="round-8 bg-danger rounded-circle d-inline-block me-1"></span>
                            </span>Total Withdraw
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['total_withdraw'], currency)  ?></h3>
                    </div>
                </div>
                <div class="col-md-4 border-end">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-success mb-0">
                            <span class="text-success">
                                <span class="round-8 bg-success rounded-circle d-inline-block me-1"></span>
                            </span>Total Deposit
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['total_deposit'], currency) ?></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 py-3 py-md-4">
                        <p class="fs-4 text-warning mb-0">
                            <span class="text-warning">
                                <span class="round-8 bg-warning rounded-circle d-inline-block me-1"></span>
                            </span>Total pending deposit
                        </p>
                        <h3 class=" mt-2 mb-0"><?= $d->money_format($users_data['total_pending_deposit'], currency) ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- deposit -->
            <div class="card">
                <div class="card-header">
                    <h5>Pending Deposit</h5>
                </div>
                <div class="card-body table-responsive">
                    <?php require_once "pages/deposit/table.php" ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- withdraw -->
            <div class="card">
                <div class="card-header">
                    <h5>Recent withdraw</h5>
                </div>
                <div class="card-body">
                    <?php require_once "pages/withdraw/table.php" ?>
                </div>
            </div>
        </div>
    </div>
</div>