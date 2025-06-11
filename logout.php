<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
// Unset all session variables
session_destroy();

// Redirect to login page
header("Location: login.php");
