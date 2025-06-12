<?php
session_start(); // Start the session for user authentication
function GetConection() {
    /*require_once 'creds.php'; // Include database credentials
    if (empty($servername) || empty($database) || empty($username) || empty($password)) {
        echo "Database credentials are not set.";
        die();
    }*/
    $servername = "localhosy"; // Database server
    $database = "JanekAI"; // Database name
    $username = "root"; // Database username
    $password = ""; // Database password
    $servername = getenv('DB_SERVER') ?? $servername;
    $database = getenv('DB_NAME') ?? $database;
    $username = getenv('DB_USER') ?? $username;
    $password = getenv('DB_PASSWORD') ?? $password;
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
    $query = "SELECT Type FROM Users WHERE id = :id";
    $conn = GetConection();
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['Type'] === 'Admin') {
        return true; // Set session variable for admin status
    } else {
        return false; // Set session variable for non-admin status
    }
    return false;
}
?>