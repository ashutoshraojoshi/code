<?php
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Input validation and escaping to prevent SQL injection
$party_name = $conn->real_escape_string($_POST['party_name']);
$job = $conn->real_escape_string($_POST['job']);
$quantity = $conn->real_escape_string($_POST['quantity']);
$quality = $conn->real_escape_string($_POST['quality']);
$amount = $conn->real_escape_string($_POST['amount']);
$Designing = $conn->real_escape_string($_POST['Designing']);
$size = $conn->real_escape_string($_POST['size']);
$Date = $conn->real_escape_string($_POST['Date']);
$total_amount = $conn->real_escape_string($_POST['total_amount']);
$RVD = $conn->real_escape_string($_POST['RVD']);
$Pending = isset($_POST['Pending']) ? $conn->real_escape_string($_POST['Pending']) : '';
$remark = $conn->real_escape_string($_POST['remark']);

$sql = "INSERT INTO data_entry (party_name, job, quantity, quality, amount, Designing, size, Date, total_amount, RVD, Pending, remark)
        VALUES ('$party_name', '$job', '$quantity', '$quality', '$amount', '$Designing', '$size', '$Date', '$total_amount', '$RVD', '$Pending', '$remark')";

if ($conn->query($sql) === TRUE) {
    // Redirect to fetch_data.php
    header("Location: fetch_data.php");
    exit(); // Make sure to exit after the redirect
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
