<?php

// Database connection parameters
$host = 'mysql'; // Docker service name
$username = 'root';
$password = 'root';
$database = 'webte2_sz';
$port = '3306';

// Create PDO connection
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
