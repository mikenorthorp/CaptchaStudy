<?php
  require_once('recaptchalib.php');
  // Passed
  $passed = 0;
  $privatekey = "6Lf_EfYSAAAAACa48J8oAbRFVcMoIpHCcsHFceDC";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    $passed = 0;
  } else {
    // Your code here to handle a successful verification
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
  echo '<p> You entered the correct captcha, continue to next one.';
  echo '<br>';
  echo '<a href="/survey.php">Go Next</a>'; 
  } 
?>
<?php if($passed == 0) {
    echo '<p> You incorrectly entered the captcha, please try again.';
    echo '<br>';
    echo '<a href="/captcha1.php">Try Again</a>'; 
  } 
?>
</body>
</html>

