<?php
require_once('imagelib/confidentcaptcha/ConfidentCaptchaClient.php');
$passed = 0;
// Construct ConfidentCaptchaClient object
$confidentCaptchaClient = new ConfidentCaptchaClient("imagelib/configurations/settings.xml");
$ccap_validate_resp = $confidentCaptchaClient->checkCaptcha($_REQUEST);
if (!$ccap_validate_resp->wasCaptchaSolved()) {
    // The result when the catpcha was not solved correctly.
    $passed = 0;
} else {
    // Your code should be placed here to handle when the captcha was successfully solved.
    $passed = 1;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Captcha Verify</title>
</head>
<body>
<?php if($passed == 1) { 
  session_start();
  // Increase which captcha on
  $_SESSION['captchaNumber'] += 1;
  echo '<p> You entered the correct captcha, continue to next one.';
  echo '<br>';
  echo '<a href="/survey.php">Go Next</a>'; 
  } 
?>
<?php if($passed == 0) {
    echo '<p> You incorrectly entered the captcha, please try again.';
    echo '<br>';
    echo '<a href="/captcha2.php">Try Again</a>'; 
  } 
?>
</body>
</html>
