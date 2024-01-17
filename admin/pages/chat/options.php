
<?php 
    $script[] = "modal"; 
    $script = array_diff($script, ["chat"]);

?>
<div class="card">
    <div class="card-header">
        <h5>More Message Options</h5>
    </div>
    <form action="chat-passer" id="foo" onsubmit="return void(0);" class="card-body">
        <?php
        $message_form['message']["type"] = "textarea";
        $message_form['message']["title"] = "Message";
        $message_form['message']["class"] = "form-control";
        $message_form['message']["global_class"] = "w-100";
        $message_form["time_sent"] = ['type'=>'input','input_type' => "datetime-local", "is_required" => false, "description" => '<small class="text-danger">You can leave it empty if you want to use current time. Only administrators can view a future message, but it will be automatically sent to users when the specified date arrives.</small>'];
        $message_form['senderID']['type'] = 'select';
        $users = [];
        if (isset($message_form['input_data']['receiverID'])) {
            $users_group = $ch->get_group_users_list($message_form['input_data']['receiverID'], 1, 100000, "first_name ASC");
            if ($users_group->rowCount() > 0) {
                foreach ($users_group as $row) {
                    $users[$row['user1']] = $ch->get_name($row['user1'], type: true);
                }
                $message_form['senderID']['options'] = $users;
            }
        }
        echo $c->create_form($message_form);
        ?>
        <div id="custommessage"></div>
        <input type="hidden" name="custom" value="">
        <input type="hidden" name="page" value="chat">
        <input type="hidden" name="send_message" value="">
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>