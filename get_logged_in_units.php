<?php
include 'connect.php';

// Query to get currently logged-in units
$query = "SELECT requestor_name, id_number, brand_unit, date_logged_in, unit_status FROM UnitLogInForm WHERE unit_status IN ('Pending', 'Ongoing')";
$result = $conn->query($query);

$units = [];
while ($row = $result->fetch_assoc()) {
    $units[] = $row;
}

echo json_encode($units);

$conn->close();
?>
