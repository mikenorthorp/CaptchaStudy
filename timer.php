<?php 
	// Start the session again
	session_start();
	// Store time in session variable
	$time = intval($_POST['time'])/1000;
	// Substract the sleep
	$time -= 2;
	$captcha = $_POST['captcha'];

	// Add to time for captcha
	$_SESSION['captchaTimes'][$captcha] += $time;
	// Add to attempts for captcha
	$_SESSION['captchaAttempts'][$captcha] += 1;
?>