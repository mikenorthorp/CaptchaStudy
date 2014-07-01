<!DOCTYPE html>
<html>
<head>
  <title>Captcha Verify</title>
</head>
<body>
<?php
  sleep(2); 
  session_start();
  // Increase which captcha on
  $_SESSION['captchaNumber'] += 1;
  session_write_close();
  echo '<p> You entered the correct captcha, continue to next one.';
  echo '<br>';
  echo '<a href="/survey.php">Go Next</a>'; 
?>
</body>
</html>