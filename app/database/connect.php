<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'eco-enzyme';
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db_name, $port);

// Check connection
if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}
