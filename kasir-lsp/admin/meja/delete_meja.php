<?php
include '../../config.php'; // Include the configuration file

// Check if the "id" parameter is present in the URL
if (isset($_GET['id'])) {
    $idmeja = $_GET['id'];
    
    // Delete the record from the "meja" table
    if (deleteMeja($idmeja)) {
        // Redirect to the display page after successful deletion
        header("Location: meja.php");
        exit();
    } else {
        echo "Error: Unable to delete record.";
    }
}
?>
