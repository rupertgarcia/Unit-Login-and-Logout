<?php
include 'connect.php';

// Query to count units with different statuses (Pending, Ongoing, Done)
$pendingQuery = "SELECT COUNT(*) AS count FROM UnitLogInForm WHERE unit_status = 'Pending'";
$ongoingQuery = "SELECT COUNT(*) AS count FROM UnitLogInForm WHERE unit_status = 'Ongoing'";
$doneQuery = "SELECT COUNT(*) AS count FROM UnitLogInForm WHERE unit_status = 'Done'";

// Execute the queries
$pendingResult = $conn->query($pendingQuery);
$ongoingResult = $conn->query($ongoingQuery);
$doneResult = $conn->query($doneQuery);

// Fetch the counts
$pendingCount = ($pendingResult->num_rows > 0) ? $pendingResult->fetch_assoc()['count'] : 0;
$ongoingCount = ($ongoingResult->num_rows > 0) ? $ongoingResult->fetch_assoc()['count'] : 0;
$doneCount = ($doneResult->num_rows > 0) ? $doneResult->fetch_assoc()['count'] : 0;

// Return the counts as a JSON object
echo json_encode([
    'pending' => $pendingCount,
    'ongoing' => $ongoingCount,
    'done' => $doneCount
]);

$conn->close();
?>
