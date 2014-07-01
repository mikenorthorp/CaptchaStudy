<?php
// Instantiate the AYAH object. You need to instantiate the AYAH object
// on each page that is using PlayThru.
require_once("game/ayah.php");
$ayah = new AYAH();
$passed = 0;
// Check to see if the user has submitted the form. You will need to replace
// 'my_submit_button_name' with the name of your 'Submit' button.
if (array_key_exists('my_submit_button_name', $_POST))
{
        // Use the AYAH object to see if the user passed or failed the game.
        $score = $ayah->scoreResult();

        if ($score)
        {
                // This happens if the user passes the game. In this case,
                // we're just displaying a congratulatory message.
                $passed = 1;
        }
        else
        {
            // This happens if the user does not pass the game.
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
  sleep(2); 
  session_start();
  // Increase which captcha on
  $_SESSION['captchaNumber'] += 1;
  session_write_close();
  echo '<p> You entered the correct captcha, continue to next one.';
  echo '<br>';
  echo '<a href="/survey.php">Go Next</a>'; 
  } 
?>
<?php if($passed == 0) {
    echo '<p> You incorrectly entered the captcha, please try again.';
    echo '<br>';
    echo '<a href="/captcha4.php">Try Again</a>'; 
  } 
?>
</body>
</html>