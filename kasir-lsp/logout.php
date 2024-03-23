<?php
include 'config.php';

session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['user'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
