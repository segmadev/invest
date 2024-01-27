<?php

// if(isset())
// fileID, 
// get the path of the file
// upload to google
// update file_upload with googleID
if (isset($_POST['Gupload'])) {
    $fileID = htmlspecialchars($_POST['fileID']);
    $file = $d->getall("files_upload", "ID = ?", [$fileID]);
    if (!is_array($file)) {
        echo  json_encode([
            "function" => ["changetext", "data" => ["file-".$fileID, "<small class='text-danger'>Seems we lost your file. Please reload page and try again.</small>"]]
        ]);
        exit();
    }
    $fileName = $file['file_name'];
    if (side == "admin")  require_once "../googleupload.php";
    else require_once "googleupload.php";
    $googleID = googleUpload($imgpath . $fileName);
    if (!$googleID) {
        unlink($imgpath . $fileName);
        echo  json_encode([
            "function" => ["changetext", "data" => ["file-".$fileID, "<small class='text-danger'>Unable to upload your video please try again.</small>"]]
        ]);

        // echo $d->message("Unable to upload your video please try again.", "error", "json");
        // echo $d->verbose(0, "");
        exit();
    }
    $update = $d->update("files_upload", ["googleID" => $googleID], "ID = '$fileID'");
    if (!$update) {
        echo  json_encode([
            "function" => ["changetext", "data" => ["file-".$fileID, "<small class='text-danger'>Something went wrong.</small>"]]
        ]);
        // echo $d->message("Something went wrong.", "error", "json");
        // echo $d->verbose(0, "Something went wrong.");
        exit();
    }
    echo  json_encode([
        "function" => ["changetext", "data" => ["file-".$fileID, "<small class='text-success'>Uploaded sucessfully.</small>"]]
    ]);
    // echo $d->message("Uploaded sucessfully.", "success", "json");
    // echo $d->verbose(1, "Uploaded sucessfully.");
    exit();
}
// handle video upload
if(isset($_GET['video'])) {
    if(!isset($_POST['message']) || $_POST['message'] == "") {
        echo $d->verbose(0, "Message is required");
        return ; 
    }
    $chunk = $d->chunk_upload($imgpath);
    $data = json_decode($chunk);
    if($data->filename != "") {
        // handle google upload here
        $_POST['video'] = $data->filename;
        $google = "";
        // $google = "nop";
        $fileID = uniqid();
        $insertFile = $d->quick_insert("files_upload", ["ID"=>$fileID, "userID"=>$userID, "current_location"=>"server", "googleID"=>$google, "file_name"=>$data->filename, "time_upload"=>time()]);
        if($insertFile) {
            unset($message_form['upload']);
            $_POST['message'] = urldecode($_POST['message']);
            $_POST['fileID'] = $fileID;
            $send = $ch->new_message($message_form);
            if ($send) {
                $return = [
                    "function" => ["handleG", "data" => [$fileID, $send]]
                ];
                echo json_encode($return);
            }
        }


    }else{
        echo $chunk;
    }
}



if (isset($_POST['send_message']) && !isset($_GET['video'])) {
    $send = $ch->new_message($message_form);
    if ($send) {
        $return = [
            "function" => ["onset_chat", "data" => ["message-input-box", $send]]
        ];
        echo json_encode($return);
    }
}

// delete a message
if(isset($_POST['delete_message'])) {
    $message_id = htmlspecialchars($_POST['delete_message']);
    echo $ch->delete_chat($message_id, $userID);
}

    // get users in groups
    if(isset($_POST['get_group_users'])) {
        $groupID = htmlspecialchars($_POST['get_group_users']);
        $start = htmlspecialchars($_POST['start']);
        $limit = htmlspecialchars($_POST['limit']);
        echo $ch->get_group_users($groupID, $start, $limit);
    }
    if(isset($_POST['loadmedia']) && !empty($_POST['loadmedia'])) {
        $chatID = htmlspecialchars($_POST['loadmedia']);
        
    }
    if(isset($_POST['update_last_seen'])) {
        $update_last_seen = $ch->update_last_seen($userID, time()); 
    }
    if(isset($_POST['get_user_chat_list'])) {
        // $chat_lists =  $ch->list_chat_users($ch->get_group($userID, "2"), $userID);
         $chats = $ch->get_chats($userID, htmlspecialchars($_POST['time'] ?? 0)); 
        //  var_dump($chats->rowCount());
        $chat_lists = $ch->list_chat_users($chats, $userID);
        echo $chat_lists;
    }
    if(isset($_POST['get_last_seen'])) {
        echo $ch->get_last_seen(htmlspecialchars($_POST['get_last_seen']));
    }
    // if(isset($_POST['get_chat']) && isset($_POST['lastchat'])) {
    //     $lastchat = htmlspecialchars($_POST['lastchat']);
    //     $chatID =  htmlspecialchars($_POST['chatID']);
    //     $limit = htmlspecialchars($_POST['get_chat']);
    //     $messages =  $ch->get_all_messages($chatID, $userID, $lastchat, $limit);
    
    //         if (isset($messages) && $messages->rowCount()  > 0) {
    //             foreach ($messages as $row) {
    //                 echo $ch->display_message($row, $userID);
    //             }
    //         }else {
    //             echo "null";   
    //         }
        
    // }
    
        // get old messages
        echo $ch->get_old_messages($userID);
        // get recent messages
        echo $ch->get_new_messages($userID);
?>