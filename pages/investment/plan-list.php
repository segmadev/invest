<?php
$plans = $d->getall("plans", "status = ?", ["active"], fetch: "moredetails");
if ($plans->rowCount() == 0) {
    echo $c->empty_page("Sorry! we do not hava a plan for you at the moment. <br> Please check back later. <br> You can send us an <a href='mailto:" . $c->get_settings("support_email") . "'>" . $c->get_settings("support_email") . "</a> email <br> maybe we can work  something out for you.", "<a class='btn btn-primary' href='" . ROOT . "'>Go Home</a>");
} else {
?>
    <div class="d-flex justify-content-center">
        <div class="col-12 col-md-12 p-3">
            <h4 class="">Select investment plan</h4>
            <a href="?p=investment&action=overview" class="badge bg-light-primary text-primary fw-semibold fs-2"><b>< Read Overview</b></a>
            <div class="info row col-md-12">
                <?php
                foreach ($plans as $data) {
                    echo $c->plan_list($data);
                }
                ?>
            </div>
        </div>
    </div>
<?php
}
?>