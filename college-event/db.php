<?php
$host = 'localhost';          // MySQL host (usually localhost)
$db   = 'event_management';   // Database name
$user = 'root';               // MySQL username (default is 'root' for XAMPP)
$pass = '';                   // MySQL password (empty by default in XAMPP)

$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
