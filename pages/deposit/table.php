<div class="card w-100">
    <div class="card-body">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Deposit</h5>
                <p class="card-subtitle">All Recent</p>
            </div>
            <!-- <div>
                        <select class="form-select fw-semibold">
                            <option value="1">March 2023</option>
                            <option value="2">April 2023</option>
                            <option value="3">May 2023</option>
                            <option value="4">June 2023</option>
                        </select>
                    </div> -->
        </div>
        <div class="table-responsive">
            <table class="table align-middle text-nowrap mb-0">
                <thead>
                    <tr class="text-muted fw-semibold">
                        <th scope="col" class="ps-0">Wallet</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="border-top">
                    <?php
                    foreach ($deposit as $row) {
                        $wallet = $d->getall("wallets", "ID = ?", [$row['wallet']], "coin_name, wallet_address");
                        $coin = $de->get_coin_details($wallet['coin_name']);
                    ?>
                        <tr>
                            <td class="ps-0">
                                <div class="d-flex align-items-center">
                                    <div class="me-2 pe-1">
                                        <img src="<?= $coin['image'] ?>" class="rounded-2" width="48" height="48" alt="" />
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1"><?= $coin['name']; ?></h6>
                                        <p class="fs-2 mb-0 text-muted"><?= $de->short_wallet_address($wallet['wallet_address']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 fs-3 text-dark"><?= $d->money_format($row['amount'], currency) ?></p>
                            </td>
                            <td>
                                <?= $c->badge($row['status']) ?>
                            </td>
                            <td>
                                <p class="fs-3 text-dark mb-0"><?= $d->date_format($row['date']) ?></p>
                            </td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>