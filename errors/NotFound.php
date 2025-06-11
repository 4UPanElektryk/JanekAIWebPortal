<?php
// errors/NotFound.php
http_response_code(404);
header("Content-Type: text/html; charset=UTF-8");
// Display a simple 404 Not Found page

if ($_SERVER['REQUEST_URI'] !== '/errors/NotFound.php') {
	header("Location: /errors/NotFound.php");
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/style.css">
	<script src="../scripts/mode.js"></script>
	<title>404 Not Found</title>
</head>
<body>
	<div class="container">
		<h1>404 Not Found</h1>
		<p>Sorry, the page you are looking for does not exist.</p>
		<p><a href="../index.php">Go back to the homepage</a></p>
		<?php if (date('n') == 6): ?>
			<div class="textblock-dark rainbow-bg">
				<h2>Szczęśliwego geja!</h2>
			</div>
		<?php endif; ?>
	</div>
</body>
</html>