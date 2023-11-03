<?php
$script[] = "chart";
$chat_trades = [];
$script[] = "switch";
$script[] = "modal";
?>
<link rel="stylesheet" href="dist/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
<div class="row">
    <div class="col-lg-8 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Investment</h5>
                        <p class="card-subtitle mb-0">Overview of this Investment trades</p>
                    </div>
                    <!-- <div>
                        <select class="form-select">
                            <option value="1">March 2023</option>
                            <option value="2">April 2023</option>
                            <option value="3">May 2023</option>
                            <option value="4">June 2023</option>
                        </select>
                    </div> -->
                </div>
                <div class="row align-items-center">
                    <div id="invest-chat"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden bg-light-info mb-1">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">

                                <h6 class="card-title mb-1 fw-semibold">Total Earnings</h6>
                                <h5 class="fw-semibold">
                                    <?php
                                    $alltime = $i->total_profit($id);
                                    echo  $d->money_format($alltime['total']); ?></h5>
                                <?= $c->arrow_percentage($alltime['percentage'], "All time profit") ?>
                                <!-- <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-2">2023</span>
                                    </div>
                                    <div>
                                        <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-2">2023</span>
                                    </div>
                                </div> -->
                                <hr>
                                <p class="m-0  bg-light-light p-1"><b>Trading Amount:</b> <?= $d->money_format($invest['trade_amount']); ?></p>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-center">
                                    <div id="breakup"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-6 col-sm-12 m-0">
                <div class="card mb-1 p-3 bg-light-danger">
                    <h5>Block or Pause Investment</h5>
                    <div class="d-flex">
                        <input type="radio" class="btn-check" name="options" id="option1" value="active" onclick="update_compound_profits(this.value, '8')" autocomplete="off" checked="">
                        <label class="btn btn-outline-primary rounded-pill font-medium" for="option1">Pause</label>

                        <input type="radio" class="btn-check" name="options" value="deactive" id="option4" onclick="update_compound_profits(this.value, '8')" autocomplete="off">
                        <label class="btn btn-outline-danger rounded-pill font-medium ms-2" for="option4">Deactive</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-6 col-sm-12 m-0">
                <!-- Monthly Earnings -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-start">

                            <div class="col-12">
                                <h5 class="card-title mb-1 fw-semibold"> Today Earnings </h5>
                                <h4 class="fw-semibold mb-1"><?php $today_date = $i->total_profit($id, date("Y-m-d"), "all");
                                                                echo  $d->money_format($today_date['total']); ?></h4>

                                <?= $c->arrow_percentage($today_date['percentage'], "profit today") ?>
                                <hr>
                                <div>
                                    <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                    <span class="fs-2"><?= $d->date_format(date("Y-m-d H:i:s")) ?></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="earning"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../pages/investment/trade_table.php"; ?>


<!-- <div id="invest-chat"></div> -->