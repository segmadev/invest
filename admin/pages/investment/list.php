<?php 
    if($invests->rowCount() < 1) {
        $c->empty_page("No Investment found.");
    }else{ ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Investment.</h5>
                <p>List of Investments.</p>
            </div>
            <div class="card-body">
                <?php require_once "pages/investment/table.php"; ?>
            </div>
        </div>
    </div>
   <?php   }
?>