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
		$userID = intval($_POST['user_id']);

		// Start session variable to track order
		session_start();

		// Set userId for this session
		$_SESSION['user_id'] = $userID;

		// Figure out order based on userID
		$first = "captcha1";
		$second = "captcha2";
		$third = "captcha3";
		$fourth = "captcha4";
		$fifth = "captcha5";

		// Order 1,2,3,4,5
		if($userID % 5 == 0) {
			$first = "captcha1";
			$second = "captcha2";
			$third = "captcha3";
			$fourth = "captcha4";
			$fifth = "captcha5";
		// Order 5,4,3,2,1
		} elseif($userID % 5 == 1) {
			$first = "captcha5";
			$second = "captcha4";
			$third = "captcha3";
			$fourth = "captcha2";
			$fifth = "captcha1";

		// Order 2,3,4,5,1
		} elseif($userID % 5 == 2) {
			$first = "captcha2";
			$second = "captcha3";
			$third = "captcha4";
			$fourth = "captcha5";
			$fifth = "captcha1";

		// Order 3,4,5,1,2
		} elseif($userID % 5 == 3) {
			$first = "captcha3";
			$second = "captcha4";
			$third = "captcha5";
			$fourth = "captcha1";
			$fifth = "captcha2";

		// Order 1,3,5,2,4
		} elseif($userID % 5 == 4) {
			$first = "captcha1";
			$second = "captcha3";
			$third = "captcha5";
			$fourth = "captcha2";
			$fifth = "captcha4";
		}

		// Set up an array for captcha order
		$captchaOrder = array(
		    "first" => $first,
		    "second" => $second,
		    "third" => $third, 
		    "fourth" => $fourth,
		    "fifth" => $fifth,
		);

		// Set up order for this user for captchas
		$_SESSION['captchaOrder'] = $captchaOrder;

		// Set up the flag session variable to keep track of which captcha the user is on
		$_SESSION['captchaNumber'] = 0;


		// Set variables for times
		$captchaTimes = array(
		    "first" => 0,
		    "second" => 0,
		    "third" => 0, 
		    "fourth" => 0,
		    "fifth" => 0,
		);

		// Set up array to store captcha times
		$_SESSION['captchaTimes'] = $captchaTimes;

		// Set variables for attempts
		$captchaAttempts = array(
		    "first" => 0,
		    "second" => 0,
		    "third" => 0, 
		    "fourth" => 0,
		    "fifth" => 0,
		);

		// Set up array to store captcha times
		$_SESSION['captchaAttempts'] = $captchaAttempts;

		// Set variables for survey results for ease of use
		$captchaEase = array(
		    "first" => "",
		    "second" => "",
		    "third" => "", 
		    "fourth" => "",
		    "fifth" => "",
		);

		// Set up array to store captcha ease answers
		$_SESSION['captchaEase'] = $captchaEase;

		// Set variables for survey results for bot defense
		$captchaBot = array(
		    "first" => "",
		    "second" => "",
		    "third" => "", 
		    "fourth" => "",
		    "fifth" => "",
		);

		// Set up array to store captcha bot defense
		$_SESSION['captchaBot'] = $captchaBot;

		// Set variables for survey results for other comments
		$captchaComments = array(
		    "first" => "",
		    "second" => "",
		    "third" => "", 
		    "fourth" => "",
		    "fifth" => "",
		);

		// Set up array to store captcha other comments
		$_SESSION['captchaComments'] = $captchaComments;

		// Redirect user to correct starting captcha (the first one in the order array)
		$redirectURL = '/' . $_SESSION['captchaOrder']['first'] . '.php';
		header("Location: http://localhost" . $redirectURL);
		die();
	}
} else {
	// Destroy session if no post was made, starting new session
	session_start();
	session_destroy();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Captcha Study - Main</title>
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