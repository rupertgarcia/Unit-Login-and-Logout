<?php
include 'connect.php';

// Query to get currently logged-in units (only those without a date_logged_out)
$query = "SELECT requestor_name, id_number, brand_unit, date_logged_in, unit_status 
          FROM UnitLogInForm 
          WHERE date_logged_out IS NULL"; // Add this condition to exclude logged-out users

$result = $conn->query($query);

$units = [];
while ($row = $result->fetch_assoc()) {
    $units[] = $row;
}

echo json_encode($units);

$conn->close();
?>
