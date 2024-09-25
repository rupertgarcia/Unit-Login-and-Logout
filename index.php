<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Log In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"> <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-wrapper">
        <div class="container" id="Log In">
            <h1 class="form-title">For Unit Log In</h1>

            <form id="unitLogInForm" method="post" action="login.php">
                <!-- NAME OF REQUESTOR -->
                <div class="form-group input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" class="form-control" name="requestorName" id="requestorName" placeholder="Name of Requestor" required>
                </div>

                <!-- ID # AND LOCAL # -->
                <div class="form-row">
                    <div class="form-group input-group col-md-6">
                        <i class="fas fa-id-card"></i>
                        <input type="text" class="form-control" name="idNumber" id="idNumber" placeholder="ID Number">
                    </div>

                    <div class="form-group input-group col-md-6">
                        <i class="fas fa-phone"></i>
                        <input type="text" class="form-control" name="localNumber" id="localNumber" placeholder="Local Number">
                    </div>
                </div>

                <!-- EMAIL ADDRESS -->
                <div class="form-group input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email Address" required>
                </div>

                <!-- ASSET TAG # -->
                <div class="form-group input-group">
                    <i class="fas fa-tag"></i>
                    <input type="text" class="form-control" name="assetTag" id="assetTag" placeholder="Asset Tag Number" required>
                </div>

                <!-- BRAND OF UNIT -->
                <div class="form-group input-group">
                    <i class="fas fa-laptop"></i>
                    <input type="text" class="form-control" name="brandUnit" id="brandUnit" placeholder="Brand of Unit" required>
                </div>

                <!-- W/ OR W/OUT CHARGER -->
                <div class="form-group input-radio">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="withCharger" name="charger" value="With Charger" required>
                        <label class="form-check-label" for="withCharger">WITH CHARGER</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="withoutCharger" name="charger" value="Without Charger" required>
                        <label class="form-check-label" for="withoutCharger">WITHOUT CHARGER</label>
                    </div>
                </div>

                <!-- PURPOSE -->
                <div class="form-group" id="purposeGroup">
                    <i class="fas fa-edit" id="purposeIcon"></i>
                    <label for="purposeUnit">Purpose</label>
                    <textarea class="form-control" name="purposeUnit" id="purposeUnit" placeholder="Please specify the purpose." maxlength="500" required></textarea>
                </div>

                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </form>
        </div>

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
                    <!-- DataTable -->
                    <table id="recordsTable" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Local Number</th> <!-- Added Local Number column -->
                                <th>Asset Tag</th>
                                <th>Brand</th>
                                <th>Charger</th>
                                <th>Date Logged In</th>
                                <th>Date Logged Out</th>
                                <th>Action</th> <!-- Added new column for View button -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'connect.php';

                            // Fetch records from the database
                            $result = $conn->query("SELECT id, requestor_name, id_number, local_number, asset_tag_number, brand_unit, charger_option, date_logged_in, date_logged_out FROM UnitLogInForm");

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['requestor_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['local_number']) . "</td>"; // Added Local Number column
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
                                echo "<tr><td colspan='9'>No records found</td></tr>"; // Updated colspan to match the number of columns
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
                    <p><strong>Email:</strong> <span id="viewEmail"></span></p> <!-- Added email -->
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> <!-- DataTables Buttons JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!-- JSZip for Excel export -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> <!-- Buttons for CSV, Excel, and PDF export -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script> <!-- Button for Print export -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.flash.min.js"></script> <!-- Flash button for older formats -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> <!-- pdfmake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> <!-- vfs_fonts for PDF export -->

    <script>
    $(document).ready(function() {
    // Initialize DataTable for the recordsTable
    const recordsTable = $('#recordsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csvHtml5',
            'excelHtml5',
            'pdfHtml5',
            'print'
        ],
        ajax: {
            url: 'fetch_records.php', // URL to fetch table data
            type: 'GET',
            dataSrc: '' // Expecting an array of records
        },
        columns: [
            { data: 'requestor_name' },
            { data: 'id_number' },
            { data: 'local_number' },
            { data: 'asset_tag_number' },
            { data: 'brand_unit' },
            { data: 'charger_option' },
            { data: 'date_logged_in' },
            { data: 'date_logged_out' },
            {
                data: null,
                render: function(data, type, row) {
                    return `<button class='btn btn-primary view-btn' data-id='${row.id}'>View</button>`;
                }
            }
        ]
    });

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
        recordsTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
    }, 10000); // 10000 ms = 10 seconds

    // Initial data load for counters and table
    updateCounters();

    // Show the "Check Records" modal
    $('#checkRecordsBtn').on('click', function() {
        $('#checkRecordsModal').modal('show');
    });

    // View button click handler
    $(document).on('click', '.view-btn', function() {
        const row = $(this).closest('tr'); // Get the row of the clicked button
        const rowData = recordsTable.row(row).data(); // Get the data of the row

        // Populate modal fields with data from the selected row
        $('#viewRequestorName').text(rowData.requestor_name);
        $('#viewIdNumber').text(rowData.id_number);
        $('#viewLocalNumber').text(rowData.local_number);
        $('#viewEmail').text(rowData.email_address);
        $('#viewAssetTag').text(rowData.asset_tag_number);
        $('#viewBrandUnit').text(rowData.brand_unit);
        $('#viewChargerOption').text(rowData.charger_option);
        $('#viewDateLoggedIn').text(rowData.date_logged_in);

        const dateLoggedOut = rowData.date_logged_out;
        if (dateLoggedOut && dateLoggedOut !== 'Pending') {
            $('#viewDateLoggedOut').text(dateLoggedOut);
            $('#logOutUser').hide(); // Hide the "Log Out User" button if the user is logged out
        } else {
            $('#viewDateLoggedOut').text('N/A');
            $('#logOutUser').show(); // Show the "Log Out User" button if the user is not logged out
        }

        // Open the modal
        $('#viewUserModal').modal('show');

        // Store the id for log out functionality
        const userId = $(this).data('id');

        // Handle the Log Out button click inside the modal
        $('#logOutUser').off('click').on('click', function() {
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

    // Ensure scrolling is restored after the modal is hidden
    $('#viewUserModal').on('hidden.bs.modal', function () {
        // Force removal of modal-open class and ensure proper scroll
        $('body').removeClass('modal-open').css('overflow', 'auto').css('padding-right', ''); 
        // Clean any modal backdrop left
        $('.modal-backdrop').remove();
    });

    // Show the "Check Records" modal
    $('#checkRecordsBtn').on('click', function() {
        $('#checkRecordsModal').modal('show');
    });
});
    </script>

</body>
</html>
