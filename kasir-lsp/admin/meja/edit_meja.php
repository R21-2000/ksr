<?php
include '../../config.php'; // Include the configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract values from the form
    $idmeja = $_POST['idmeja'];
    $nomor_meja = $_POST['nomor_meja'];
    $kapasitas = $_POST['kapasitas'];
    $status = $_POST['status'];

    // Update the existing record in the "meja" table
    if (updateMeja($idmeja, $nomor_meja, $kapasitas, $status)) {
        // Redirect to the display page after successful update
        header("Location: meja.php");
        exit();
    } else {
        echo "Error: Unable to update record.";
    }
}

// Retrieve the record to be edited
if (isset($_GET['id'])) {
    $idmeja = $_GET['id'];
    $conn = connectToDatabase();
    $sql = "SELECT * FROM meja WHERE idmeja='$idmeja'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meja</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            max-width: 600px;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Meja</h2>
        <!-- Form to edit an existing record -->
        <form method="POST">
            <input type="hidden" name="idmeja" value="<?php echo $row['idmeja']; ?>">
            <div class="form-group">
                <label>Nomor Meja:</label>
                <input type="text" name="nomor_meja" class="form-control" value="<?php echo $row['nomor_meja']; ?>" required>
            </div>
            <div class="form-group">
                <label>Kapasitas:</label>
                <input type="number" name="kapasitas" class="form-control" value="<?php echo $row['kapasitas']; ?>" required>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="form-control" required>
                    <option value="Available" <?php if($row['status'] == 'Available') echo 'selected'; ?>>Available</option>
                    <option value="Occupied" <?php if($row['status'] == 'Occupied') echo 'selected'; ?>>Occupied</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-dark">Update Meja</button>
            <a href="meja.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
