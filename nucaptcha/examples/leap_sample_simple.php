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
Leap::SetClientKey("YOUR_CLIENT_KEY_HERE");

// The session is used in this example to store persistent data on the server
session_start();
// Default some variables for substitution into the HTML output
$transaction_status = "New Transaction";
$player_output      = "";
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
        $transaction_status = 'Answer correct.';
    }
    else
    {
        // validation failed
        $transaction_status = 'Answer wrong.';
    }
}
/*
 * Step 1:
 * Start a new transaction
 */
// initialize the transaction
$t = Leap::InitializeTransaction();

// store the persistent data in the session for validation later
// This should NEVER be sent to the client
$_SESSION['leap'] = $t->GetPersistentData();

// and get the actual player code
$player_output = $t->GetWidget();
/*
 * Step 2:
 * Display the NuCaptcha widget/HTML.
 */
?>
<!-- Form must use post method -->
<form method="post">

    <?php echo $player_output; ?><br>

    <!-- must supply your own submit button -->
    <input type="submit" value="Test Your Answer!" />
</form>

<!-- Tell the user what happened last time through -->
Transaction Status: <?php echo $transaction_status; ?>
