<div class="card">
    <div class="card-header">
        <h5>Edit Why choose us</h5>
    </div>
    <div class="card-body">
        <form action="" id="foo">
            <?php echo $c->create_form($why_us)?>
            <input type="hidden" name="page" value="why_us">
            <input type="hidden" name="updatedetails" value="why_us">
            <div id="custommessage"></div>
            <input type="submit" value="Update" class="btn btn-primary">
        </form>
    </div>
</div>