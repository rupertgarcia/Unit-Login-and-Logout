<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Log In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Highlight the selected row with pale green */
        .selected {
            background-color: #d1e7dd; /* Pale green background */
        }

        /* Disabled state for the Log Out button */
        .btn.disabled {
            background-color: gray;
            cursor: not-allowed;
        }

        .btn.disabled:hover {
            background-color: gray; /* Prevent hover effect when disabled */
        }

        /* Active state for the Log Out button */
        .btn.enabled {
            background-color: rgb(60,148,84); /* Green */
            cursor: pointer;
        }

        .btn.enabled:hover {
            background-color: #07001f; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <div class="container" id="Log In">
            <h1 class="form-title">For Unit Log In</h1>

            <form id="unitLogInForm" method="post" action="login.php">
                <!-- NAME OF REQUESTOR -->
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="requestorName" id="requestorName" placeholder=" Name of Requestor" required>
                    <label for="requestorName">Name of Requestor</label>
                </div>

                <!-- ID # AND LOCAL # -->
                <div class="input-row">
                    <div class="input-group">
                        <i class="fas fa-id-card"></i>
                        <input type="text" name="idNumber" id="idNumber" placeholder="ID Number" required pattern="^[1-9]\d*$" title="Please enter a valid positive integer" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        <label for="idNumber">ID Number</label>
                    </div>

                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="localNumber" id="localNumber" placeholder="Local Number (e.g. 09123456789)" required 
                            pattern="^09\d{9}$" title="Please enter a valid mobile phone number (e.g. 09123456789)">
                        <label for="localNumber">Local Number</label>
                    </div>
                </div>

                <!-- EMAIL ADDRESS -->
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder=" Email Address" required>
                    <label for="email">Email Address</label>
                </div>

                <!-- ASSET TAG # -->
                <div class="input-group">
                    <i class="fas fa-tag"></i>
                    <input type="text" name="assetTag" id="assetTag" placeholder="Asset Tag Number" required>
                    <label for="assetTag">Asset Tag Number</label>
                </div>

                <!-- BRAND OF UNIT -->
                <div class="input-group">
                    <i class="fas fa-laptop"></i>
                    <input type="text" name="brandUnit" id="brandUnit" placeholder="Brand of Unit" required>
                    <label for="brandUnit">Brand of Unit</label>
                </div>

                <!-- W/ OR W/OUT CHARGER -->
                <div class="input-group">
                    <div class="radio-row">
                        <label>
                            <input type="radio" id="withCharger" name="charger" value="With Charger" required>
                            WITH CHARGER
                        </label>
                        <label>
                            <input type="radio" id="withoutCharger" name="charger" value="Without Charger" required>
                            WITHOUT CHARGER
                        </label>
                    </div>
                </div>

                <!-- PURPOSE -->
                <div class="input-group-purpose">
                    <i class="fas fa-edit"></i>
                    <label for="purposeUnit">Purpose of Borrowing Unit</label>
                    <textarea name="purposeUnit" id="purposeUnit" maxlength="500" required></textarea>
                </div>
                
                <input type="submit" class="btn" value="Submit" name="submit">
            </form>
        </div>

        <!-- New panel for displaying borrowed unit information -->
        <div class="right-panel">
            <h2>Currently Logged In Units</h2>
            <div class="table-container">
                <table id="unitLogOutTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Asset Tag</th>
                            <th>Brand Unit</th>
                            <th>Date Logged In</th>
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
            <button id="logoutBtn" class="btn disabled" disabled>Log Out</button> <!-- Disabled Log Out button -->
        </div>
    </div>

    <img src="img/emsgroup.png" alt="EMS Logo" class="bottom-right-image">

    <script>
    // Selectable row logic
    const rows = document.querySelectorAll("#unitLogOutTable tbody tr");
    let selectedRow = null;
    const logoutBtn = document.getElementById("logoutBtn");

    rows.forEach(row => {
        row.addEventListener("click", function() {
            // If the clicked row is already selected, deselect it
            if (selectedRow === row) {
                row.classList.remove("selected"); // Remove the green highlight
                selectedRow = null; // Clear the selected row
                logoutBtn.disabled = true; // Disable the Log Out button
                logoutBtn.classList.remove("enabled");
                logoutBtn.classList.add("disabled");
            } else {
                // Deselect the previously selected row, if any
                if (selectedRow) {
                    selectedRow.classList.remove("selected"); // Remove green highlight from previous row
                }
                // Select the current row
                selectedRow = row;
                row.classList.add("selected"); // Highlight the selected row

                // Enable the Log Out button
                logoutBtn.disabled = false;
                logoutBtn.classList.remove("disabled");
                logoutBtn.classList.add("enabled");
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
