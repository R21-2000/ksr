<?php
include '../../config.php'; // Include the configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract values from the form
    $nomor_meja = $_POST['nomor_meja'];
    $kapasitas = $_POST['kapasitas'];
    $status = $_POST['status'];

    // Add the new record to the "meja" table
    if (addMeja($nomor_meja, $kapasitas, $status)) {
        // Redirect to the display page after successful addition
        header("Location: meja.php");
        exit();
    } else {
        echo "Error: Unable to add record.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meja</title>
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
        <h2 class="mb-4">Add Meja</h2>
        <!-- Form to add a new record -->
        <form method="POST">
            <div class="form-group">
                <label>Nomor Meja:</label>
                <input type="text" name="nomor_meja" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kapasitas:</label>
                <input type="number" name="kapasitas" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="form-control" required>
                    <option value="Available">Available</option>
                    <option value="Occupied">Occupied</option>
                </select>
            </div>
            <button type="submit" name="create" class="btn btn-dark">Add Meja</button>
            <a href="meja.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
