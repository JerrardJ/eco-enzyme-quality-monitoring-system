<?php
$apiKey       = 'AIzaSyCN2Orkw_5KF6sPRFbfjEiOWiuTQqsHeAQ';
$email        = 'ecoenzyme@monitor.com';
$password     = 'eco123456';
$firebaseHost = "https://testing-e03bd-default-rtdb.asia-southeast1.firebasedatabase.app/";
$nodePath     = '/sensor_data.json';

$authUrl = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}";
$payload = json_encode([
    'email'             => $email,
    'password'          => $password,
    'returnSecureToken' => true,
]);

$ch = curl_init($authUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

$authData = json_decode($response, true);
if (empty($authData['idToken'])) {
    die('Authentication failed: ' . ($authData['error']['message'] ?? 'unknown error'));
}
$idToken = $authData['idToken'];

$dbUrl = "{$firebaseHost}{$nodePath}?auth={$idToken}";
$json  = file_get_contents($dbUrl);
if ($json === false) {
    die('Error fetching data from Firebase');
}
$node = json_decode($json, true);
if (!is_array($node)) {
    die('Invalid JSON from Firebase');
}

$host    = 'localhost';
$user    = 'root';
$pass    = '';
$db_name = 'eco-enzyme';
$port    = 3307;

$conn = new mysqli($host, $user, $pass, $db_name, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

$sql = "
INSERT INTO sensor_data
  (suhu, suhu_unit,
   kelembapan, kelembapan_unit,
   mq7, mq7_unit,
   ph, ph_unit,
   turbiditas, turbiditas_unit,
   salinitas, salinitas_unit)
VALUES
  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    'dsdsdsdsdsds', 
    $suhuVal, $suhuUnit,
    $kelVal,  $kelUnit,
    $mq7Val,  $mq7Unit,
    $phVal,   $phUnit,
    $turVal,  $turUnit,
    $salVal,  $salUnit
);

$suhuVal    = isset($node['suhu']['value'])       ? (float)$node['suhu']['value']       : null;
$suhuUnit   = $node['suhu']['unit']               ?? null;
$kelVal     = isset($node['kelembaban']['value']) ? (float)$node['kelembaban']['value'] : null;
$kelUnit    = $node['kelembaban']['unit']         ?? null;
$mq7Val     = isset($node['mq7']['value'])        ? (float)$node['mq7']['value']        : null;
$mq7Unit    = $node['mq7']['unit']                ?? null;
$phVal      = isset($node['pH']['value'])         ? (float)$node['pH']['value']         : null;
$phUnit     = $node['pH']['unit']                 ?? null;
$turVal     = isset($node['turbiditas']['value']) ? (float)$node['turbiditas']['value'] : null;
$turUnit    = $node['turbiditas']['unit']         ?? null;
$salVal     = isset($node['salinitas']['value'])  ? (float)$node['salinitas']['value']  : null;
$salUnit    = $node['salinitas']['unit']          ?? null;

if ($stmt->execute()) {
    echo " ";
} else {
    echo "Insert failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
