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
                        <input type="text" class="form-control" name="idNumber" id="idNumber" placeholder="ID Number" required pattern="^[1-9]\d*$" title="Please enter a valid positive integer" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <div class="form-group input-group col-md-6">
                        <i class="fas fa-phone"></i>
                        <input type="text" class="form-control" name="localNumber" id="localNumber" placeholder="Local Number (e.g. 09123456789)" required 
                            pattern="^09\d{9}$" title="Please enter a valid mobile phone number (e.g. 09123456789)">
                    </div>
                </div>

                <!-- EMAIL ADDRESS -->
                <div class="form-group input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
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
                    <textarea class="form-control" name="purposeUnit" id="purposeUnit" placeholder="Purpose of Borrowing Unit" maxlength="500" required></textarea>
                </div>

                
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </form>
        </div>

        <!-- New panel for displaying borrowed unit information -->
        <div class="right-panel">
            <h2>Currently Logged In Units</h2>
            <div class="table-container">
                <table id="unitLogOutTable" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Asset Tag</th>
                            <th>Brand Unit</th>
                            <th>Logged In</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include the connection file and query for entries where is_logged_out = 0
                        include 'connect.php';

                        $result = $conn->query("SELECT id, requestor_name, asset_tag_number, brand_unit, date_logged_in FROM UnitLogInForm WHERE is_logged_out = 0");

                        if ($result->num_rows > 0) {
                            // Output data for each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr data-id='" . $row['id'] . "'>";
                                echo "<td>" . htmlspecialchars($row['requestor_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['asset_tag_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['brand_unit']) . "</td>";
                                echo "<td>" . htmlspecialchars(date("m/d/Y", strtotime($row['date_logged_in']))) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No borrowed units</td></tr>";
                        }

                        // Close the connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <button id="logoutBtn" class="btn btn-danger disabled" disabled>Log Out</button> <!-- Disabled Log Out button -->
        </div>
    </div>

    <img src="img/emsgroup.png" alt="EMS Logo" class="bottom-right-image">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> <!-- Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->

    <script>
    // Selectable row logic
    const rows = document.querySelectorAll("#unitLogOutTable tbody tr");
    let selectedRow = null;
    const logoutBtn = document.getElementById("logoutBtn");

    // Initial state of the button
    logoutBtn.disabled = true; // Disable the button initially
    logoutBtn.classList.add("disabled"); // Add the disabled class
    logoutBtn.style.backgroundColor = "gray"; // Set background color to gray

    rows.forEach(row => {
        row.addEventListener("click", function() {
            // If the clicked row is already selected, deselect it
            if (selectedRow === row) {
                row.classList.remove("selected"); // Remove the highlight
                selectedRow = null; // Clear the selected row
                logoutBtn.disabled = true; // Disable the Log Out button
                logoutBtn.classList.remove("enabled");
                logoutBtn.classList.add("disabled");
                logoutBtn.style.backgroundColor = "gray"; // Set background color to gray
            } else {
                // Deselect the previously selected row, if any
                if (selectedRow) {
                    selectedRow.classList.remove("selected"); // Remove highlight from previous row
                }
                // Select the current row
                selectedRow = row;
                row.classList.add("selected"); // Highlight the selected row

                // Enable the Log Out button
                logoutBtn.disabled = false;
                logoutBtn.classList.remove("disabled");
                logoutBtn.classList.add("enabled");
                logoutBtn.style.backgroundColor = "rgb(220, 53, 69)"; // Set button to red
            }
        });
    });

    // Log Out button click handler
    logoutBtn.addEventListener("click", function() {
        if (selectedRow) {
            const id = selectedRow.getAttribute("data-id");

            // Send AJAX request to log out the selected unit
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "logout.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Refresh the page after logout
                    window.location.reload();
                } else {
                    alert("Error logging out unit");
                }
            };
            xhr.send("id=" + id);
        }
    });
    </script>
</body>
</html>
