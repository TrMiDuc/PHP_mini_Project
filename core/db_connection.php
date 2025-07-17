<?php
$config = require realpath(__DIR__ . '/../config/config_env.php');

$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['dbname']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

return $conn;
