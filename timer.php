<?php 
	// Start the session again
	session_start();
	// Store time in session variable
	$time = intval($_POST['time'])/1000;
	$captcha = $_POST['captcha'];
	$_SESSION['captchaTimes'][$captcha] += $time;
	print_r($_SESSION['captchaTimes'][$captcha]);
?>