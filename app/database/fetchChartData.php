<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'eco-enzyme';
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db_name, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT suhu, kelembapan, mq7, ph, turbiditas, salinitas, waktu FROM sensor_data ORDER BY waktu DESC LIMIT 30";
$result = $conn->query($query);

$suhu = $kelembapan = $mq7 = $ph = $turbiditas = $salinitas = $labels = [];

while ($row = $result->fetch_assoc()) {
    $suhu[] = $row['suhu'];
    $kelembapan[] = $row['kelembapan'];
    $mq7[] = $row['mq7'];
    $ph[] = $row['ph'];
    $turbiditas[] = $row['turbiditas'];
    $salinitas[] = $row['salinitas'];
    $labels[] = date('H:i:s', strtotime($row['waktu']));
}

$suhu = array_reverse($suhu);
$kelembapan = array_reverse($kelembapan);
$mq7 = array_reverse($mq7);
$ph = array_reverse($ph);
$turbiditas = array_reverse($turbiditas);
$salinitas = array_reverse($salinitas);
$labels = array_reverse($labels);
?>
