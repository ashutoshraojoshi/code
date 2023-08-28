<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION['admin_username'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Entry Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .navbar-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .form-container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container label {
            font-weight: bold;
        }
        .form-container .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand navbar-title" href="#">Shivshakti</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="fetch_data.php">Fetch Data</a>
                </li>
                 <li class="nav-item">
                <span class="nav-link">Welcome, <?php echo $username; ?></span>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="logout.php">Logout</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="webpage.html">Website [EXT]</a>
                </li>
                
            </ul>
        </div>
    </nav>

    <div class="container form-container">
        <h1 class="mt-2 mb-4">Data Entry Form</h1>
        <form action="submit.php" method="post">
            <div class="row">
                <div class="col-md-6">
                    <label for="Date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="Date" name="Date" required>
                </div>
                <div class="col-md-6">
                    <label for="party_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="party_name" name="party_name" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="job" class="form-label">Job</label>
                    <input type="text" class="form-control" id="job" name="job" required>
                </div>
                <div class="col-md-6">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" class="form-control" id="size" name="size" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="col-md-6">
                    <label for="quality" class="form-label">Quality</label>
                    <select class="form-select" id="quality" name="quality" required>
                        <option value="">Select Quality</option>
                        <option value="Normal Flex">Normal Flex</option>
                        <option value="Star Flex">Star Flex</option>
                        <option value="Black back">Black back</option>
                        <option value="Black star">Black star</option>
                        <option value="Vinyl">Vinyl</option>
                        <option value="One way">One way</option>
                        <option value="Rolle up (Standy)">Rolle up (Standy)</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="Designing" class="form-label">Designing</label>
                    <input type="number" class="form-control" id="Designing" name="Designing" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="col-md-6">
                    <label for="total_amount" class="form-label">Total Amount</label>
                    <input type="number" class="form-control" id="total_amount" name="total_amount" required readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="RVD" class="form-label">RVD</label>
                    <input type="text" class="form-control" id="RVD" name="RVD" required onchange="updatePending()">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="paidSwitch" class="form-label">Paid</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="paidSwitch" name="paid" value="1" onchange="toggleRemark()">
                        <label class="form-check-label" for="paidSwitch">Paid</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="remark" class="form-label">Remark</label>
                    <select class="form-select" id="remark" name="remark" style="display: none;">
                        <option value="">Select Remark</option>
                        <option value="GPAY">GPAY</option>
                        <option value="CASH">CASH</option>
                        <option value="CHEQUE">CHEQUE</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script>
        function toggleRemark() {
            var remarkField = document.getElementById('remark');
            var paidSwitch = document.getElementById('paidSwitch');

            remarkField.style.display = paidSwitch.checked ? 'block' : 'none';
        }

        function updatePending() {
            var rvdField = document.getElementById('RVD');
            var pendingSelect = document.getElementById('Pending');

            if (parseFloat(rvdField.value) > 0 || rvdField.value === "") {
                pendingSelect.value = "1"; // Set to "Pending"
            } else {
                pendingSelect.value = "0"; // Set to "Not Pending"
            }
        }

        var amountField = document.getElementById('amount');
        var designingField = document.getElementById('Designing');
        var totalAmountField = document.getElementById('total_amount');

        amountField.addEventListener('input', updateTotalAmount);
        designingField.addEventListener('input', updateTotalAmount);

        function updateTotalAmount() {
            var amountValue = parseFloat(amountField.value) || 0;
            var designingValue = parseFloat(designingField.value) || 0;
            var totalAmount = amountValue + designingValue;
            totalAmountField.value = totalAmount.toFixed(2);
        }

        // Initial updatePending call to set the Pending value
        updatePending();
    </script>
</body>
</html>
