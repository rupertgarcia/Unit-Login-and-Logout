<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Log In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" id="Log In">
        <h1 class="form-title">For Unit Log In</h1>

        <!-- Success message check -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <script>
                // Show success message
                alert("Unit Log In Form Sent Successfully");

                // Remove the query parameter to prevent the message from appearing on refresh
                if (window.history.replaceState) {
                    const urlWithoutParams = window.location.href.split('?')[0];
                    window.history.replaceState(null, null, urlWithoutParams);
                }
            </script>
        <?php endif; ?>

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

        <script>
            // Automatically reset form after submission
            if (window.location.search.includes('status=success')) {
                document.getElementById('unitLogInForm').reset();
            }
        </script>
    </div>
    <script src="script.js"></script>

    <img src="img/emsgroup.png" alt="EMS Logo" class="bottom-right-image">
</body>
</html>
