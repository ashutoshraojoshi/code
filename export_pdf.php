<?php
require('fpdf/fpdf.php');

$servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "ashu1234";
$dbname = "test_save";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define filter variables and get filter values from GET parameters
$filters = array(
    'party_name' => $_GET['party_filter'] ?? '',
    'job' => $_GET['job_filter'] ?? '',
    // ... other filters
);

$filterQuery = "";
foreach ($filters as $field => $value) {
    if (!empty($value)) {
        $filterQuery .= " AND $field LIKE '%$value%'";
    }
}

$sql = "SELECT * FROM data_entry WHERE 1" . $filterQuery;
$result = $conn->query($sql);

class PDF extends FPDF
{
    function Header()
    {
        // Add header content if needed
    }

    function Footer()
    {
        // Add footer content if needed
    }
}

$pdf = new PDF();
$pdf->AddPage();

while ($row = $result->fetch_assoc()) {
    // Add data to the PDF as needed
    $pdf->Cell(40, 10, $row['party_name'], 1, 0, 'C');
    // ... add other cells
    $pdf->Ln();
}

$pdf->Output('data_export.pdf', 'D');
?>
