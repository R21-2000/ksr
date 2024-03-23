<?php
include '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $laporan = $_POST['laporan'];
    $tanggal = $_POST['tanggal'];

    // Insert the report data into the database
    $conn = connectToDatabase();
    $sql = "INSERT INTO laporan (laporan, tanggal) VALUES ('$laporan', '$tanggal')";
    if ($conn->query($sql) === TRUE) {
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
    <title>Laporan Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Laporan Saya</h2>
        <!-- Form for adding a report -->
        <form method="POST">
            <div class="form-group">
                <label for="laporan">Laporan:</label>
                <textarea class="form-control" id="laporan" name="laporan" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" onclick="printReport()">Print Report</button>
            <button type="button" class="btn btn-danger" onclick="clearInput()">Clear Input</button>
        </form>
    </div>

    <script>
        function printReport() {
            // Code to print the report
            window.print();
        }

        function clearInput() {
            // Clear input fields
            document.getElementById('laporan').value = '';
            document.getElementById('tanggal').value = '';
        }
    </script>
</body>
</html>
