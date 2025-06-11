<?php
session_start(); // Start the session for user authentication
function GetConection() {
    require_once 'creds.php'; // Include database credentials
    if (empty($servername) || empty($database) || empty($username) || empty($password)) {
        echo "Database credentials are not set.";
        die();
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}

function UserLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}
function UserIsAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

function GenHeadSection($title = "Janek.AI") {
    echo '<title>' . htmlspecialchars($title) . '</title>
        <link rel="stylesheet" href="./../style.css">
        <script type="module" src="./../js/mode.js"></script>
        ';
}
?>