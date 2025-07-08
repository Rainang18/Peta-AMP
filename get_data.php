<?php
$csvFile = fopen("data.csv", "r");

$header = fgetcsv($csvFile);
$data = [];

while (($row = fgetcsv($csvFile)) !== FALSE) {
    $item = array_combine($header, $row);
    $item['AMO'] = floatval($item['AMO']);
    $item['AMF'] = floatval($item['AMF']);
    $item['lat'] = floatval($item['lat']);
    $item['long'] = floatval($item['long']);
    $data[] = $item;
}

fclose($csvFile);
header('Content-Type: application/json');
echo json_encode($data);
?>
