<html>
<head>
  <meta charset="utf-8">
  <title>Captcha Study - Image Captcha</title>
  <script type="text/javascript" src="jquery-1.8.3.min.js"></script>
      <script type="text/javascript">
      $(function()
      {
          var start = null;
          $(window).load(function(event) {
              start = event.timeStamp;
          });
          $(window).unload(function(event) {
              var time = event.timeStamp - start;
              var captcha = "second";
              $.post('timer.php', {time: time, captcha: captcha});
          })
      });
  </script>
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