<?php
require_once './../inc/ext.php';
require_once './../inc/flags.php';

if ($flags['ai_survey']['enabled'] !== true) {
    header("Location: index.php");
    exit;
}
/**
 * Janek.AI Character Survey
 * This page processes feedback submitted by users regarding the AI's response
 * about the character of Janek.
 *
 * @package JanekAI
 * @version 1.0
 */
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}
$id = $_POST['id'];
$feedback = $_POST['feedback'];
$accuracy = $_POST['accuracy'];
$rating = $_POST['rating'];

// Database connection
$servername = "localhost";
$database = "janekai";
$username = "root";
$password = "";

$conn = GetConection();
// Prepare and execute the query to insert feedback
$query = "INSERT INTO `MessageFeedback`(`ID`, `MessageID`, `UserID`, `Accuracy`, `Rating`, `Feedback`) VALUES (null, :message_id,:user_id,:accuracy,:rating,:feedback)";
$stmt = $conn->prepare($query);

// Bind parameters to the prepared statement
$stmt->bindParam(':message_id', $id);
$stmt->bindParam(':user_id', $_SESSION['id']);
$stmt->bindParam(':accuracy', $accuracy);
$stmt->bindParam(':rating', $rating);
$stmt->bindParam(':feedback', $feedback);
$stmt->execute();


$query = "SELECT ID FROM `MessageRelevance` WHERE MessageID = :message_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':message_id', $id);
$stmt->execute();
$relevance_id = $stmt->fetchColumn();
if ($relevance_id) {
    $query = "UPDATE `MessageRelevance` SET Score = Score + :relevance WHERE ID = :relevance_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':relevance', $rating);
    $stmt->bindParam(':relevance_id', $relevance_id);
    $stmt->execute();
} else {
    $query = "INSERT INTO `MessageRelevance`(`MessageID`, `Score`) VALUES (:message_id, :relevance)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':message_id', $id);
    $stmt->bindParam(':relevance', $rating);
    $stmt->execute();
}

// Close the connection
//$conn->close();
echo "Relevance updated successfully.";
header("Location: index.php");
?>