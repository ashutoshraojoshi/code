<?php
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data based on filters
$party_filter = $_POST['party_filter'];
$job_filter = $_POST['job_filter'];
$quantity_filter = $_POST['quantity_filter'];
$quality_filter = $_POST['quality_filter'];
$amount_filter = $_POST['amount_filter'];
$designing_filter = $_POST['designing_filter'];
$size_filter = $_POST['size_filter'];
$date_filter = $_POST['date_filter'];
$total_amount_filter = $_POST['total_amount_filter'];
$rvd_filter = $_POST['rvd_filter'];
$pending_filter = $_POST['pending_filter'];
$remark_filter = $_POST['remark_filter'];

$filterQuery = "";
$filters = array(
    'party_name' => $party_filter,
    'job' => $job_filter,
    'quantity' => $quantity_filter,
    'quality' => $quality_filter,
    'amount' => $amount_filter,
    'designing' => $designing_filter,
    'size' => $size_filter,
    'date' => $date_filter,
    'total_amount' => $total_amount_filter,
    'rvd' => $rvd_filter,
    'pending' => $pending_filter,
    'remark' => $remark_filter
);

foreach ($filters as $field => $value) {
    if (!empty($value)) {
        $filterQuery .= " AND $field LIKE '%$value%'";
    }
}

$sql = "SELECT * FROM data_entry WHERE 1" . $filterQuery;
$result = $conn->query($sql);

// Calculate aggregates for numerical columns
$totalQuantity = 0;
$totalAmount = 0;
$totalRVD = 0;

while ($row = $result->fetch_assoc()) {
    $totalQuantity += intval($row['quantity']);
    $totalAmount += floatval($row['amount']);
    $totalRVD += floatval($row['rvd']);
}

// Display the results
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Exported Data</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>
    <style>
        .container {
            margin-top: 50px;
        }
        .table {
            font-size: 14px;
        }
        .table th, .table td {
            padding: 8px;
        }
        .table tfoot th {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Exported Data</h1>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Party Name</th>
                    <th>Job</th>
                    <th>Quantity</th>
                    <th>Quality</th>
                    <th>Amount</th>
                    <th>Designing</th>
                    <th>Size</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>RVD</th>
                    <th>Pending</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['party_name'] . "</td>";
    echo "<td>" . $row['job'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>" . $row['quality'] . "</td>";
    echo "<td>" . $row['amount'] . "</td>";
    echo "<td>" . $row['designing'] . "</td>";
    echo "<td>" . $row['size'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['total_amount'] . "</td>";
    echo "<td>" . $row['rvd'] . "</td>";
    echo "<td>" . $row['pending'] . "</td>";
    echo "<td>" . $row['remark'] . "</td>";
    echo "</tr>";
}
echo "</tbody>
<tfoot>
    <tr>
        <th colspan='8'>Total:</th>
        <th>" . number_format($totalAmount, 2) . "</th>
        <th>" . number_format($totalRVD, 2) . "</th>
        <th colspan='2'></th>
    </tr>
</tfoot>
</table>
</div>
</body>
</html>";

$conn->close();
?>
