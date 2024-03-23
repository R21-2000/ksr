<?php
include '../config.php';

// Function to fetch order IDs for combo box
function getOrderIDs() {
    $conn = connectToDatabase();
    $sql = "SELECT idpesanan FROM transaksi GROUP BY idpesanan";
    $result = $conn->query($sql);
    $orderIDs = array();
    while ($row = $result->fetch_assoc()) {
        $orderIDs[] = $row['idpesanan'];
    }
    $conn->close();
    return $orderIDs;
}

// Function to fetch transaction details based on selected order ID
function getTransactionDetails($idpesanan) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM transaksi WHERE idpesanan = '$idpesanan'";
    $result = $conn->query($sql);
    $transactionDetails = array();
    while ($row = $result->fetch_assoc()) {
        $transactionDetails[] = $row;
    }
    $conn->close();
    return $transactionDetails;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idpesanan = $_POST['idpesanan'];

    // If "bayar" form field is set and not empty, update and then delete the record
    if (isset($_POST['bayar']) && !empty($_POST['bayar'])) {
        $bayar = $_POST['bayar'];

        // Update and then delete the record
        $conn = connectToDatabase();
        $update_sql = "UPDATE transaksi SET bayar = '$bayar' WHERE idpesanan = '$idpesanan'";
        $delete_sql = "DELETE FROM transaksi WHERE idpesanan = '$idpesanan'";

        if ($conn->query($update_sql) === TRUE) {
            // Record updated, now delete it
            if ($conn->query($delete_sql) === TRUE) {
                echo "Transaction completed and data deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Transaksi Details</h2>
        <!-- Form for selecting order ID -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label>Select Order ID:</label>
                <select name="idpesanan" class="form-control" required>
                    <option value="">Select Order ID</option>
                    <?php foreach (getOrderIDs() as $id): ?>
                        <option value="<?php echo $id; ?>"><?php echo $id; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Show Details</button>
        </form>

        <!-- Display transaction details if form is submitted -->
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($idpesanan)): ?>
            <h3 class="mt-4">Transaction Details for Order ID: <?php echo $idpesanan; ?></h3>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Total</th>
                            <th>Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (getTransactionDetails($idpesanan) as $transaction): ?>
                            <tr>
                                <td><?php echo $transaction['idtransaksi']; ?></td>
                                <td><?php echo $transaction['total']; ?></td>
                                <!-- Display "bayar" column as an input field -->
                                <td>
                                    <input type="number" name="bayar" class="form-control" required>
                                    <input type="hidden" name="idpesanan" value="<?php echo $idpesanan; ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Submit button to complete the transaction and delete the data -->
                <button type="submit" class="btn btn-primary">Complete Transaction & Delete Data</button>
                <!-- Button to print the transaction details -->
                <button type="button" class="btn btn-success" onclick="printTransaction()">Print</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- JavaScript for printing transaction details -->
    <script>
        function printTransaction() {
            window.print();
        }
    </script>
</body>
</html>
