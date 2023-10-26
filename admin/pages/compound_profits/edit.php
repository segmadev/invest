<?php 
$compound_profits_form['assigned_users']['options'] = $c->get_users_option_data();
$compound_profits_form["input_data"] = $compound_profits;
$compound_profits_form["input_data"]['assigned_users'] = json_decode($compound_profits['assigned_users']);
$script[] = "select2";
?>
<div class="card p-5 col-12 col-md-8">
    <h5>Edit Compound profits</h5>
    <hr>
    <form action="" id="foo">
        <?php echo $c->create_form($compound_profits_form); ?>
        <input type="hidden" name="ID" value='<?= $id ?>'>
        <input type="hidden" name="page" value="compound_profits">
        <input type="hidden" name="edit_compound_profits" value="">
        <div id="custommessage"></div>
        <input type="submit"  class="btn btn-primary" value="Update Compound profits">
    </form>
</div>