<?php
// If a post request is submitted check contents of request
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	/* ---------------- */
	/* On Start         */
	/* ---------------- */

	/* Check what user id was entered, and pick captcha order */
	/* based on that number */

	if (isset($_POST['user_id'])) {
		$userID = $_POST['user_id'];
		echo $userID;

		// Start session variable to track order

		// Figure out order based on userID

		// Redirect to first captcha to start
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Captcha Study - Main</title>
	<link rel="stylesheet" href="main.css" type="text/css">
</head>

<body>
<div id="content">
	<h1> Captcha Study Start Page </h1>
	<div id="form">
		<form method="post">

			<div id="user_id">
				<p><label for="user_id">Enter User ID</label></p>
				<input type="text" id="user_id" name="user_id" size="20"><br>
			</div>

			<input type="submit" value="Start" id="btn">
		</form>
	</div>
</div>

</body>
</html>