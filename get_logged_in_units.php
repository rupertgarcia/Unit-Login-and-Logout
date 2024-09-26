<?php
include 'connect.php';

// Query to get all logged-in units regardless of their status
$query = "SELECT requestor_name, id_number, brand_unit, date_logged_in, unit_status FROM UnitLogInForm";
$result = $conn->query($query);

$units = [];
while ($row = $result->fetch_assoc()) {
    $units[] = $row;
}

echo json_encode($units);

$conn->close();
?>
