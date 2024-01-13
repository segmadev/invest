<?php
$script[] = "modal";
//  $invest_and_profit = [$user_data['amount_invest'], $user_data['profit_invest_total']];
?>
<div class=" p-3  shadow mb-3 d-flex">
    <button id="new-fund" data-url="modal?p=investment&action=transfer&funds_to=trading_account" data-title="Transfer Funds" onclick="modalcontent(this.id)" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md" class='btn btn-primary'><i class='ti ti-plus'></i> Add Funds</button>
    <a href="index?p=investment&action=overview" class='btn btn-outline-primary ms-2'>New Investment</a>
    <a href="index?p=investment&action=trades" class='btn btn-outline-secondary ms-2'><i class='ti ti-eye'></i> View Trades</a>
</div>
<div class="row">
    <div class="col-lg-4 d-flex align-items-strech">
        <div class="card-body card bg-light-primary">
            <div class="card p-2 m-0">
                <div class="">
                    <b class='text-success'>Active:</b> <?= number_format($user_data['active_invest']) ?> | <b class='text-danger'>Closed:</b> <?= number_format($user_data['closed_invest']) ?>
                </div>
            </div>
            <hr>
            <div class="row align-items-center">
                <div class="col-12">
                    <h5 class="mb-2">Trading Balance</h5>
                    <h4 class="mb-3"><?= $d->money_format($user_data['trading_balance'], currency) ?></h4>
                </div>
                <div class="col-12">
                    <h6 class="mb-2">Bonus</h6>
                    <h5 class=""><?= $d->money_format($user_data['trade_bonus'], currency) ?></h5>
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

    <div class="col-lg-4 d-flex align-items-strech">

        <div class="card card-body border-2 border-success">
            <h4><b>Compounded Amount:</b></h4>
            <h2 class="m-0 text-success"><b><?= $i->compounded_profit($userID); ?></b></h2>
            <p class="m-0><small class=" text-light">Total amount gained so far through compound profit. This will keep increasing overtime.</small></p>
        </div>
        It will be automatically be credited to your balance and can be withdraw immidetly

        <!-- <div class="card bg-primary border-0 w-100">
            <div class="card-body pb-0">
                <h5 class="fw-semibold mb-1 text-white card-title">Investment and return</h5>
                <p class="fs-3 mb-3 text-white">Overview</p>
                <div class="text-center mt-3">
                    <img src="dist/images/backgrounds/piggy.png" class="img-fluid" alt="">
                </div>
            </div>
        </div> -->
    </div>

</div>
<hr>