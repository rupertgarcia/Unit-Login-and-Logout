<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "unitlogin";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to DB: " . $conn->connect_error);
}

?>
