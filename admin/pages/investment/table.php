<?php
$script[] = "table";
?>
<div class="row">
    <div class="col-12">
        <!-- start Zero Configuration -->
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <h5 class="mb-0">Investments</h5>
                </div>
                <p class="card-subtitle mb-3">
                    List of all users Investments.
                </p>
                <div class="table-responsive">
                    <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th></th>
                                <th>Amount</th>
                                <th>Trading Amount</th>
                                <th>User</th>
                                <th>Total profit</th>
                                <th>status</th>
                                <th>Date</th>
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <?php foreach ($invests as $row) { 
                                $user = $d->getall("users", "ID = ?", [$row['userID']]);
                                $full_name = $user['first_name'].' '.$user['last_name'];
                                ?>
                                <!-- start row -->
                                <tr>
                                    <td>
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class='ti ti-dots'></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <!-- <li><a class="dropdown-item" href="#">View Profile</a></li>
                                                <li>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </li> -->
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-success" target="_blank" href="index?p=investment&action=view&id=<?= $row['ID'] ?>">View</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td><?= $d->money_format($row['amount'], currency) ?></td>
                                    <td><?= $d->money_format($row['trade_amount'], currency) ?></td>
                                    <td class="d-flex gap-2"><?= $u->profile_picture_default($row['userID']).ucfirst($full_name); ?></td>
                                    <td><?= $d->money_format($i->total_profit($row['ID'], return_type:  "total"), currency) ?></td>
                                    <td><?= $c->badge($row['status']) ?></td>
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