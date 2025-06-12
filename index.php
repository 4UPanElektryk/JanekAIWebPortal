<?php
require_once './inc/ext.php';
require_once './inc/flags.php';
if (!UserLoggedIn()) {
	header("Location: ./login.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Experience Program - Janek.AI</title>
	<link rel="stylesheet" href="./styles/flow.css">
	<script src="./scripts/mode.js"></script>
</head>
<body>
	<div class="container">
		<div class="floating-island">
			<a class="button-default" href="./logout.php"><ion-icon name="log-out"></ion-icon></a>
			<button id="button-mode"><ion-icon name="contrast"></ion-icon></button>
		</div>
		<h2>User Experience Program</h2>
		<p> Welcome <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>!</p>
		<?php if (date('n') == 6 && IsEnabled("pride_month_message")): ?>
			<div class="textblock-dark">
			<h2 class="rainbow">Szczęśliwego geja!</h2>
			</div>
		<?php endif; ?>


		<?php if (UserIsAdmin()): ?>
			<div class="textblock-dark">
				<div class="textblock-title">
					<ion-icon name="moon"></ion-icon> Dark
				</div>
				<p>As an admin, you can manage the User Experience Program.</p>
				<a class="button-dark" href="./dashboard/index.php">Dashboard</a>
			</div>
			<?php endif; ?>
			<?php if (IsEnabled('ai_survey')): ?>
				<div class="textblock-default">
					<div class="textblock-title">
						<ion-icon name="information-circle"></ion-icon> Information
					</div>
					<p>Thank you for being a part of our User Experience Program! Your feedback is invaluable.</p>
					<a href="./ai_survey/index.php" class="button-information" > Go to the survey </a>
			</div>
		<?php endif; ?>
			<div class="textblock-error">
				<div class="textblock-title">
					<ion-icon name="warning"></ion-icon> Error
				</div>
				<p></p>
				<a href="./styles/styletest.html" class="button-dark rainbow-bg">Test</a>
			</div>
		<p>Thank you for participating in our User Experience Program!</p>
	</div>
</body>
</html>