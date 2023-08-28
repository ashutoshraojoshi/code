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

$filters = array(
    'party_name' => $_GET['party_filter'] ?? '',
    'job' => $_GET['job_filter'] ?? '',
    'quantity' => $_GET['quantity_filter'] ?? '',
    'quality' => $_GET['quality_filter'] ?? '',
    'amount' => $_GET['amount_filter'] ?? '',
    'Designing' => $_GET['designing_filter'] ?? '', // Use "designing" instead of "Designing"
    'size' => $_GET['size_filter'] ?? '',
    'date' => $_GET['date_filter'] ?? '',
    'total_amount' => $_GET['total_amount_filter'] ?? '',
    'RVD' => $_GET['rvd_filter'] ?? '', // Use "rvd" instead of "RVD"
    'Pending' => $_GET['pending_filter'] ?? '', // Use "pending" instead of "Pending"
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
        .filters {
            margin-bottom: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            max-width: 100%;
        }
        th, td {
            white-space: nowrap;
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
                    <div class="col-md-2">
                        <label for="quality_filter" class="form-label">Quality:</label>
                        <input type="text" class="form-control" id="quality_filter" name="quality_filter" value="<?php echo $filters['quality']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="amount_filter" class="form-label">Amount:</label>
                        <input type="text" class="form-control" id="amount_filter" name="amount_filter" value="<?php echo $filters['amount']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="designing_filter" class="form-label">Designing:</label>
                        <input type="text" class="form-control" id="designing_filter" name="designing_filter" value="<?php echo $filters['Designing']; ?>">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="size_filter" class="form-label">Size:</label>
                        <input type="text" class="form-control" id="size_filter" name="size_filter" value="<?php echo $filters['size']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="date_filter" class="form-label">Date:</label>
                        <input type="text" class="form-control" id="date_filter" name="date_filter" value="<?php echo $filters['date']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="total_amount_filter" class="form-label">Total Amount:</label>
                        <input type="text" class="form-control" id="total_amount_filter" name="total_amount_filter" value="<?php echo $filters['total_amount']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="rvd_filter" class="form-label">RVD:</label>
                        <input type="text" class="form-control" id="rvd_filter" name="rvd_filter" value="<?php echo $filters['RVD']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="pending_filter" class="form-label">Pending:</label>
                        <input type="text" class="form-control" id="pending_filter" name="pending_filter" value="<?php echo $filters['Pending']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="remark_filter" class="form-label">Remark:</label>
                        <input type="text" class="form-control" id="remark_filter" name="remark_filter" value="<?php echo $filters['remark']; ?>">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>
        
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $serialNumber = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $serialNumber . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td>" . $row['party_name'] . "</td>";
                            echo "<td>" . $row['job'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['quality'] . "</td>";
                            echo "<td>" . $row['amount'] . "</td>";
                            echo "<td>" . (isset($row['Designing']) ? $row['Designing'] : '') . "</td>";
                            echo "<td>" . $row['size'] . "</td>";
                            echo "<td>" . $row['total_amount'] . "</td>";
                            echo "<td>" . (isset($row['RVD']) ? $row['RVD'] : '') . "</td>";
                            echo "<td>" . (isset($row['Pending']) ? $row['Pending'] : '') . "</td>";
                            echo "<td>" . $row['remark'] . "</td>";
                            echo "<td>
                                    <form method='post' class='d-inline'>
                                        <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                        <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                                    </form>
                                    <a href='edit_entry.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                  </td>";
                            echo "</tr>";
                            $serialNumber++;
                        }
                    } else {
                        echo "<tr><td colspan='14'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Inside the <div class="mt-3"> section -->
<a href="print_page.php<?php echo $filterQuery; ?>" class="btn btn-primary">Print</a>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
