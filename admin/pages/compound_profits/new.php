<?php 
$compound_profits_form['assigned_users']['options'] = $c->get_users_option_data();
$script[] = "select2";
?>
<div class="card p-5 col-12 col-md-8">
    <h5>Create New Compound profits</h5>
    <hr>
    <form action="" id="foo">
        <?php echo $c->create_form($compound_profits_form); ?>
        <input type="hidden" name="page" value="compound_profits">
        <input type="hidden" name="new_compound_profits" value="">
        <div id="custommessage"></div>
        <input type="submit"  class="btn btn-primary" value="Create Compound profits">
    </form>
</div>