<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100 bg-light-info overflow-hidden shadow-none">
                <div class="card-body position-relative">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center mb-7">
                                <div class="rounded-circle overflow-hidden me-6">
                                    <img src="<?= $u->get_profile_icon_link($userID) ?>" alt="" width="40" height="40">
                                </div>
                                <h5 class="fw-semibold mb-0 fs-5"><?= $u->get_full_name($user) ?>!</h5>
                            </div>
                            <div class="d-flex">
                                <div><button id="new-transder" data-url="modal?p=users&action=transfer&userID=<?= $userID ?>" data-title="Credit or Debit Account" onclick="modalcontent(this.id)" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md"  class="btn btn-primary"><i class='ti ti-arrow'></i>Credit/Debit Account</button></div>
                                    <div>
                                        <button id="new-fund" data-url="modal?p=users&action=block" data-title="Block Account" onclick="modalcontent(this.id)" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md" class='btn btn-danger ms-1'><i class='ti ti-block'></i> Block Account</button>

                                    </div>
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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Investment.</h5>
                    <p>List of users Investment. </p>
                </div>
                <div class="card-body">
                    <?php require_once "pages/investment/table.php"; ?>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Transctions.</h5>
                    <p>Recent Transctions taken on this account. <a href="index?p=users&action=transactions&id=<?= $userID ?>">See All</a></p>
                </div>
                <div class="card-body">
                    <?php require_once "pages/users/trans_table.php"; ?>
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
                    require_once "../pages/investment/trade_overview.php";
                    ?>


                </div>

            </div>

        </div>
        <!-- tradeviiew chart -->

        <div class="col-12">
            <!-- Recent Trades -->
            <?php require_once "../pages/investment/trade_table.php"; ?>
        </div>
    </div>
    <div class="col-12">
        <?php require_once "pages/deposit/table.php";
        ?>
    </div>
</div>