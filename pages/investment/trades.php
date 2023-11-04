<style>
    li {
        list-style: none!important;
    }
</style>
<div class="card p-2">
    <h5>Trade(s) For:</h5>
    <?php 
        if(isset($_GET['userID']) && !empty($_GET['userID'])) {
            echo $u->short_user_table($tradeUserID);
        }else{ ?>

      

    <h5>Filter</h5>
    <form action="index" method="get" class="">
        <div class="card-header">
            <div class="from-group">
                <label for="">Select Report Type</label> <br>
                <small class='text-danger'>My report is your account report, while global report is all trades taken by our AI on all active accounts.</small>
                <select name="type" class="form-control bg-light-success select" id="">
                    <!-- <option value="ssss">Place holder</option>    -->
                    <option value="" <?php if ($type == "") {
                                            echo "selected";
                                        } ?>>My Report</option>
                    <option value="global" <?php if ($type == "global") {
                                                echo "selected";
                                            } ?>>Global Report</option>
                </select>
            </div>
        </div>
        <div class="d-flex card-body">
            <input type="hidden" name="p" value="investment">
            <input type="hidden" name="action" value="trades">
            <input type="date" placeholder="Select Date" name="date" value="<?php if (isset($_GET['date'])) {
                                                        echo $_GET['date'];
                                                    } ?>" class="form-control" id="">
            <button type="submit" class="ms-2 btn btn-primary">Fliter</button>
            <a href="index?p=investment&action=trades" type="submit" class="ms-2 btn btn-outline-warning">Reset</a>

        </div>
    </form>
<?php   }  ?>
</div>

<div class="card">
    <div class="card-header">
        <div class="border-top">
            <div class="row gx-0">
                <?php
                require_once "pages/investment/trade_overview.php";

                ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once "pages/investment/trade_table.php"; ?>