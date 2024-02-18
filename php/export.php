<?php
 $mysqli = require __DIR__ ."/database.php";
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedDownloadColumn = $_POST["selectedDownloadColumn"];
    echo "Selected Columns: " . $selectedDownloadColumn;
} else {
    echo "Form not submitted";
}

?>