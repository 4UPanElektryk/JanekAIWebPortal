<?php
require_once 'ext.php';

$flags = array(
);

function onLoad(){
    global $flags;
    $conn = GetConection();
    $query = "SELECT * FROM `FeatureFlags`;";
    $result = $conn->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $flagName = $row['Name'];
        $flagValue = $row['Enabled'];
        $flagDescription = $row['Description'] ?? ''; // Use null coalescing operator to handle missing description
        if (isset($flags[$flagName])) {
            $flags[$flagName]['enabled'] = $flagValue; // Convert to boolean
        } else {
            // If the flag does not exist in the predefined array, you can choose to ignore it or handle it differently
            $flags[$flagName] = array(
                'name' => $flagName,
                'description' => $flagDescription,
                'enabled' => $flagValue
            );
        }
    }
}
onLoad(); // Load flags from the database when the script is included

function IsEnabled($flag) {
    global $flags;
    if (isset($flags[$flag]) && isset($flags[$flag]['enabled'])) {
        return $flags[$flag]['enabled'];
    }
    return false; // Default to false if flag is not set or not enabled
}
?>