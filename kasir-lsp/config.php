<?php

function connectToDatabase() {
    return new mysqli("localhost", "root", "", "kasir");
}

// Example usage:
$conn = connectToDatabase();
// Now you can use $conn to execute queries on the database


// Function to add a new record to the "meja" table
function addMeja($nomor_meja, $kapasitas, $status) {
    $conn = connectToDatabase();
    $nomor_meja = $conn->real_escape_string($nomor_meja);
    $kapasitas = $conn->real_escape_string($kapasitas);
    $status = $conn->real_escape_string($status);

    $sql = "INSERT INTO meja (nomor_meja, kapasitas, status) VALUES ('$nomor_meja', '$kapasitas', '$status')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    $conn->close();
}

// Function to update an existing record in the "meja" table
function updateMeja($idmeja, $nomor_meja, $kapasitas, $status) {
    $conn = connectToDatabase();
    $idmeja = $conn->real_escape_string($idmeja);
    $nomor_meja = $conn->real_escape_string($nomor_meja);
    $kapasitas = $conn->real_escape_string($kapasitas);
    $status = $conn->real_escape_string($status);

    $sql = "UPDATE meja SET nomor_meja='$nomor_meja', kapasitas='$kapasitas', status='$status' WHERE idmeja='$idmeja'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    $conn->close();
}

// Function to delete a record from the "meja" table
function deleteMeja($idmeja) {
    $conn = connectToDatabase();
    $idmeja = $conn->real_escape_string($idmeja);

    $sql = "DELETE FROM meja WHERE idmeja='$idmeja'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    $conn->close();
}

?>
