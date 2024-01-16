<?php
$script[] = "table";
?>
<div class="row">
    <div class="col-12">
        <!-- start Zero Configuration -->
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <h5 class="mb-0">Users</h5>
                </div>
                <p class="card-subtitle mb-3">
                    List of all registered users.
                </p>
                <div class="table-responsive">
                    <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Balance</th>
                                <th>Trading Balance</th>
                                <th>Trading Bonus</th>
                                <th>Date</th>
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <?php foreach ($users as $row) { ?>
                                <!-- start row -->
                                <tr>
                                    <td>
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class='ti ti-dots'></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="index?p=users&action=view&id=<?= $row['ID']; ?>">View Profile</a></li>
                                                 <!-- <li>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </li> -->
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-success" target="_blank" href="accessuser?id=<?= $row['ID'] ?>">Gain Access</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="d-flex gap-2"><?= $u->profile_picture_default($row['ID']) ?> <?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                    <td><a href="mailto:<?= $row['email'] ?>" target="_blank"><?= $row['email'] ?></a></td>
                                    <td><a href="tel:<?= $row['phone_number'] ?>"><?= $row['phone_number'] ?></a></td>
                                    <td><?= $d->money_format($row['balance'], currency) ?></td>
                                    <td><?= $d->money_format($row['trading_balance'], currency) ?></td>
                                    <td><?= $d->money_format($row['trade_bonus'], currency) ?></td>
                                    <td><?= $d->date_format($row['date']) ?></td>

                                </tr>
                                <!-- end row -->
                            <?php } ?>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- end Zero Configuration -->
    </div>
</div>