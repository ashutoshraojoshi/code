<?php
// Add this at the top of the print_page.php file
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filters = array(
    'party_name' => $_GET['party_name'] ?? '',
    'job' => $_GET['job'] ?? '',
    'quantity' => $_GET['quantity'] ?? '',
    'quality' => $_GET['quality'] ?? '',
    'amount' => $_GET['amount'] ?? '',
    'Designing' => $_GET['Designing'] ?? '',
    'size' => $_GET['size'] ?? '',
    'date' => $_GET['date'] ?? '',
    'total_amount' => $_GET['total_amount'] ?? '',
    'RVD' => $_GET['RVD'] ?? '',
    'Pending' => $_GET['Pending'] ?? '',
    'remark' => $_GET['remark'] ?? ''
);

// Remove any empty parameters from the filter array
$filters = array_filter($filters, function($value) {
    return !empty($value);
});

$filterQuery = http_build_query($filters);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Print Data</h1>
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
            'Designing' => $_GET['Designing_filter'] ?? '',
            'size' => $_GET['size_filter'] ?? '',
            'date' => $_GET['date_filter'] ?? '',
            'total_amount' => $_GET['total_amount_filter'] ?? '',
            'RVD' => $_GET['RVD_filter'] ?? '',
            'Pending' => $_GET['Pending_filter'] ?? '',
            'remark' => $_GET['remark_filter'] ?? ''
        );

        $filterQuery = "";
        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $filterQuery .= " AND $field LIKE '%$value%'";
            }
        }

        $sql = "SELECT * FROM data_entry WHERE 1" . $filterQuery;
        $result = $conn->query($sql);

        echo "<div class='table-responsive'>
                <table class='table table-striped'>
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
                    <tbody>";

        $serialNumber = 1;
        $totalQuantity = 0;
        $totalAmount = 0;
        $totalRVD = 0;
        $totalPending = 0;

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $serialNumber . "</td>";
            echo "<td>" . $row['Date'] . "</td>";
            echo "<td>" . $row['party_name'] . "</td>";
            echo "<td>" . $row['job'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['quality'] . "</td>";
            echo "<td>" . $row['amount'] . "</td>";
            echo "<td>" . $row['Designing'] . "</td>";
            echo "<td>" . $row['size'] . "</td>";
            echo "<td>" . $row['total_amount'] . "</td>";
            echo "<td>" . $row['RVD'] . "</td>";
            echo "<td>" . $row['Pending'] . "</td>";
            echo "<td>" . $row['remark'] . "</td>";
            echo "</tr>";

            // Update the total values
            $totalQuantity += intval($row['quantity']);
            $totalAmount += floatval($row['amount']);
            $totalRVD += intval($row['RVD']);
            if ($row['Pending'] === 'Pending') {
                $totalPending++;
            }

            $serialNumber++;
        }

        echo "</tbody>
            </table>
        </div>";

        $conn->close();
        ?>
        <div class="mt-3">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Amount</th>
                        <td><?php echo $totalAmount; ?></td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td><?php echo $totalQuantity; ?></td>
                    </tr>
                    <tr>
                        <th>Pending</th>
                        <td><?php echo $totalPending; ?></td>
                    </tr>
                    <tr>
                        <th>RVD</th>
                        <td><?php echo $totalRVD; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button onclick="window.print();" class="btn btn-secondary no-print">Print Page</button>
    </div>
</body>
</html>
