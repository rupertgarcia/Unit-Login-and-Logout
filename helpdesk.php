<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Log In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-wrapper">
        <!-- New panel for displaying summary instead of table -->
        <div class="right-panel">
            <h2>Status</h2>
            <div class="summary-container">
                <p><strong>Pending:</strong> <span id="pendingCount">0</span></p>
                <p><strong>Done:</strong> <span id="doneCount">0</span></p>
            </div>

            <!-- Check Records button -->
            <button id="checkRecordsBtn" class="btn btn-info mt-3">Check Records</button>
        </div>
    </div>

    <!-- Modal for Check Records -->
    <div class="modal fade" id="checkRecordsModal" tabindex="-1" role="dialog" aria-labelledby="checkRecordsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkRecordsModalLabel">Check Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Updated table structure -->
                    <table id="recordsTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Local Number</th>
                                <th>Email</th> <!-- Added Email column -->
                                <th>Purpose</th> <!-- Added Purpose column -->
                                <th>Asset Tag</th>
                                <th>Brand</th>
                                <th>Charger</th>
                                <th>Date Logged In</th>
                                <th>Date Logged Out</th>
                                <th>Action</th> <!-- View button column -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'connect.php';

                            // Fetch records from the database, including email and purpose
                            $result = $conn->query("SELECT id, requestor_name, id_number, local_number, email, purpose, asset_tag_number, brand_unit, charger_option, date_logged_in, date_logged_out FROM UnitLogInForm");

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['requestor_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['local_number']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['email']) . "</td>"; // Display email
                                    echo "<td>" . htmlspecialchars($row['purpose']) . "</td>"; // Display purpose
                                    echo "<td>" . htmlspecialchars($row['asset_tag_number']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['brand_unit']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['charger_option']) . "</td>";
                                    echo "<td>" . htmlspecialchars(date("m/d/Y H:i:s", strtotime($row['date_logged_in']))) . "</td>";
                                    if ($row['date_logged_out']) {
                                        echo "<td>" . htmlspecialchars(date("m/d/Y H:i:s", strtotime($row['date_logged_out']))) . "</td>";
                                    } else {
                                        echo "<td>Pending</td>";
                                    }
                                    // Add the View button in the Action column
                                    echo "<td><button class='btn btn-primary view-btn' data-id='" . $row['id'] . "'>View</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11'>No records found</td></tr>"; // Updated colspan to match the number of columns
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel">User Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name of Requestor:</strong> <span id="viewRequestorName"></span></p>
                    <p><strong>ID #:</strong> <span id="viewIdNumber"></span></p>
                    <p><strong>Local #:</strong> <span id="viewLocalNumber"></span></p>
                    <p><strong>Email:</strong> <span id="viewEmail"></span></p> <!-- Display email -->
                    <p><strong>Purpose:</strong> <span id="viewPurpose"></span></p> <!-- Display purpose -->
                    <p><strong>Asset Tag #:</strong> <span id="viewAssetTag"></span></p>
                    <p><strong>Brand of Laptop:</strong> <span id="viewBrandUnit"></span></p>
                    <p><strong>Charger Option:</strong> <span id="viewChargerOption"></span></p>
                    <p><strong>Date Logged In:</strong> <span id="viewDateLoggedIn"></span></p>
                    <p><strong>Date Logged Out:</strong> <span id="viewDateLoggedOut"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="logOutUser">Log Out User</button>
                </div>
            </div>
        </div>
    </div>

    <img src="img/emsgroup.png" alt="EMS Logo" class="bottom-right-image">

    <!--Scripts-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> <!-- Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->

    <script>
    $(document).ready(function() {

        // Function to update the Pending and Done counters
        function updateCounters() {
            $.ajax({
                url: 'get_unit_counts.php',
                method: 'GET',
                success: function(data) {
                    const counts = JSON.parse(data);
                    $('#pendingCount').text(counts.pending);
                    $('#doneCount').text(counts.done);
                }
            });
        }

        // Call updateCounters every 10 seconds to refresh the counts
        setInterval(function() {
            updateCounters();
        }, 10000); // 10000 ms = 10 seconds

        // Initial data load for counters
        updateCounters();

        // Show the "Check Records" modal
        $('#checkRecordsBtn').on('click', function() {
            $('#checkRecordsModal').modal('show');
        });

        // View button click handler
        $(document).on('click', '.view-btn', function() {
            const row = $(this).closest('tr'); // Get the row of the clicked button
            const rowData = row.data(); // Assuming you use data-attributes to store row data (email, purpose)

            // Populate modal fields with data from the selected row
            $('#viewRequestorName').text(row.find('td:nth-child(1)').text());
            $('#viewIdNumber').text(row.find('td:nth-child(2)').text());
            $('#viewLocalNumber').text(row.find('td:nth-child(3)').text());
            $('#viewEmail').text(row.find('td:nth-child(4)').text()); // Fetch email
            $('#viewPurpose').text(row.find('td:nth-child(5)').text()); // Fetch purpose
            $('#viewAssetTag').text(row.find('td:nth-child(6)').text());
            $('#viewBrandUnit').text(row.find('td:nth-child(7)').text());
            $('#viewChargerOption').text(row.find('td:nth-child(8)').text());
            $('#viewDateLoggedIn').text(row.find('td:nth-child(9)').text());

            const dateLoggedOut = row.find('td:nth-child(10)').text();
            if (dateLoggedOut && dateLoggedOut !== 'Pending') {
                $('#viewDateLoggedOut').text(dateLoggedOut);
                $('#logOutUser').hide(); // Hide the "Log Out User" button if the user is logged out
            } else {
                $('#viewDateLoggedOut').text('N/A');
                $('#logOutUser').show(); // Show the "Log Out User" button if the user is not logged out
            }

            // Open the modal
            $('#viewUserModal').modal('show');
        });

        // Handle the Log Out button click inside the modal
        $('#logOutUser').off('click').on('click', function() {
            const userId = $(this).data('id'); // Assuming the ID is stored in data-id attribute

            if (confirm('Are you sure you want to log out this user?')) {
                // Perform the log out action using AJAX
                $.ajax({
                    url: 'logout.php',
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
