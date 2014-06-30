<?php
require_once('confidentcaptcha/ConfidentCaptchaClient.php');
// Construct ConfidentCaptchaClient object
$confidentCaptchaClient = new ConfidentCaptchaClient("configurations/settings.xml");
$ccap_validate_resp = $confidentCaptchaClient->checkCaptcha($_REQUEST);
if (!$ccap_validate_resp->wasCaptchaSolved()) {
    // The result when the catpcha was not solved correctly.
    print "<p>The captcha was solved incorrectly, <a href='sample_after_form.php'>click here to try it again.</a></p>";
} else {
    print "Captcha was successfully solved.";
    // Your code should be placed here to handle when the captcha was successfully solved.
}
print '<p><a href="sample_after_form.php">Return to the CAPTCHA</a></p>';
print '<p><a href="index.php">Return to the index</a></p>';
?>