<?php
include '../config.php';

// Fetch menu items for combo box
function getMenuItems() {
    $conn = connectToDatabase();
    $sql = "SELECT idmenu, namamenu, harga FROM menu";
    $result = $conn->query($sql);
    $menuItems = array();
    while ($row = $result->fetch_assoc()) {
        $menuItems[$row['idmenu']] = ['nama' => $row['namamenu'], 'harga' => $row['harga']];
    }
    $conn->close();
    return $menuItems;
}

// Fetch customers for combo box
function getCustomers() {
    $conn = connectToDatabase();
    $sql = "SELECT idpelanggan, namapelanggan FROM pelanggan";
    $result = $conn->query($sql);
    $customers = array();
    while ($row = $result->fetch_assoc()) {
        $customers[$row['idpelanggan']] = $row['namapelanggan'];
    }
    $conn->close();
    return $customers;
}

// Fetch users for combo box
function getUsers() {
    $conn = connectToDatabase();
    $sql = "SELECT iduser, namauser FROM user";
    $result = $conn->query($sql);
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[$row['iduser']] = $row['namauser'];
    }
    $conn->close();
    return $users;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idmenu = $_POST['idmenu'];
    $idpelanggan = $_POST['idpelanggan'];
    $jumlah = $_POST['jumlah'];
    $iduser = $_POST['iduser'];

    // Retrieve the price of the selected menu item
    $menuItems = getMenuItems();
    $harga = $menuItems[$idmenu]['harga'];

    // Calculate total price
    $totalPrice = $harga * $jumlah;

    // Add order to the 'pesanan' table
    $conn = connectToDatabase();
    $sql = "INSERT INTO pesanan (idmenu, idpelanggan, jumlah, iduser, total_harga) VALUES ('$idmenu', '$idpelanggan', '$jumlah', '$iduser', '$totalPrice')";
    if ($conn->query($sql) === TRUE) {
        // Retrieve the last inserted ID
        $idpesanan = $conn->insert_id;

        // Insert transaction into the 'transaction' table
        $sql = "INSERT INTO transaksi (idpesanan, total) VALUES ('$idpesanan', '$totalPrice')";
        if ($conn->query($sql) === TRUE) {
            echo "Order added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Add Order</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label>Menu:</label>
                <select name="idmenu" class="form-control" required>
                    <option value="">Select Menu</option>
                    <?php foreach (getMenuItems() as $id => $menu): ?>
                        <option value="<?php echo $id; ?>"><?php echo $menu['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Customer:</label>
                <select name="idpelanggan" class="form-control" required>
                    <option value="">Select Customer</option>
                    <?php foreach (getCustomers() as $id => $nama): ?>
                        <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Total Harga:</label>
                <input type="text" name="total_harga" id="total_harga" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>User:</label>
                <select name="iduser" class="form-control" required>
                    <option value="">Select User</option>
                    <?php foreach (getUsers() as $id => $nama): ?>
                        <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="calculateTotal()">Calculate Total</button>
            <button type="submit" class="btn btn-success">Add Order</button>
        </form>
    </div>

    <script>
        function calculateTotal() {
            var jumlah = document.getElementById('jumlah').value;
            var idmenu = document.getElementsByName('idmenu')[0].value;
            var harga = <?php echo json_encode(getMenuItems()); ?>[idmenu].harga;
            var totalHarga = jumlah * harga;
            document.getElementById('total_harga').value = totalHarga;
        }
    </script>
</body>
</html>
