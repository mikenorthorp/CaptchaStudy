<html>
<head>
  <!-- Confident CAPTCHA requires jquery -->
    <script type='text/javascript' src="jquery-1.8.3.min.js"></script>
</head>
<body>
<form method="post" action="sample_after_submit.php">
<!-- Confident CAPTCHA start -->
<?php
   require_once('confidentcaptcha/ConfidentCaptchaClient.php');
   // Construct ConfidentCaptchaClient object
   $confidentCaptchaClient = new ConfidentCaptchaClient("configurations/settings.xml");
   echo $confidentCaptchaClient->createCaptcha();
?>
<!-- Confident CAPTCHA end -->
  <input type="submit" name="op" value="Submit" />
</form>
</body>
</html>