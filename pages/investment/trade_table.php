<div class="card">
    <div class="card-body" id="trades">
        <h5 class="card-title fw-semibold"><?= $trade_table_title ?></h5>
        <p class="card-subtitle mb-0"><?= $trade_table_des ?></p>
        <div class="table-responsive mt-4">
            <table class="table table-borderless text-nowrap align-middle mb-0">
                <tbody data-ajax-data="trades" data-displayId="trade_table" id="trade_table" data-start="20" data-limit="20">
                    <?php  require_once rootFile."pages/investment/trade_list_table.php"; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!--  ddddddddddddd-->

