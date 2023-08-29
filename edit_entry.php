<?php
            session_start();

            $servername = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";
            $username = "admin";
            $password = "ashu1234";
            $dbname = "test_save";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

                $updateSql = "UPDATE data_entry SET
                            party_name = '$party_name',
                            job = '$job',
                            quantity = '$quantity',
                            quality = '$quality',
                            amount = '$amount',
                            Designing = '$Designing',
                            size = '$size',
                            Date = '$Date',
                            total_amount = '$total_amount',
                            RVD = '$RVD',
                            Pending = '$Pending',
                            remark = '$remark'
                            WHERE id = '$id'";

                if ($conn->query($updateSql) === TRUE) {
                    header("Location: /fetch_data.php");
                    exit();
                } else {
                    echo "Error updating entry: " . $conn->error;
                }
            }

            $id = $_GET['id'];

            $editSql = "SELECT * FROM data_entry WHERE id = '$id'";
            $editResult = $conn->query($editSql);

            if ($editResult->num_rows === 1) {
                $editRow = $editResult->fetch_assoc();
            } else {
                echo "Entry not found";
            }
            ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
   <script>
    function updateCalculations() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const designing = parseFloat(document.getElementById('Designing').value) || 0;
        const rvd = parseFloat(document.getElementById('RVD').value) || 0;

        const totalAmount = amount + designing;
        const pending = totalAmount - rvd;

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        document.getElementById('Pending').value = pending.toFixed(2);
    }

    // Attach the updateCalculations function to relevant input fields' input event
    document.getElementById('amount').addEventListener('input', updateCalculations);
    document.getElementById('Designing').addEventListener('input', updateCalculations);
    document.getElementById('RVD').addEventListener('input', updateCalculations);

    // Initial calculations
    updateCalculations();
</script>

</head>
<body>
    <div class="container mt-5">
        <h1>Edit Entry</h1>
        <form method="post" action="">
            
            
            <input type="hidden" name="id" value="<?php echo $editRow['id']; ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="party_name" class="form-label">Party Name:</label>
                        <input type="text" class="form-control" id="party_name" name="party_name" value="<?php echo $editRow['party_name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="job" class="form-label">Job:</label>
                        <input type="text" class="form-control" id="job" name="job" value="<?php echo $editRow['job']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $editRow['quantity']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="quality" class="form-label">Quality:</label>
                        <input type="text" class="form-control" id="quality" name="quality" value="<?php echo $editRow['quality']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount:</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $editRow['amount']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Designing" class="form-label">Designing:</label>
                        <input type="text" class="form-control" id="Designing" name="Designing" value="<?php echo $editRow['Designing']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="size" class="form-label">Size:</label>
                        <input type="text" class="form-control" id="size" name="size" value="<?php echo $editRow['size']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Date" class="form-label">Date:</label>
                        <input type="text" class="form-control" id="Date" name="Date" value="<?php echo $editRow['Date']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Total Amount:</label>
                        <input type="text" class="form-control" id="total_amount" name="total_amount" value="<?php echo $editRow['total_amount']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="RVD" class="form-label">RVD:</label>
                        <input type="text" class="form-control" id="RVD" name="RVD" value="<?php echo $editRow['RVD']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Pending" class="form-label">Pending:</label>
                        <input type="text" class="form-control" id="Pending" name="Pending" value="<?php echo $editRow['Pending']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark:</label>
                        <input type="text" class="form-control" id="remark" name="remark" value="<?php echo $editRow['remark']; ?>">
                    </div>
                </div>
            </div>
            
            <!-- Additional buttons -->
            <div class="mt-3">
                <button type="button" class="btn btn-secondary" onclick="updateCalculations()">Update Calculations</button>
                <button type="submit" class="btn btn-primary">Update Entry</button>
            </div>
        </form>
    </div>
</body>
</html>
