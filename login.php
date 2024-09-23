<?php

include 'connect.php';

if (isset($_POST['submit'])) {
    // Get the form values
    $requestorName = $_POST['requestorName'];
    $idNumber = $_POST['idNumber'];
    $localNumber = $_POST['localNumber'];
    $email = $_POST['email'];
    $assetTag = $_POST['assetTag'];
    $brandUnit = $_POST['brandUnit'];
    $chargerOption = $_POST['charger'];  // This is either 'With Charger' or 'Without Charger'
    $purposeUnit = $_POST['purposeUnit'];
    $dateLoggedIn = date("Y-m-d H:i:s");  // Get the current date and time for logged in
    $dateLoggedOut = NULL;  // Initialize date_logged_out as NULL for now
    $isLoggedOut = 0;  // Set is_logged_out to 0 since logged out is NULL

    // Prepare the SQL insert query
    $sql = "INSERT INTO UnitLogInForm (requestor_name, id_number, local_number, email_address, asset_tag_number, brand_unit, charger_option, purpose_of_borrowing, date_logged_in, date_logged_out, is_logged_out) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the query
    $stmt->bind_param("sissssssssi", $requestorName, $idNumber, $localNumber, $email, $assetTag, $brandUnit, $chargerOption, $purposeUnit, $dateLoggedIn, $dateLoggedOut, $isLoggedOut);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to index.php with a success message
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

?>
