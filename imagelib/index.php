<?php
/* Requires for Confident CAPTCHA */
require_once('confidentcaptcha/ConfidentCaptchaClient.php');

// Construct ConfidentCaptchaClient object
$confidentCaptchaClient = new ConfidentCaptchaClient('configurations/settings.xml');

$credentialsCheck = $confidentCaptchaClient->checkCredentials();

if ($credentialsCheck->getStatus() != 200) {
    $checkCredentialsPassed = FALSE;
} else {
    $checkCredentialsPassed = (FALSE === stripos($credentialsCheck->getBody(), "api_failed='True'"));
}

//Check Ajax credentials as well
$confidentCaptchaClient2 = new ConfidentCaptchaClient('configurations/settings-for-ajax.xml');

$credentialsCheck2 = $confidentCaptchaClient2->checkCredentials();

if ($credentialsCheck2->getStatus() != 200) {
    $checkCredentialsPassed2 = FALSE;
} else {
    $checkCredentialsPassed2 = (FALSE === stripos($credentialsCheck2->getBody(), "api_failed='True'"));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>Confident CAPTCHA - PHP Library and Sample Code</title>
</head>
<body>
  <h1>PHP Library Version 2.5 and Sample Code for Confident CAPTCHA</h1>

<?php if ($checkCredentialsPassed || $checkCredentialsPassed2) { ?>
<p>
The samples are:
</p>
<ul>
  <li><a href="check.php">check.php</a> - Check if your configuration is supported by Confident CAPTCHA</li>
    <li><a href="check_with_ajax.php">check_with_ajax.php</a> - Check if your AJAX configuration is supported by Confident CAPTCHA</li>
  <li><a href="sample_before.php">sample_before.php</a> - A sample form that submits to itself, before adding Confident CAPTCHA</li>
  <li><a href="sample_after.php">sample_after.php</a> - A sample form that submits to itself, after adding Confident CAPTCHA</li>
    <li><a href="sample_after_with_ajax.php">sample_after_with_ajax.php</a> - A sample form that verifies the Confident CAPTCHA via AJAX</li>
</ul>

<p>
Here is a sample with the form submitting to a different page:
</p>
<ul>
    <li><a href="sample_after_form.php">sample_after_form.php</a> - A sample form after adding Confident CAPTCHA submitting to a different page.</li>
</ul>
<?php }
  else /* credentials not good */ { ?>

<p>
Your credentials in <tt>settings.xml</tt> or <tt>settings-for-ajax.xml</tt> are <b>not</b> valid.  See  <a href="check.php">check.php</a> or <a href="check_with_ajax.php">check_with_ajax.php</a> (if you are planning on using AJAX) for details.
    Please edit  <tt>settings.xml</tt> or <tt>settings-for-ajax.xml</tt> and add or fix your API credentials.  If you do not have an
account yet, please <a href="http://www.confidenttechnologies.com/Get_Confident_CAPTCHA" target="_blank"> sign up for a free account
</a>.
</p>

<?php } ?>

<p>
If you have any questions, feel free to
<a href="http://www.confidenttechnologies.com/contact" target="_blank">contact us</a>.
</p>

</body>
</html>
