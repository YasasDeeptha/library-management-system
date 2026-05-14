<?php
date_default_timezone_set('Asia/Colombo');

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'library_system';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}