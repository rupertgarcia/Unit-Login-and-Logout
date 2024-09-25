<?php
include 'connect.php';

// Query to count pending and done units
$pendingQuery = "SELECT COUNT(*) AS count FROM UnitLogInForm WHERE is_logged_out = 0 AND date_logged_out IS NULL";
$doneQuery = "SELECT COUNT(*) AS count FROM UnitLogInForm WHERE is_logged_out = 1 AND date_logged_out IS NOT NULL";

$pendingResult = $conn->query($pendingQuery);
$doneResult = $conn->query($doneQuery);

$pendingCount = ($pendingResult->num_rows > 0) ? $pendingResult->fetch_assoc()['count'] : 0;
$doneCount = ($doneResult->num_rows > 0) ? $doneResult->fetch_assoc()['count'] : 0;

echo json_encode([
    'pending' => $pendingCount,
    'done' => $doneCount
]);

$conn->close();
?>
