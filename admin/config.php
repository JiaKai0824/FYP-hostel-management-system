<?php
// Database configuration
$dbHost = 'localhost';  // Database host
$dbUsername = 'root';  // Database username
$dbPassword = '';  // Database password
$dbName = 'hostel';  // Database name

// Create a database connection
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the database connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}