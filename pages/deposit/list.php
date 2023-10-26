<?php $script[] = "chart"; ?>
<div class="row col-12">
    <?php if(!isset($deposit) || $deposit->rowCount() <= 0) {
        echo $c->empty_page("You haven't made any deposit yet.", "<a href='?p=deposit&action=new' class='btn btn-primary'> <b>Make A Deposit Now</b></a>");
     } else { ?>
    <div class="col col-12 col-md-4">
        <div class="card w-100">
            <div class="card-body">
                <a href="?p=deposit&action=new" class='btn btn-primary'><i class='ti ti-plus'></i> New Deposit</a>
               <hr>
                <h5 class="card-title fw-semibold">Deposit</h5>
                <p class="card-subtitle mb-2">All your Deposit</p>
                <div id="deport-chart" class="mb-4 ms-0 p-0"></div>
                <div class="position-relative">
                    <!-- Approved -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex">
                            <div class="p-6 bg-light-success rounded-2 me-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots text-success fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">Approved</h6>
                                <p class="fs-3 mb-0"><?= $d->money_format($Approved['total'], currency); ?></p>
                            </div>
                        </div>
                        <div class="bg-light-success badge">
                            <p class="fs-3 text-success fw-semibold mb-0"><?= number_format($Approved['number']) ?></p>
                        </div>
                    </div>
                    <!-- pending -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex">
                            <div class="p-6 bg-light-warning rounded-2 me-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots text-warning fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">Pending</h6>
                                <p class="fs-3 mb-0"><?= $d->money_format($pending['total'], currency); ?></p>
                            </div>
                        </div>
                        <div class="bg-light-warning badge">
                            <p class="fs-3 text-warning fw-semibold mb-0"><?= number_format($pending['number']) ?></p>
                        </div>
                    </div>

                    <!-- rejected -->
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex">
                            <div class="p-6 bg-light-danger rounded-2 me-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots text-danger fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">Rejected</h6>
                                <p class="fs-3 mb-0"><?= $d->money_format($rejected['total'], currency); ?></p>
                            </div>
                        </div>
                        <div class="bg-light-danger badge">
                            <p class="fs-3 text-danger fw-semibold mb-0"><?= number_format($rejected['number']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-12 col-lg-8 p-3">
        <?php require_once "pages/deposit/table.php"; ?>
    </div>
    <?php } ?>
</div>