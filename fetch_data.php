<?php
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete'])) {
    $deleteId = $_POST['delete_id'];
    $deleteSql = "DELETE FROM data_entry WHERE id = '$deleteId'";
    if ($conn->query($deleteSql) === TRUE) {
        // Record deleted successfully
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Define filter variables and get filter values from GET parameters
$filters = array(
    'party_name' => $_GET['party_filter'] ?? '',
    'job' => $_GET['job_filter'] ?? '',
    'quantity' => $_GET['quantity_filter'] ?? '',
    'quality' => $_GET['quality_filter'] ?? '',
    'amount' => $_GET['amount_filter'] ?? '',
    'Designing' => $_GET['designing_filter'] ?? '',
    'size' => $_GET['size_filter'] ?? '',
    'Date' => $_GET['date_filter'] ?? '',
    'total_amount' => $_GET['total_amount_filter'] ?? '',
    'RVD' => $_GET['rvd_filter'] ?? '',
    'Pending' => $_GET['pending_filter'] ?? '',
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.html">Home</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5">Display Data</h1>
        <div class="filters mt-3">
            <form method="get">
                <div class="row g-3">
                    <!-- Add filter input fields for each field -->
                    <div class="col-md-2">
                        <label for="party_filter" class="form-label">Party Name:</label>
                        <input type="text" class="form-control" id="party_filter" name="party_filter" value="<?php echo $filters['party_name']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="job_filter" class="form-label">Job:</label>
                        <input type="text" class="form-control" id="job_filter" name="job_filter" value="<?php echo $filters['job']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="quantity_filter" class="form-label">Quantity:</label>
                        <input type="text" class="form-control" id="quantity_filter" name="quantity_filter" value="<?php echo $filters['quantity']; ?>">
                    </div>
                    <!-- Add more filter input fields for other fields -->
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['party_name'] . "</td>";
                            echo "<td>" . $row['job'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['quality'] . "</td>";
                            echo "<td>" . $row['amount'] . "</td>";
                            echo "<td>" . $row['Designing'] . "</td>";
                            echo "<td>" . $row['size'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td>" . $row['total_amount'] . "</td>";
                            echo "<td>" . $row['RVD'] . "</td>";
                            echo "<td>" . ($row['Pending'] == 1 ? 'Pending' : 'Not Pending') . "</td>";
                            echo "<td>" . $row['remark'] . "</td>";
                            echo "<td>
                                    <form method='post'>
                                        <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                        <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='14'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
    <a href="export_pdf.php<?php echo $filterQuery; ?>" class="btn btn-primary">Export as PDF</a>
    <a href="export_excel.php<?php echo $filterQuery; ?>" class="btn btn-primary">Export as Excel</a>
</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
