<?php
$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize updated form data
    $id = $_POST['id'];
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
    
    // Update the entry in the database using the provided fields
    $updateSql = "UPDATE data_entry SET party_name = '$party_name', job = '$job', quantity = '$quantity', quality = '$quality', amount = '$amount', Designing = '$Designing', size = '$size', Date = '$Date', total_amount = '$total_amount', RVD = '$RVD', Pending = '$Pending', remark = '$remark' WHERE id = '$id'";
    
    if ($conn->query($updateSql) === TRUE) {
        // Entry updated successfully
        header("Location: fetch_data.php");
        exit(); // Make sure to exit after the redirect
    } else {
        echo "Error updating entry: " . $conn->error;
    }
}

$conn->close();
?>
