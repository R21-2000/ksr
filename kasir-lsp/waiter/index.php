<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Display</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Menu Data</h2>
        <!-- Display existing menu items -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include '../config.php';
                $conn = connectToDatabase();
                $sql = "SELECT * FROM menu";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['namamenu']; ?></td>
                        <td><?php echo $row['harga']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
