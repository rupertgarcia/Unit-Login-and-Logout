<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID of the unit to log out
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $dateLoggedOut = date("Y-m-d H:i:s");  // Current date and time for logged out

        // Prepare the SQL update query
        $sql = "UPDATE UnitLogInForm 
                SET date_logged_out = ?, is_logged_out = 1 
                WHERE id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters to the query
            $stmt->bind_param("si", $dateLoggedOut, $id);

            // Execute the statement
            if ($stmt->execute()) {
                echo "success"; // Indicate success to the frontend
            } else {
                echo "error"; // Handle query error
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "error"; // Handle query preparation error
        }
    } else {
        echo "error"; // Handle missing ID error
    }
} else {
    echo "error"; // Handle incorrect request method
}

// Close the connection
$conn->close();
