<div class="<?= $divsize ?? 'col-md-4' ?> border-end">
    <div class="p-4 py-3 py-md-4">
        <p class="fs-4 mb-0">
            <span class="text-success">
                <span class="round-8 rounded-circle bg-success d-inline-block me-1"></span>
            </span>Active Investment(s)
        </p>
        <h3 class=" mt-2 mb-0"><?= number_format($no_invest) ?></h3>
    </div>
</div>
<div class="<?= $divsize ?? 'col-md-4' ?> border-end">
    <div class="p-4 py-3 py-md-4">
        <p class="fs-4 text-danger mb-0">
            <span class="text-danger">
                <span class="round-8 bg-danger rounded-circle d-inline-block me-1"></span>
            </span>Total Lost
        </p>
        <h3 class=" mt-2 mb-0"><?= $d->money_format($lost['amount'], currency)  ?></h3>
    </div>
</div>
<div c
lass="<?= $divsize ?? 'col-md-4' ?> border-end">
    <div class="p-4 py-3 py-md-4">
        <p class="fs-4 text-success mb-0">
            <span class="text-success">
                <span class="round-8 bg-success rounded-circle d-inline-block me-1"></span>
            </span>Total Profits
        </p>
        <h3 class=" mt-2 mb-0"><?= $d->money_format($profit['amount'], currency) ?></h3>
    </div>
</div>
<div class="<?= $divsize ?? 'col-md-4' ?>">
    <div class="p-4 py-3 py-md-4">
        <p class="fs-4 text-info mb-0">
            <span class="text-info">
                <span class="round-8 bg-info rounded-circle d-inline-block me-1"></span>
            </span>No of trades taken
        </p>
        <h3 class=" mt-2 mb-0"><?= number_format($trade_no) ?></h3>
    </div>
</div>