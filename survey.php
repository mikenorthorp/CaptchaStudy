<?php
	// Survey validation and session saving
	session_start();
	var_dump($_SESSION);
	// Figure out what captcha number they were on
	$number = $_SESSION['captchaNumber'];
	$captcha = "";
	$next = "";
	if($number == 1) {
		$captcha = $_SESSION['captchaOrder']['first'];
		$next = $_SESSION['captchaOrder']['second'];
	} elseif ($number == 2) {
		$captcha = $_SESSION['captchaOrder']['second'];
		$next = $_SESSION['captchaOrder']['third'];
	} elseif ($number == 3) {
		$captcha = $_SESSION['captchaOrder']['third'];
		$next = $_SESSION['captchaOrder']['fourth'];
	} elseif ($number == 4) {
		$captcha = $_SESSION['captchaOrder']['fourth'];
		$next = $_SESSION['captchaOrder']['fifth'];
	} elseif ($number == 5) {
		$captcha = $_SESSION['captchaOrder']['fifth'];
		$next = "end";
	}

	// Set captcha to proper name for survey
	if($captcha == "captcha1") {
		$captcha = "first";
	} elseif ($captcha == "captcha2") {
		$captcha = "second";
	} elseif ($captcha == "captcha3") {
		$captcha = "third";
	} elseif ($captcha == "captcha4") {
		$captcha = "fourth";
	} elseif ($captcha == "captcha5") {
		$captcha = "fifth";
	}

	// If a post request is submitted, add answers to session and continue
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Set captcha ease
		if(isset($_POST['element_2'])) {
			$_SESSION['captchaEase'][$captcha] = $_POST['element_2'];
		}

		// Set captcha bot defense
		if(isset($_POST['element_3'])) {
			$_SESSION['captchaBot'][$captcha] = $_POST['element_3'];
		}

		if(isset($_POST['element_1'])) {
			$_SESSION['captchaComments'][$captcha] = $_POST['element_1'];
		}

		session_write_close();
		// Redirect to next captcha
		$redirectURL = '/' . $next . '.php';
		header("Location: http://localhost" . $redirectURL);
		die();
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CAPTCHA Survey</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
		<form method="post" action="">
		<form id="form_867687" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>CAPTCHA Survey</h2>
			<p>Please fill out this quick survey for the captcha you just completed.</p>
		</div>						
			<ul >
			
					<li id="li_2" >
		<label class="description" for="element_2">How easy was it for you to solve the CAPTCHA? *

</label>
		<span>
			<input id="element_2_1" name="element_2" class="element radio" type="radio" value="1" />
<label class="choice" for="element_2_1">1 - Immpossible</label>
<input id="element_2_2" name="element_2" class="element radio" type="radio" value="2" />
<label class="choice" for="element_2_2">2 - Very Hard</label>
<input id="element_2_3" name="element_2" class="element radio" type="radio" value="3" />
<label class="choice" for="element_2_3">3 - Hard</label>
<input id="element_2_4" name="element_2" class="element radio" type="radio" value="4" />
<label class="choice" for="element_2_4">4 - Medium</label>
<input id="element_2_5" name="element_2" class="element radio" type="radio" value="5" />
<label class="choice" for="element_2_5">5 - Easy</label>
<input id="element_2_6" name="element_2" class="element radio" type="radio" value="6" />
<label class="choice" for="element_2_6">6 - Trivial</label>

		</span><p class="guidelines" id="guide_2"><small>1=Impossible, you could not complete it. 6=Trivial, you didn't even have to think to complete it.</small></p> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">How easy do you think this CAPTCHA would be at stopping automated attacks? *

Automated attacks are any computer, bot, or automated system that does not involve humans to solve the CAPTCHA. </label>
		<span>
			<input id="element_3_1" name="element_3" class="element radio" type="radio" value="1" />
<label class="choice" for="element_3_1">1 - Immpossible</label>
<input id="element_3_2" name="element_3" class="element radio" type="radio" value="2" />
<label class="choice" for="element_3_2">2 - Very Hard</label>
<input id="element_3_3" name="element_3" class="element radio" type="radio" value="3" />
<label class="choice" for="element_3_3">3 - Hard</label>
<input id="element_3_4" name="element_3" class="element radio" type="radio" value="4" />
<label class="choice" for="element_3_4">4 - Medium</label>
<input id="element_3_5" name="element_3" class="element radio" type="radio" value="5" />
<label class="choice" for="element_3_5">5 - Easy</label>
<input id="element_3_6" name="element_3" class="element radio" type="radio" value="6" />
<label class="choice" for="element_3_6">6 - Trivial</label>

		</span> 
		</li>		<li id="li_1" >
		<label class="description" for="element_1">Leave any comments or concerns you have about this CAPTCHA

This may include how much you like or dislike it, how promising you think it is, or discussion of semi-related topics. </label>
		<div>
			<textarea id="element_1" name="element_1" class="element textarea medium"></textarea> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="867687" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
		<div id="footer">
			Generated by <a href="http://www.phpform.org">pForm</a>
		</div>
		</form>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>