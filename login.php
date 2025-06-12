<?php
require_once './inc/ext.php';

// If already logged in, redirect to index
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ./index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simple hardcoded credentials for demonstration
    
    $username = $_POST['username'] ?? '';
    $password = hash_hmac("sha256", $_POST["password"], "real", false);

    $query = "SELECT * FROM Users WHERE Username = :username AND PasswordHash = :password";
    $stmt = GetConection()->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // User found, set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['Username'];
        $_SESSION['id'] = $user['ID'];
        $_SESSION['is_admin'] = $user['Type'] == "Admin";
        header("Location: index.php");
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Janek.AI Survey</title>
    <link rel="stylesheet" href="./styles/flow.css">
    <script src="./scripts/mode.js"></script>
</head>
<body class="dark">
    <div class="container">
        <h2>JanekAI</h2>
        <?php if ($error): ?>
            <div class="textblock-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autofocus>
            <br><br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" class="button-default" value="Login">
        </form>
    </div>
</body>
</html>