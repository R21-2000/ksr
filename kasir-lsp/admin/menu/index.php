<?php
include '../../config.php';

// Function to fetch all menu items
function getAllMenuItems() {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Function to add a new menu item
function addMenuItem($namamenu, $harga) {
    $conn = connectToDatabase();
    $sql = "INSERT INTO menu (namamenu, harga) VALUES ('$namamenu', '$harga')";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Function to update a menu item
function updateMenuItem($idmenu, $namamenu, $harga) {
    $conn = connectToDatabase();
    $sql = "UPDATE menu SET namamenu='$namamenu', harga='$harga' WHERE idmenu='$idmenu'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Function to delete a menu item
function deleteMenuItem($idmenu) {
    $conn = connectToDatabase();
    $sql = "DELETE FROM menu WHERE idmenu='$idmenu'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $namamenu = $_POST['namamenu'];
        $harga = $_POST['harga'];
        if (addMenuItem($namamenu, $harga)) {
            header("Location: index.php");
            exit();
        }
    } elseif (isset($_POST['update'])) {
        $idmenu = $_POST['idmenu'];
        $namamenu = $_POST['namamenu'];
        $harga = $_POST['harga'];
        if (updateMenuItem($idmenu, $namamenu, $harga)) {
            header("Location: index.php");
            exit();
        }
    } elseif (isset($_POST['delete'])) {
        $idmenu = $_POST['idmenu'];
        if (deleteMenuItem($idmenu)) {
            header("Location: index.php");
            exit();
        }
    }
}

// Fetch all menu items
$menuItems = getAllMenuItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Menu</h2>
        <!-- Form to add a new menu item -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label>Nama Menu:</label>
                <input type="text" name="namamenu" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <button type="submit" name="create" class="btn btn-success">Add Menu Item</button>
        </form>
        <hr>
        <!-- Display existing menu items -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $menuItems->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['namamenu']; ?></td>
                        <td><?php echo $row['harga']; ?></td>
                        <td>
                            <a href="edit_menu.php?id=<?php echo $row['idmenu']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="idmenu" value="<?php echo $row['idmenu']; ?>">
                                <button type="submit" name="delete" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
