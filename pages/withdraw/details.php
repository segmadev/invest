<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-start justify-content-between">
            <h6 class="mr-auto p-2 m-0"><?= $u->short_user_table($data['userID']) ?></h6>
            <a href='index?p=chat&action=view&userid=<?= $data['userID'] ?>' class="btn btn-sm btn-success"><i class='ti ti-message'></i> Chat</a>
        </div>
    </div>
    <div class="card-body">
        <p><b>Transaction ID: <?= $data['ID'] ?></b></p>
        <p><b>Amount: <?= $d->money_format($data['amount'], currency) ?></b></p>
        <p><b>Date: <?= $data['date'] ?> </b></p>
    </div>
</div>