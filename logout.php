<?php
include 'connect.php';

date_default_timezone_set('Asia/Manila');

if (isset($_POST['id'])) {
    // Get the ID of the unit to be logged out
    $id = $_POST['id'];
    $dateLoggedOut = date("Y-m-d H:i:s");  // Get the current date and time for logged out
    $status = 'Done';  // Update the status to 'Done' when logging out

    // Prepare the SQL query to update the record
    $sql = "UPDATE UnitLogInForm 
            SET date_logged_out = ?, unit_status = ? 
            WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters (date_logged_out, status, and id)
    $stmt->bind_param("ssi", $dateLoggedOut, $status, $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Success response
        echo "Unit logged out successfully.";
    } else {
        // Error response
        echo "Error logging out unit: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
