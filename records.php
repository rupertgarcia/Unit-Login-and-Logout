<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Log In Records</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> 

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style_records.css">
</head>
<body>
    <div class="container-wrapper">
        <!-- Check Records Table -->
        <div class="container mt-5">
            <h2>Unit Log In Records</h2>

            <!-- DataTable -->
            <table id="recordsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>ID Number</th>
                        <th>Local Number</th>
                        <th>Email</th>
                        <th>Purpose</th>
                        <th>Asset Tag</th>
                        <th>Brand</th>
                        <th>Charger</th>
                        <th>Date Logged In</th>
                        <th>Date Logged Out</th>
                        <th>Status</th>
                        <th>Action</th> <!-- Action column for Log Out button -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'connect.php';

                    // Fetch records from the database, including email and purpose
                    $result = $conn->query("SELECT id, requestor_name, id_number, local_number, email_address, purpose_of_borrowing, asset_tag_number, brand_unit, charger_option, date_logged_in, date_logged_out, unit_status FROM UnitLogInForm");

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['requestor_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['local_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email_address']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['purpose_of_borrowing']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['asset_tag_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['brand_unit']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['charger_option']) . "</td>";
                            echo "<td>" . htmlspecialchars(date("m/d/Y H:i:s", strtotime($row['date_logged_in']))) . "</td>";
                            
                            // Display "Not Yet Logged Out" for blank date_logged_out
                            if ($row['date_logged_out']) {
                                echo "<td>" . htmlspecialchars(date("m/d/Y H:i:s", strtotime($row['date_logged_out']))) . "</td>";
                            } else {
                                echo "<td>Not Yet Logged Out</td>";
                            }

                            // Add a dropdown for status in the Status column
                            echo "<td>
                                <select class='status-dropdown' data-id='" . $row['id'] . "'>
                                    <option value='Pending' " . ($row['unit_status'] === 'Pending' ? 'selected' : '') . ">Pending</option>
                                    <option value='Ongoing' " . ($row['unit_status'] === 'Ongoing' ? 'selected' : '') . ">Ongoing</option>
                                    <option value='Done' " . ($row['unit_status'] === 'Done' ? 'selected' : '') . ">Done</option>
                                </select>
                            </td>";

                            // Add Log Out button in the Action column
                            echo "<td><button class='btn btn-danger log-out-btn' data-id='" . $row['id'] . "'>Log Out</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--Scripts-->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#recordsTable').DataTable();

        // Handle the change event for the status dropdown
        $(document).on('change', '.status-dropdown', function() {
            const selectedStatus = $(this).val(); // Get the selected status
            const userId = $(this).data('id'); // Get the ID of the record

            // Confirm status change
            if (confirm(`Are you sure you want to change the status to "${selectedStatus}"?`)) {
                // Perform the status update using AJAX
                $.ajax({
                    url: 'update_status.php', // Update this URL to your PHP file that handles the status update
                    method: 'POST',
                    data: {
                        id: userId,
                        status: selectedStatus
                    },
                    success: function(response) {
                        alert(response); // Display response from update_status.php
                        window.location.reload(); // Reload the page to reflect the updated status
                    },
                    error: function() {
                        alert('Error updating status.');
                    }
                });
            } else {
                // Reset the dropdown to the previous value if the user cancels
                $(this).val($(this).data('original-value'));
            }
        });

        // Handle Log Out button click
        $(document).on('click', '.log-out-btn', function() {
            const userId = $(this).data('id'); // Get the ID of the record

            if (confirm('Are you sure you want to log out this user?')) {
                // Perform the log out action using AJAX
                $.ajax({
                    url: 'logout.php', // Update this URL to your PHP file that handles the log out
                    method: 'POST',
                    data: { id: userId },
                    success: function(response) {
                        alert(response); // Display response from logout.php
                        window.location.reload(); // Reload the page to update the table
                    },
                    error: function() {
                        alert('Error logging out user.');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
