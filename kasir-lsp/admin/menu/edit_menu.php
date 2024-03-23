<?php
include '../../config.php';

// Retrieve the menu item to be edited
if (isset($_GET['id'])) {
    $idmenu = $_GET['id'];
    $conn = connectToDatabase();
    $sql = "SELECT * FROM menu WHERE idmenu='$idmenu'";
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
    <title>Edit Menu Item</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Menu Item</h2>
        <!-- Form to edit an existing menu item -->
        <form method="POST" action="index.php">
            <input type="hidden" name="idmenu" value="<?php echo $row['idmenu']; ?>">
            <div class="form-group">
                <label>Nama Menu:</label>
                <input type="text" name="namamenu" class="form-control" value="<?php echo $row['namamenu']; ?>" required>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" class="form-control" value="<?php echo $row['harga']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Menu Item</button>
            <a href="menu.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
