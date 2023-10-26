<?php 
if(isset($_GET['status'])) {
    $status = htmlspecialchars($_GET['status']);
    $deposit = $d->getall("deposit", "status = ? order by date DESC",[$status], fetch: "moredetails");
}else{
    $deposit = $d->getall("deposit", "status != ? order by date DESC",[""], fetch: "moredetails");
}
    ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0">Deposits</h4>
            </div>
            <div class="card-body">
              <?php  require_once "pages/deposit/table.php"; ?>
            </div>
        </div>
    </div>
</div>