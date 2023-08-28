<?php
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filters = array(
    'party_name' => $_GET['party_filter'] ?? '',
    'job' => $_GET['job_filter'] ?? '',
    'quantity' => $_GET['quantity_filter'] ?? '',
    'quality' => $_GET['quality_filter'] ?? '',
    'amount' => $_GET['amount_filter'] ?? '',
    'designing' => $_GET['designing_filter'] ?? '',
    'size' => $_GET['size_filter'] ?? '',
    'date' => $_GET['date_filter'] ?? '',
    'total_amount' => $_GET['total_amount_filter'] ?? '',
    'rvd' => $_GET['rvd_filter'] ?? '',
    'pending' => $_GET['pending_filter'] ?? '',
    'remark' => $_GET['remark_filter'] ?? ''
);

$filterQuery = "";
foreach ($filters as $field => $value) {
    if (!empty($value)) {
        $filterQuery .= " AND $field LIKE '%$value%'";
    }
}

$rawFilterQuery = $_GET['filter_query'] ?? '';
$decodedFilterQuery = urldecode($rawFilterQuery);

$sql = "SELECT * FROM data_entry " . $decodedFilterQuery;
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Table</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Print Table</h1>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Serial Number</th>
                        <th>Date</th>
                        <th>Party Name</th>
                        <th>Job</th>
                        <th>Quantity</th>
                        <th>Quality</th>
                        <th>Amount</th>
                        <th>Designing</th>
                        <th>Size</th>
                        <th>Total Amount</th>
                        <th>RVD</th>
                        <th>Pending</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $serialNumber = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $serialNumber . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['party_name'] . "</td>";
                            echo "<td>" . $row['job'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['quality'] . "</td>";
                            echo "<td>" . $row['amount'] . "</td>";
                            echo "<td>" . (isset($row['designing']) ? $row['designing'] : '') . "</td>";
                            echo "<td>" . $row['size'] . "</td>";
                            echo "<td>" . $row['total_amount'] . "</td>";
                            echo "<td>" . (isset($row['rvd']) ? $row['rvd'] : '') . "</td>";
                            echo "<td>" . (isset($row['pending']) ? $row['pending'] : '') . "</td>";
                            echo "<td>" . $row['remark'] . "</td>";
                            echo "</tr>";
                            $serialNumber++;
                        }
                    } else {
                        echo "<tr><td colspan='13'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <script>
            // Print the content of the div
            window.onload = function () {
                window.print();
            }
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
