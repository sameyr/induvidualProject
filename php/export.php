<?php
 $mysqli = require __DIR__ ."/database.php";
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedDownloadColumn = $_POST["selectedDownloadColumn"];
    echo "Selected Columns: " . $selectedDownloadColumn;
} else {
    echo "Form not submitted";
}


$filename = 'columnData.csv';
header("Content-type: text/csv");
header("Content-Disposition: attachment ; $filename=filename");
$output= fopen("php://output","w");
$header=array_keys(selectedColumnData);
fputcsv($output,$header);
 
?>