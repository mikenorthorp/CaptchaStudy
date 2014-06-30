<?php

/* Callback resource for Confident CAPTCHA AJAX calls
/* Requires Confident CAPTCHA */
require_once('confidentcaptcha/ConfidentCaptchaClient.php');

/* Generate callback response */
if(isset($_REQUEST['endpoint']) && isset($_REQUEST['confidentcaptcha_block_id'])){
    $confidentCaptchaClient = new ConfidentCaptchaClient( 'configurations/settings-for-ajax.xml');
    $return = $confidentCaptchaClient->callback($_REQUEST);
    header($return[0]);
    echo $return[1];
}