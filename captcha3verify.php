<?php
/*
 * � 2009 Leap Marketing Technologies Inc
 * Do Not Distribute
 */

/**
 * Simple Example *
 * This is a minimal demo page for the NuCaptcha Leap Marketing Client. Both transaction creation and validation are demoed in this script.
 *
 * There are 3 distinct actions/steps performed by a publisher website:
 * 1. NuCaptcha transaction initialization
 * 2. Display of NuCaptcha widget on web page
 * 3. Validation of user input to NuCaptcha widget
 *
 * The example code below does both transaction initialization, display of the widget to the user, and validation.
 *
 * In order for that to work, validation (step 3) is actually done first.
 *
 **/
// Include the Leap Client library
require_once("nucaptcha/php/leapmarketingclient.php");

// Your ClientKey is supplied by Leap and can be downloaded from the publisher dashboard
Leap::SetClientKey("LEAP|0|4|TYPE|9|CLIENTKEY|CID|5|15669|KID|5|15321|SKEY|32|VE1JclpPSVNjeXpHUVNJRUl1Y2Rodyws");

// The session is used in this example to store persistent data on the server
session_start();
// Default some variables for substitution into the HTML output
$passed = 0;
/*
 * Step 3:
 * Validate the previous transaction, if need be. Do this first, so that we can use the same code/page to validate and initialize a transaction.
 */
// Check if the persistent data was stored, and if the user actually submitted an answer
if(true === array_key_exists('leap', $_SESSION) && true === Leap::WasSubmitted())
{
    // validate the transaction
    $valid = Leap::ValidateTransaction($_SESSION['leap']);

    // check the result
    if (true === $valid)
    {
        // We have a valid captcha
        $passed = 1;
    }
    else
    {
        // validation failed
        $passed = 0;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Captcha Verify</title>
</head>
<body>
<?php if($passed == 1) { 
  session_start();
  // Increase which captcha on
  $_SESSION['captchaNumber'] += 1;
  echo '<p> You entered the correct captcha, continue to next one.';
  echo '<br>';
  echo '<a href="/survey.php">Go Next</a>'; 
  } 
?>
<?php if($passed == 0) {
    echo '<p> You incorrectly entered the captcha, please try again.';
    echo '<br>';
    echo '<a href="/captcha2.php">Try Again</a>'; 
  } 
?>
</body>
</html>

