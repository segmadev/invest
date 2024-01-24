<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Drive;
# TODO - PHP client currently chokes on fetching start page token



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
?>
<!-- <iframe src="https://drive.google.com/file/d/1khzxC3nYaaBE5sMwG5mtmdOm9_nk0hGA/preview" alt=""> -->