<?php
include '../../config.php'; // Include the configuration file

// Read operation - Fetch all records from "meja" table
$conn = connectToDatabase();
$sql = "SELECT * FROM meja";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD for Meja</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">CRUD for Meja</h2>
        <!-- Table to display records -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nomor Meja</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nomor_meja']; ?></td>
                        <td><?php echo $row['kapasitas']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href="edit_meja.php?id=<?php echo $row['idmeja']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_meja.php?id=<?php echo $row['idmeja']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="add_meja.php" class="btn btn-success">Add Meja</a>
    </div>
</body>
</html>
