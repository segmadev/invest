<?php require_once "../content/textarea.php"; ?>
<div class="card col-12">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">Create New Plan</h4>
    </div>
    <div class="card-body">
    <form class="mt-4" action="" id="foo"  novalidate="">
        <div class="row">
            <?php 
            echo $c->create_form($plans_form); ?>
            <input type="hidden" name="newplan" value="" id="">
            <input type="hidden" name="page" value="plans" id="">
        </div>
        <div id="custommessage"></div>
        <input type="submit" value="Submit" class="btn btn-primary col-3">
    </form>
    </div>
</div>