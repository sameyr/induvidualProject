<?php
$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedDownloadColumn = $_POST["selectedDownloadColumn"];
    $selectedColumns = explode(",", $selectedDownloadColumn);
    $startTime = $_POST["startTimeStamp"];
    $endTime = $_POST["endTimeStamp"];
} else {
    echo "Form not submitted";
}

$sql = sprintf("SELECT timestamp,%s FROM sampleinputdata
                WHERE STR_TO_DATE(timestamp, '%%m/%%d/%%Y %%H:%%i') 
                BETWEEN STR_TO_DATE('%s', '%%m/%%d/%%Y %%H:%%i')
                AND STR_TO_DATE('%s', '%%m/%%d/%%Y %%H:%%i');",
    $mysqli->real_escape_string(implode(",", $selectedColumns)),
    $mysqli->real_escape_string($startTime),
    $mysqli->real_escape_string($endTime));

$result = $mysqli->query($sql);

$columnData[] = [
    'timestamp' => [],
    'values' => [],
];

while ($row = $result->fetch_assoc()) {
    $timestamp = $row['timestamp'];
    foreach ($selectedColumns as $column){
        $columnData[$column]['timestamp'][] = $timestamp;
        $columnData[$column]['values'][] = $row[$column];
    }
}

$filename = 'file_' . implode('_', $selectedColumns) . '_' . date('Ymd_His') . '.csv';

$fs = fopen($filename, 'w');

fputcsv($fs, array_merge(['timestamp'], $selectedColumns));

foreach ($columnData as $column => $data) {
    $timestamps = $data['timestamp'];
    $values = $data['values'];

    for ($i = 0; $i < count($timestamps); $i++) {
        fputcsv($fs, array_merge([$timestamps[$i]], [$values[$i]]));
    }
}

fclose($fs);

echo '<a href="' . $filename . '" download>Download CSV</a>';
?>

