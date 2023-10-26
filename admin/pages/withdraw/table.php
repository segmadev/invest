
<?php 
    $script[] = "modal";
?>
<div class="table-responsive">
            <table class="table align-middle text-nowrap mb-0">
                <thead>
                    <tr class="text-muted fw-semibold">
                        <th scope="col" class="ps-0">Wallet</th>
                        <th>User Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="border-top">
                    <?php
                    foreach ($withdraw as $row) {
                        $wallet = $d->getall("wallets", "ID = ?", [$row['wallet']], "coin_name, wallet_address");
                        $coin = $wa->get_coin_details($wallet['coin_name']);
                    ?>
                        <tr>
                            <td class="ps-0">
                                <div class="d-flex align-items-center">
                                    <div class="me-2 pe-1">
                                        <img src="<?= $coin['image'] ?>" class="rounded-2" width="48" height="48" alt="" />
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1"><?= $coin['name']; ?></h6>
                                        <p class="fs-2 mb-0 text-muted"><?= $wa->short_wallet_address($wallet['wallet_address']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 fs-3 text-dark"><a href="index?p=users&action=view&id=<?= $row['userID'] ?>"><?=  $u->short_user_table($row['userID']); ?></a></p>
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
                            <td>
                            <a href="#" class="text-muted btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md" id="modal-<?= $row['ID'] ?>" data-url="modal?p=withdraw&action=view&id=<?= $row['ID'] ?>" data-title="Wallet Details for <?= $d->money_format($row['amount'], currency) ?> Withdrawal" onclick="modalcontent(this.id)"><i class="ti ti-wallet"></i></a>
                            </td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
        </div>