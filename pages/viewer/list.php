<?php
if (isset($_GET['path'])) {
    $path = $_GET['path'];
    if (file_exists($path)) {
        echo "<img src='$path' alt='' class='w-100'>";
    }
}
?>