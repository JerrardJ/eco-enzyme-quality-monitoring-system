<?php
include("app/database/config.php");

$start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-7 days'));
$end_date = $_GET['end_date'] ?? date('Y-m-d');

$sql = "SELECT * FROM sensor_data 
        WHERE DATE(waktu) BETWEEN :start_date AND :end_date 
        ORDER BY waktu ASC";

$stmt = $conn_db->prepare($sql);
$stmt->execute([
    ':start_date' => $start_date,
    ':end_date' => $end_date
]);

$filename = "sensor_data_{$start_date} - {$end_date}.csv";
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"$filename\"");

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Suhu', 'Unit', 'Kelembapan', 'Unit', 'Gas', 'Unit', 'pH', 'Unit', 'Turbiditas', 'Unit', 'Salinity (PPM)', 'Unit', 'Waktu']);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>
