<?php
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT SUM(amount) AS total_income FROM data_entry";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalIncome = $row['total_income'];

$sql = "SELECT SUM(rvd) AS total_expenses FROM data_entry";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalExpenses = $row['total_expenses'];

$netProfit = $totalIncome - $totalExpenses;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit and Loss Statement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Profit and Loss Statement</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Income</th>
                    <th>Expenses</th>
                    <th>Net Profit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo '$' . number_format($totalIncome, 2); ?></td>
                    <td><?php echo '$' . number_format($totalExpenses, 2); ?></td>
                    <td><?php echo '$' . number_format($netProfit, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
