<?php

/**
 * This script checks if your configuration is supported by Confident CAPTCHA.
 * It checks the PHP version, installed extensions, config.php, and the
 * connection to the remote site.
 */

/* Requires for Confident CAPTCHA */
require_once('confidentcaptcha/ConfidentCaptchaClient.php');

// Construct ConfidentCaptchaClient object
$confidentCaptchaClient = new ConfidentCaptchaClient('configurations/settings.xml');

$checkConfigResponse = $confidentCaptchaClient->checkClientSetup();

$checkConfigHtml = $checkConfigResponse->getHtml();

$configGood = $checkConfigResponse->wasApiPassed();

$checkInstructions = "Your configuration is supported by the
        Confident CAPTCHA PHP sample code. Use this <tt>settings.xml</tt> file in
        your own project.";

if (!$configGood) {

    $checkInstructions = "<b>Your configuration is <i>not</i> supported
        by the Confident CAPTCHA PHP sample code</b>.  Please fix the 
        errors in <tt>settings.xml</tt> before trying the samples and integrating into your own
        project.";
}

// Print it
echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head runat="server">
    <title>Confident CAPTCHA Configuration Check</title>
</head>
<body>
 <h1>Confident CAPTCHA Configuration Check</h1>
 <p>
   The tables below describe your configuration and if it is supported by
   Confident CAPTCHA.  Local configuration is set in <tt>settings.xml</tt>, and
   remote configuration comes from
   <a href="http://captcha.confidenttechnologies.com/">captcha.confidenttechnologies.com</a>.
 </p>
 $checkConfigHtml
 <p>$checkInstructions</p>
 <p><a href="index.php">Return to the index</a>.</p>
</body>
</html>
HTML;

