<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Captcha Study - ReCaptcha</title>
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
              var captcha = "first";
              $.post('timer.php', {time: time, captcha: captcha});
          })
      });
  </script>
</head>

<body>
<div id="content">
  <h1> ReCaptcha </h1>
    <div id="form">
      <form method="post" action="verifyRecaptcha.php">
        <?php
          require('recaptchalib.php');
          $publickey = "6Lf_EfYSAAAAADrevcb8fbU64STX1m3vcWlY-gaX"; // you got this from the signup page
          echo recaptcha_get_html($publickey);
        ?>
        <input type="submit" value="Submit" id="btn">
      </form>
    </div>
</div>

</body>
</html>