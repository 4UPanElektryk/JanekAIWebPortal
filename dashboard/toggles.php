<?php
require_once '../inc/ext.php';
require_once '../inc/flags.php';

if (!UserLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if (!UserIsAdmin()) {
    header('Location: ../index.php');
    exit;
}

$conn = GetConection();

$query = "SELECT `Name`, `Enabled` FROM `FeatureFlags`;";
$result = $conn->query($query);

$bigUpadte = "";
foreach ($result as $row) {
    $flagName = $row['Name'];
    $flagValue = isset($_POST[$flagName]) ? true : false; // Check if the flag is set in the POST data
    // Prepare the update statement for each flag
    $bigUpadte .= "UPDATE `FeatureFlags` SET `Enabled` = " . ($flagValue ? '1' : '0') . " WHERE `Name` = '$flagName';";
}
$bigUpadte = rtrim($bigUpadte, ';');
$conn->exec($bigUpadte);

header('Location: ./index.php');
print_r($_POST);
?>
