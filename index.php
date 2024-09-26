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
                        <input type="text" class="form-control" name="idNumber" id="idNumber" placeholder="ID Number" required>
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
                <p><strong>Ongoing:</strong> <span id="ongoingCount">0</span></p>
                <p><strong>Done:</strong> <span id="doneCount">0</span></p>
            </div>

            <!-- New panel for displaying borrowed unit information -->
            <h2>Currently Logged In Units</h2>
            <div class="table-container">
                <table id="unitLogOutTable" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>ID #</th>
                            <th>Brand Unit</th>
                            <th>Logged In</th>
                            <th>Status</th> <!-- Added Status column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'connect.php';

                        // Fetch records from the database, including unit_status
                        $result = $conn->query("SELECT id, requestor_name, id_number, asset_tag_number, brand_unit, charger_option, date_logged_in, unit_status FROM UnitLogInForm");

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr data-id='" . $row['id'] . "' 
                                          data-name='" . htmlspecialchars($row['requestor_name']) . "' 
                                          data-idnumber='" . htmlspecialchars($row['id_number']) . "' 
                                          data-asset='" . htmlspecialchars($row['asset_tag_number']) . "' 
                                          data-brand='" . htmlspecialchars($row['brand_unit']) . "' 
                                          data-charger='" . htmlspecialchars($row['charger_option']) . "' 
                                          data-date='" . htmlspecialchars(date("m/d/Y H:i:s", strtotime($row['date_logged_in']))) . "'>";
                                echo "<td>" . htmlspecialchars($row['requestor_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['brand_unit']) . "</td>";
                                echo "<td>" . htmlspecialchars(date("m/d/Y H:i:s", strtotime($row['date_logged_in']))) . "</td>";
                                echo "<td>" . htmlspecialchars($row['unit_status']) . "</td>"; // Display unit_status as Status
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No units currently logged in.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
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
    // Function to update the Pending, Ongoing, and Done counters and the unit table
    function updateStatusAndTable() {
        $.ajax({
            url: 'get_unit_counts.php',
            method: 'GET',
            success: function(data) {
                const counts = JSON.parse(data);
                $('#pendingCount').text(counts.pending);
                $('#ongoingCount').text(counts.ongoing);
                $('#doneCount').text(counts.done);
            }
        });

        $.ajax({
            url: 'get_logged_in_units.php', // This PHP file will fetch currently logged-in units
            method: 'GET',
            success: function(data) {
                const units = JSON.parse(data);
                let tableRows = '';
                units.forEach(unit => {
                    tableRows += `<tr>
                        <td>${unit.requestor_name}</td>
                        <td>${unit.id_number}</td>
                        <td>${unit.brand_unit}</td>
                        <td>${unit.date_logged_in}</td>
                        <td>${unit.unit_status}</td>
                    </tr>`;
                });
                $('#unitLogOutTableBody').html(tableRows);
            }
        });
    }

    // Call updateStatusAndTable every 10 seconds
    setInterval(updateStatusAndTable, 10000);
    updateStatusAndTable(); // Initial call to load data on page load
    </script>

</body>
</html>
