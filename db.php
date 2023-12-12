<?php

// Get database credentials from environment variables

$db_host = "localhost";
$db_database = "study";
$db_username = "study_grm";
$db_password = "@studyDB!!";

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
    
    // Set PDO to throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // You can use $conn for database operations
} catch (PDOException $e) {
    die("Can't Connect with the DB: " . $e->getMessage());
}
?>