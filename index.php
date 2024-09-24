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
                        include 'connect.php';

                        $result = $conn->query("SELECT id, requestor_name, id_number, asset_tag_number, brand_unit, charger_option, date_logged_in FROM UnitLogInForm WHERE is_logged_out = 0");

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
                                echo "<td>" . htmlspecialchars($row['asset_tag_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['brand_unit']) . "</td>";
                                echo "<td>" . htmlspecialchars(date("m/d/Y H:i:s", strtotime($row['date_logged_in']))) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No borrowed units</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <button id="logoutBtn" class="btn btn-danger disabled" disabled>Log Out</button> <!-- Disabled Log Out button -->
        </div>
    </div>

    <!-- Modal for Log Out confirmation -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Log Out Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name of Requestor:</strong> <span id="modalRequestorName"></span></p>
                    <p><strong>ID #:</strong> <span id="modalIdNumber"></span></p>
                    <p><strong>Asset Tag #:</strong> <span id="modalAssetTag"></span></p>
                    <p><strong>Brand of Laptop:</strong> <span id="modalBrandUnit"></span></p>
                    <p><strong>Charger Option:</strong> <span id="modalChargerOption"></span></p>
                    <p><strong>Date Logged In:</strong> <span id="modalDateLoggedIn"></span></p>
                    <p>Are you sure you want to log out this unit?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmLogout" style="background-color: rgb(220, 53, 69);">Confirm Log Out</button>
                </div>
            </div>
        </div>
    </div>

    <img src="img/emsgroup.png" alt="EMS Logo" class="bottom-right-image">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> <!-- Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->

    <script>
    const rows = document.querySelectorAll("#unitLogOutTable tbody tr");
    let selectedRow = null;
    const logoutBtn = document.getElementById("logoutBtn");
    const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'), {});
    let selectedId = null;

    rows.forEach(row => {
        row.addEventListener("click", function() {
            if (selectedRow === row) {
                row.classList.remove("selected");
                selectedRow = null;
                logoutBtn.disabled = true;
                logoutBtn.classList.remove("enabled");
                logoutBtn.classList.add("disabled");
                logoutBtn.style.backgroundColor = "gray";
            } else {
                if (selectedRow) {
                    selectedRow.classList.remove("selected");
                }
                selectedRow = row;
                row.classList.add("selected");

                logoutBtn.disabled = false;
                logoutBtn.classList.remove("disabled");
                logoutBtn.classList.add("enabled");
                logoutBtn.style.backgroundColor = "rgb(220, 53, 69)";

                // Populate modal fields with data from the selected row
                document.getElementById("modalRequestorName").textContent = row.getAttribute("data-name");
                document.getElementById("modalIdNumber").textContent = row.getAttribute("data-idnumber");
                document.getElementById("modalAssetTag").textContent = row.getAttribute("data-asset");
                document.getElementById("modalBrandUnit").textContent = row.getAttribute("data-brand");
                document.getElementById("modalChargerOption").textContent = row.getAttribute("data-charger");
                document.getElementById("modalDateLoggedIn").textContent = row.getAttribute("data-date");

                selectedId = row.getAttribute("data-id"); // Store the ID of the selected row
            }
        });
    });

    // Log Out button click handler to show the modal
    logoutBtn.addEventListener("click", function() {
        if (selectedRow) {
            logoutModal.show(); // Show the modal
        }
    });

    // Confirm Log Out button handler
    document.getElementById("confirmLogout").addEventListener("click", function() {
        if (selectedId) {
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
            xhr.send("id=" + selectedId);
        }
    });
    </script>
</body>
</html>
