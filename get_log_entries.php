<?php
include 'connect.php';

// Query to get all log entries
$query = "SELECT id, requestor_name, id_number, local_number, email_address, purpose_of_borrowing, asset_tag_number, brand_unit, charger_option, date_logged_in, date_logged_out, unit_status FROM UnitLogInForm";
$result = $conn->query($query);

$logs = [];
while ($row = $result->fetch_assoc()) {
    $logs[] = [
        'id' => $row['id'],
        'requestor_name' => $row['requestor_name'],
        'id_number' => $row['id_number'],
        'local_number' => $row['local_number'],
        'email_address' => $row['email_address'],
        'purpose_of_borrowing' => $row['purpose_of_borrowing'],
        'asset_tag_number' => $row['asset_tag_number'],
        'brand_unit' => $row['brand_unit'],
        'charger_option' => $row['charger_option'],
        'date_logged_in' => date('m/d/Y H:i:s', strtotime($row['date_logged_in'])),
        'date_logged_out' => $row['date_logged_out'] ? date('m/d/Y H:i:s', strtotime($row['date_logged_out'])) : null,
        'unit_status' => $row['unit_status']
    ];
}

echo json_encode($logs);

$conn->close();
?>
