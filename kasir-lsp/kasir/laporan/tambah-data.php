<?php
include '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $laporan = $_POST['laporan'];
    $tanggal = $_POST['tanggal'];

    // Insert the report data into the database
    $conn = connectToDatabase();
    $sql = "INSERT INTO laporan (laporan, tanggal) VALUES ('$laporan', '$tanggal')";
    if ($conn->query($sql) === TRUE) {
        echo "Report added successfully";
        header("Location: laporan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
