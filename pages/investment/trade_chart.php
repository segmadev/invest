<?php 
    $data = json_encode($trade['trade_candles']);
    // $trades = [$trade];
?>
<div class="card">
<div class="w-100" id="tvchart"></div>
<?php require_once "pages/investment/trade_table.php"; ?>
</div>


<script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
<script type="text/javascript" src="trades/dynamicCharts/index.js?n=12"></script>

<script>
    display_chart(<?= $data ?>, "tvchart");
</script>