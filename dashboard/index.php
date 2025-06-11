<?php
require_once './../inc/ext.php';
$conn = GetConection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard - Janek.AI</title>
	<link rel="stylesheet" href="./../styles/flow.css">
	<script src="./../scripts/mode.js"></script>
</head>
<body>
	<div class="floating-island">
		<a class="button-default" href="./../index.php"><ion-icon name="arrow-back"></ion-icon></a>
		<button id="button-mode"><ion-icon name="contrast"></ion-icon></button>
	</div>
	<div class="container">
		<h1>AI Survey</h1>
		<table>
			<tr>
				<th>Username</th>
				<th>Filled</th>
			</tr>
			<?php
			$query = "SELECT `Users`.`Username`, SUM(1) as Amount FROM `MessageFeedback` JOIN `Users` ON `Users`.`ID` = `MessageFeedback`.`UserID` GROUP BY `Users`.`Username`; ";
			$result = $conn->query($query);
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>';
				echo '<td>';
				echo htmlspecialchars($row['Username']);
				echo '</td>';
				echo '<td>';
				echo htmlspecialchars($row['Amount']);
				echo '</td>';
				echo '</tr>';
			}
			?>
		</table>

		<h1>Regisered Users</h1>
		<table>

		</table>
	</div>
	</body>
</html>