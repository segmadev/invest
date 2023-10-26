<div class="card">
    <div class="card-body" id="trades">
        <h5 class="card-title fw-semibold"><?= $trade_table_title ?></h5>
        <p class="card-subtitle mb-0"><?= $trade_table_des ?></p>
        <div class="table-responsive mt-4">
            <table class="table table-borderless text-nowrap align-middle mb-0">
                <tbody>
                    <?php if ($trades->rowCount() == 0) {
                    } else {
                        
                        foreach ($trades as $row) {
                            if(isset($chat_trades)) {
                                $chat_trades[] = $row;
                            }
                            $coin_full_name = $row['coinname'];
                            $coinname = str_replace("USDT", "", $row['coinname']);
                            $candles = json_decode($row['trade_candles']);
                            $open = number_format($candles[0][2], 3);
                            $close = number_format($candles[count($candles) - 1][4], 3);
                            $second = "sell";
                            if($row['trade_type'] == 'sell') {
                                $second = "buy";
                            }
                    ?>  
                            <tr class="bg-light">
                                <td><a id="view_<?= $row['ID'] ?>" href="index?p=investment&action=trade_chart&tradeID=<?= $row['ID'] ?>">View</a></td>
                                <td class="rounded-start bg-transparent">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img  style="width: 40px" src="https://assets.coincap.io/assets/icons/<?= strtolower($coinname) ?>@2x.png" alt="">
                                            <i class="cc USDT <?php // echo $coinname ?> fs-7"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?= $coin_full_name ?></h6>
                                            <span class="fs-3"><?= $coinname ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="bg-transparent"> <?= $c->arrow_percentage($row['percentage'], "")." ".$d->money_format($row['intrest_amount'], currency) ?></i>
                                </td>
                                <td class="bg-transparent">
                                    <b class=''>Amount: </b> <?= $d->money_format($row['amount'], currency) ?>
                                </td>
                                <td class="bg-transparent">
                                    <b class='text-<?= $row['trade_type'] ?>'><?= $row['trade_type'] ?>: </b> <?= $open ?>
                                </td>
                                <td class="bg-transparent"><b class='text-<?= $second ?>'><?= $second ?>: </b> <?= $close ?></td>
                                <td class="bg-transparent">Trade By: <?= $row['Xtrade']  ?>X</td>
                                <td class="text-end rounded-end bg-transparent">
                                    <?= $d->date_format(date("Y-m-d H:i:s", $candles[0][0]  / 1000)) ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                    <?php }
                    if(isset($chat_trades)) {
                        $chat_trades = array_reverse($chat_trades);
                    }
                    } ?>
                    <!-- <tr class="bg-light">
                        <td class="rounded-start bg-transparent">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <i class="cc ETH fs-7"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Ethereum</h6>
                                    <span class="fs-3">ETH</span>
                                </div>
                            </div>
                        </td>
                        <td class="bg-transparent"> $450.1254 <i class="ti ti-chevron-down text-danger ms-1 fs-4"></i>
                        </td>
                        <td class="bg-transparent">
                            <i class="cc ETC me-1 text-primary fs-5" title="ETC"></i> 0.45000
                        </td>
                        <td class="bg-transparent">$3.23560 B</td>
                        <td class="bg-transparent">09 Mar 2023</td>
                        <td class="text-end rounded-end bg-transparent">
                            <span class="badge bg-primary">sell</span>
                        </td>
                    </tr> -->

                </tbody>
            </table>
        </div>
    </div>
</div>