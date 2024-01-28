<?php
$message_form = [
    "chatID" => ["input_type" => "hidden"],
    "senderID" => ["title" => "Select sender", "input_type" => "hidden", "global_class" => "w-5"],
    "receiverID" => ["input_type" => "hidden"],
    "message" => ["input_type" => "text", "title" => "", "class" => "form-control message-type-box text-muted border-0 p-0 ms-2", "placeholder" => "Type Message"],
    "upload" => ["input_type" => "file", "file_name" => uniqid("M-"), "path" => $imgpath, "is_required" => false],
    "fileID"=>["is_required" => false],
    "is_group" => ["input_type" => "hidden"],
    "reply_to" => ["input_type" => "hidden", "is_required" => false],

];
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
            "function" => ["changetext", "data" => ["file-" . $fileID, "<small class='text-danger'>Seems we lost your file. Please reload page and try again.</small>"]]
        ]);
        exit();
    }
    $fileName = $file['file_name'];
    require_once PATH . "googleupload.php";
    $googleID = googleUpload($imgpath . $fileName, $d->get_settings("google_folder_ID"));
    if (!$googleID) {
        unlink($imgpath . $fileName);
        echo  json_encode([
            "function" => ["changetext", "data" => ["file-" . $fileID, "<small class='text-danger'>Unable to upload your video please try again.</small>"]]
        ]);

        // echo $d->message("Unable to upload your video please try again.", "error", "json");
        // echo $d->verbose(0, "");
        exit();
    }
    $update = $d->update("files_upload", ["googleID" => $googleID], "ID = '$fileID'");
    if (!$update) {
        echo  json_encode([
            "function" => ["changetext", "data" => ["file-" . $fileID, "<small class='text-danger'>Something went wrong.</small>"]]
        ]);
        // echo $d->message("Something went wrong.", "error", "json");
        // echo $d->verbose(0, "Something went wrong.");
        exit();
    }
    echo  json_encode([
        "function" => ["changetext", "data" => ["file-" . $fileID, "<small class='text-success'>Uploaded sucessfully.</small>"]]
    ]);
    // echo $d->message("Uploaded sucessfully.", "success", "json");
    // echo $d->verbose(1, "Uploaded sucessfully.");
    exit();
}
// handle video upload
if (isset($_GET['video'])) {
    if (!isset($_POST['message']) || $_POST['message'] == "") {
        echo $d->verbose(0, "Message is required");
        return;
    }
    $chunk = $d->chunk_upload($imgpath);
    $data = json_decode($chunk);
    if ($data->filename != "") {
        // handle google upload here
        $_POST['video'] = $data->filename;
        $google = "";
        // $google = "nop";
        $fileID = uniqid();
        $insertFile = $d->quick_insert("files_upload", ["ID" => $fileID, "userID" => $userID, "current_location" => "server", "googleID" => $google, "file_name" => $data->filename, "time_upload" => time()]);
        if ($insertFile) {
            unset($message_form['upload']);
            $_POST['message'] = urldecode($_POST['message']);
            $_POST['fileID'] = $fileID;
            $send = send_message($ch, $message_form);
            if ($send) {
                $return = [
                    "function" => ["handleG", "data" => [$fileID, $send]]
                ];
                echo json_encode($return);
            }
        }
    } else {
        echo $chunk;
    }
}
