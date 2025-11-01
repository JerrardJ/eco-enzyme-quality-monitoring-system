<?php

$host = 'localhost';
$port = 3307;
$user = 'root';
$pass = '';
$db_name = 'eco-enzyme';

try {
    $conn_db = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4", $user, $pass);
    $conn_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
