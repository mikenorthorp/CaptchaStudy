<?php
	// Save session variable stuff to a log file
	session_start();
	$userID = $_SESSION['user_id'];
	$fileName = $userID . "studyResults.txt";

	// Content variable for file
	$content = "";

	// Captcha information
	$content .= "Captcha 1 - ReCaptcha\n";
	// Time to complete
	$content .= "Time to complete was {$_SESSION['captchaTimes']['first']} seconds\n";
	// Number of attempts
	$content .= "Number of attempts was {$_SESSION['captchaAttempts']['first']}\n";
	// Ease
	$content .= "Ease of captcha was {$_SESSION['captchaEase']['first']}\n";
	// Bot Defense
	$content .= "Bot defense of captcha was {$_SESSION['captchaBot']['first']}\n";
	// Comments
	$content .= "Additional comments were - {$_SESSION['captchaComments']['first']}\n";

	// Divider
	$content .= "---------------------------------------------------\n\n";

	// Captcha information
	$content .= "Captcha 2 - Image Captcha\n";
	// Time to complete
	$content .= "Time to complete was {$_SESSION['captchaTimes']['second']} seconds\n";
	// Number of attempts
	$content .= "Number of attempts was {$_SESSION['captchaAttempts']['second']}\n";
	// Ease
	$content .= "Ease of captcha was {$_SESSION['captchaEase']['second']}\n";
	// Bot Defense
	$content .= "Bot defense of captcha was {$_SESSION['captchaBot']['second']}\n";
	// Comments
	$content .= "Additional comments were - {$_SESSION['captchaComments']['second']}\n";

	// Divider
	$content .= "---------------------------------------------------\n\n";

	// Captcha information
	$content .= "Captcha 3 - Moving Captcha\n";
	// Time to complete
	$content .= "Time to complete was {$_SESSION['captchaTimes']['third']} seconds\n";
	// Number of attempts
	$content .= "Number of attempts was {$_SESSION['captchaAttempts']['third']}\n";
	// Ease
	$content .= "Ease of captcha was {$_SESSION['captchaEase']['third']}\n";
	// Bot Defense
	$content .= "Bot defense of captcha was {$_SESSION['captchaBot']['third']}\n";
	// Comments
	$content .= "Additional comments were - {$_SESSION['captchaComments']['third']}\n";

	// Divider
	$content .= "---------------------------------------------------\n\n";

	// Captcha information
	$content .= "Captcha 4 - Game Captcha\n";
	// Time to complete
	$content .= "Time to complete was {$_SESSION['captchaTimes']['fourth']} seconds\n";
	// Number of attempts
	$content .= "Number of attempts was {$_SESSION['captchaAttempts']['fourth']}\n";
	// Ease
	$content .= "Ease of captcha was {$_SESSION['captchaEase']['fourth']}\n";
	// Bot Defense
	$content .= "Bot defense of captcha was {$_SESSION['captchaBot']['fourth']}\n";
	// Comments
	$content .= "Additional comments were - {$_SESSION['captchaComments']['fourth']}\n";

	// Divider
	$content .= "---------------------------------------------------\n\n";


	// Captcha information
	$content .= "Captcha 5 - Custom Captcha\n";
	// Time to complete
	$content .= "Time to complete was {$_SESSION['captchaTimes']['fifth']} seconds\n";
	// Number of attempts
	$content .= "Number of attempts was {$_SESSION['captchaAttempts']['fifth']}\n";
	// Ease
	$content .= "Ease of captcha was {$_SESSION['captchaEase']['fifth']}\n";
	// Bot Defense
	$content .= "Bot defense of captcha was {$_SESSION['captchaBot']['fifth']}\n";
	// Comments
	$content .= "Additional comments were - {$_SESSION['captchaComments']['fifth']}\n";

	// Divider
	$content .= "---------------------------------------------------\n\n";

	echo $content;

	// Write contents to file, append if already data inside, and lock file from being changed while writing
	// Make sure unicode characters dont get printed
	file_put_contents($fileName, htmlspecialchars_decode($content), FILE_APPEND | LOCK_EX);
	// Make sure it is readable by all users
	chmod($fileName, 0644);
?>
<!DOCTYPE html>
<html>
<head>
  <title>End of Study</title>
</head>
<body>
<h1> You finished, thank you for your participation! </h1>
</body>
</html>