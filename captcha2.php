<html>
<head>
  <meta charset="utf-8">
  <title>Captcha Study - Image Captcha</title>
  <script type="text/javascript" src="jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="js/timer.js"></script>
</head>
<body>
<form method="post" action="captcha2verify.php">
<!-- Confident CAPTCHA start -->
<?php
   require_once('imagelib/confidentcaptcha/ConfidentCaptchaClient.php');
   // Construct ConfidentCaptchaClient object
   $confidentCaptchaClient = new ConfidentCaptchaClient("imagelib/configurations/settings.xml");
   echo $confidentCaptchaClient->createCaptcha();
?>
<!-- Confident CAPTCHA end -->
  <input type="submit" name="op" value="Submit" />
</form>
</body>
</html>