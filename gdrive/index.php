<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Drive;
# TODO - PHP client currently chokes on fetching start page token
function uploadBasic($file_name = "")
{
    try {
        $client = new Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS=gdrive/credentials.json');
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);
        $driveService = new Drive($client);
        // $file = getcwd().'\back.png';
        $fileName =  htmlspecialchars($_FILES["$file_name"]["name"]);
        // var_dump($fileName);
        $mimeType = mime_content_type($_FILES["$file_name"]["tmp_name"]);
        $fileMetadata = new Drive\DriveFile(array(
            'name' => $fileName,
            'parents' => ['1jlKSnaLGJURubYFM-AfKdFKxPEfBtbfe'],
        ));

        $content = file_get_contents($_FILES["$file_name"]["tmp_name"]);
        // var_dump($file);
        $data = [
            'data' => "$content",
            'mimeType' => "$mimeType",
            'uploadType' => 'multipart',
            'fields' => 'id',
        ];
        // var_dump($data);
        $file = $driveService->files->create($fileMetadata, $data);
        printf("File ID: %s\n", $file->id);
        return $file->id;
    } catch (Exception $e) {
        echo "Error Message: " . $e;
    }
}


// function uploadBasic($file)
// {
//     try {
//         $client = new Client();
//         putenv('GOOGLE_APPLICATION_CREDENTIALS=./credentials.json');
//         $client->useApplicationDefaultCredentials();
//         $client->addScope(Drive::DRIVE);
//         $driveService = new Drive($client);
//         $file = getcwd().'\back.png';
//         var_dump($file);
//         exit();
//         $fileName = basename($file);
//         $mimeType = mime_content_type($file);   
//         $fileMetadata = new Drive\DriveFile(array(
//         'name' => $fileName,
//         'parents' => ['1jlKSnaLGJURubYFM-AfKdFKxPEfBtbfe'],
//     ));

//         $content = file_get_contents('back.png');
//         // var_dump($file);
//         $data = [
//             'data' => "$content",
//             'mimeType' => "$mimeType",
//             'uploadType' => 'multipart',
//             'fields' => 'id',
//         ];
//         // var_dump($data);
//         $file = $driveService->files->create($fileMetadata, $data);
//         printf("File ID: %s\n", $file->id);
//         return $file->id;
//     } catch(Exception $e) {
//         echo "Error Message: ".$e;
//     } 

// }

if (isset($_POST['upload_file'])) {
    //    var_dump(file_get_contents($_FILES["upload"]["tmp_name"]));
    // echo $_FILES["upload"]["tmp_name"];
    // echo "<br> Name:"; ho $_FILES["upload"]["name"];
    uploadBasic("upload");
    // uploadBasic();
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="upload" id=""> <br>
    <input type="submit" value="Upload" name="upload_file">
</form>
<iframe src="https://drive.google.com/file/d/1khzxC3nYaaBE5sMwG5mtmdOm9_nk0hGA/preview" alt="">