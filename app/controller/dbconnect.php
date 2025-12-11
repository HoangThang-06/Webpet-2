<?php
require_once __DIR__ . '/../key/EnvLoader.php';

EnvLoader::load(__DIR__ . '/../key/.env');

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');

// Kết nối mysqli
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}
