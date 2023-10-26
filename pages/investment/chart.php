<script src="dist/libs/apexcharts/dist/apexcharts.min.js"></script>
<!-- trades -->
<?php
if (isset($chat_trades)) {
    $invet_chart_data = $i->extract_chart_data($chat_trades, strtotime($invest['date']) * 1000);
?>
    <script>
        lines_chart(<?= json_encode($invet_chart_data) ?>, "#invest-chat");
    </script>
<?php
}
?>

<!-- individual invest -->

<?php
if (isset($invest_new_list)) {
    if (count($invest_new_list) >  0) {
        // $newinvests = $invests;
        foreach ($invest_new_list as $row) {
            $trades = $d->getall("trades", "investmentID = ? and status = ? LIMIT 4", [$row['ID'], "closed"],  fetch: "moredetails");
            
                $invet_chart_data = $i->extract_chart_data($trades, strtotime($row['date']) * 1000);
?>
                <script>
                    lines_chart(<?= json_encode($invet_chart_data) ?>, "#invest-chat-<?= $row['ID'] ?>", "simple");
                </script>
<?php
            
        }
    }
}
?>

<?php
if(isset($invest_and_profit)) {
    $labels = ["Invested", "Profit made"];
    ?>
<script>
    donut_chart(<?=  json_encode($invest_and_profit) ?>, <?= json_encode($labels) ?>, "#invest-profit-chart");
</script>
    <?php
}
?>

