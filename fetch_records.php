<?php
include 'connect.php';

// Suppress warnings and notices temporarily (optional)
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Fetch data
$query = "SELECT id, requestor_name, id_number, local_number, email_address, asset_tag_number, brand_unit, charger_option, date_logged_in, date_logged_out FROM UnitLogInForm";
$result = $conn->query($query);

$records = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['date_logged_out'] = $row['date_logged_out'] ? date("m/d/Y H:i:s", strtotime($row['date_logged_out'])) : 'Pending';
        $row['date_logged_in'] = date("m/d/Y H:i:s", strtotime($row['date_logged_in']));
        $records[] = $row;
    }
}

header('Content-Type: application/json'); // Ensure correct header
echo json_encode($records, JSON_PRETTY_PRINT); // Pretty print for easier debugging

$conn->close();
?>
