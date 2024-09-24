<?php
include 'connect.php';

date_default_timezone_set('Asia/Manila');


if (isset($_POST['id'])) {
    // Get the ID of the unit to be logged out
    $id = $_POST['id'];
    $dateLoggedOut = date("Y-m-d H:i:s");  // Get the current date and time for logged out

    // Prepare the SQL query to update the record
    $sql = "UPDATE UnitLogInForm 
            SET date_logged_out = ?, is_logged_out = 1 
            WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters (date_logged_out and id)
    $stmt->bind_param("si", $dateLoggedOut, $id);

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
