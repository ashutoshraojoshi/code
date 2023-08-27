<?php
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$party_name = $_POST['party_name'];
$job = $_POST['job'];
$quantity = $_POST['quantity'];
$quality = $_POST['quality'];
$amount = $_POST['amount'];
$Designing = $_POST['Designing'];
$size = $_POST['size'];
$Date = $_POST['Date'];
$total_amount = $_POST['total_amount'];
$RVD = $_POST['RVD'];
$Pending = $_POST['Pending'];
$remark = $_POST['remark'];

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
