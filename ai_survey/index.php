<?php
require_once './../inc/ext.php';
require_once './../inc/flags.php';

if (!IsEnabled('ai_survey')) {
	header("Location: index.php");
	exit;
}


/**
 * Janek.AI Character Survey
 * This page displays a survey for users to provide feedback on the AI's response
 * regarding the character of Janek.
 *
 * @package JanekAI
 * @version 1.0
 */
if (!UserLoggedIn()) {
	header("Location: login.php");
	exit;
}

$model = 'jan-v1_1';

$conn = GetConection();
$query = "SELECT m.* FROM Messages m LEFT JOIN MessageFeedback f ON m.ID = f.MessageID AND f.UserID = :user_id WHERE f.ID IS NULL AND (m.Rating = 1 OR m.Rating = -1) AND m.Model = :model ORDER BY m.ID LIMIT 1; ";

// Prepare and execute the query
$stmt = $conn->prepare($query);
// Bind parameters to the prepared statement

$stmt->bindParam(':user_id', $_SESSION['id']);
$stmt->bindParam(':model', $model);
$stmt->execute();
// Fetch the first row of results
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// If no results found, set default values
if (!$row) {
	// Set default values if no results found
	$id = null;
	$prompt = "No prompt available";
	$response = "No response available";
} else {
	// Extract values from the row
	$id = $row['ID'];
	//print_r($row);
	$prompt = $row['Question'];
	$response = $row['Response'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Janek.AI Character Survey</title>
	<link rel="stylesheet" href="./../styles/flow.css">
	<script src="./../scripts/mode.js"></script>
</head>
<body class="dark">
	<h1>Janek.AI Character Survey</h1>
	<div class="container">
		<div class="floating-island">
			<a class="button-default" href="./../index.php"><ion-icon name="arrow-back"></ion-icon></a>
			<button id="button-mode"><ion-icon name="contrast"></ion-icon></button>
		</div>
		<?php if ($id === null): ?>
			<div class="textblock-success">
				🎉 Thank you! There are no more messages to rate at this time.
			</div>
		<?php else: ?>
		<form action="feedback.php" method="post">
			<p>Welcome, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>!</p>
			<p>Please provide your feedback on the AI's response regarding the character of Janek.</p>
			<h2>Prompt: </h2>
			<p class="textblock-default"> <?php echo htmlspecialchars($prompt ?? ''); ?> </p>
			<h2>Response: </h2>
			<p class="textblock-default"> <?php echo htmlspecialchars($response ?? ''); ?> </p>
			<input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
			<h3>Was the response accurate with the Character of Janek</h3>
			<label><input type="radio" name="accuracy" value="yes" required> Yes</label>
			<label><input type="radio" name="accuracy" value="no"> No</label>
			<label><input type="radio" name="accuracy" value="irrelevant"> Irrelevant</label>
			<br><br>
			<h3>How would you rate the response?</h3>
			<label><input type="radio" name="rating" value="1" required> 1</label>
			<label><input type="radio" name="rating" value="2"> 2</label>
			<label><input type="radio" name="rating" value="3"> 3</label>
			<label><input type="radio" name="rating" value="4"> 4</label>
			<label><input type="radio" name="rating" value="5"> 5</label>
			<br><br>
			<div class="textblock-default" id="inaccurate-feedback" style="display: none;">
				<h3>How do you think the ai should respond?</h3>
				<textarea name="feedback" rows="4" cols="50" placeholder="Response"></textarea>
			</div>
			<br>
			<input type="submit" class="button-success" value="Submit Feedback">
			<input type="reset" class="button-default" value="Reset">
			<script>
			const inaccurateRadio = document.getElementsByName('accuracy');
			const feedbackDiv = document.getElementById('inaccurate-feedback');
			const func = function() {
				if (inaccurateRadio[1].checked) {
					feedbackDiv.style.display = 'block';
				} else {
					feedbackDiv.style.display = 'none';
				}
			};
			inaccurateRadio[0].addEventListener('change', func);
			inaccurateRadio[1].addEventListener('change', func);
			inaccurateRadio[2].addEventListener('change', func);
			</script>
		</form>
		<?php endif; ?>
	</div>
</body>
</html>