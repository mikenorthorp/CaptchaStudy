<?php

/*
 * � 2009 Leap Marketing Technologies Inc
 * Do Not Distribute
 */

/**
 * NuCaptcha Example Script
 *
 * This example of the NuCaptcha Leap Marketing Client explains how to use the lmcResponse object. You would use this object directly if your $_POST
 * variables get mangled before you get them (which happens when you use certain php frameworks).
 *
 * There are 3 distinct actions/steps performed by a publisher website:
 *
 * 1. NuCaptcha transaction initialization
 * 2. Display of NuCaptcha widget on web page
 * 3. Validation of user input to NuCaptcha widget
 *
 * The example code below does both transaction initialization, display of the widget to the user, and validation.
 * In order for that to work, validation (step 3) is actually done first
 *
 * The use of the lmcResponse object is demonstrated in the code under Step3.5 below.
 * The code below Step 3.5, as well as the name mangling of the $_POST array at the beginning of this
 * file, are the only differences between this example and the complete example (leap_sample_complete.php).
 *
 * Note also that if the $_POST array is mangled, Leap::WasSubmitted() will not work properly
 *
 **/


// Include the Leap Client library
require_once("./../leapmarketingclient.php");

// Your ClientKey is supplied by Leap and can be downloaded from the publisher dashboard
Leap::SetClientKey("YOUR_CLIENT_KEY_HERE");

// The session is used in this example to store persistent data on the server
session_start();

// Default some variables for substitution into the HTML output
$transaction_status = "New Transaction";
$player_output      = "";


// return a mangled name from an unmangled name
function GetMangledPostName($unmangledName)
{
	return "mangled" . $unmangledName;
}

// mangles all of the post variables
function ManglePostVariables()
{
	// store all of the post values
	$newPost = array();
	foreach ($_POST as $key => $value)
	{
		$newPost[$key] = $value;
	}

	// clear the post array and add the values with mangled names
	foreach ($newPost as $key => $value)
	{
		// unset it in the post array
		unset($_POST[$key]);

		// store the value with a mangled name in the post array
		$_POST[GetMangledPostName($key)] = $value;
	}
}

// For starters, we want to mangle our $_POST variables
// just like an overprotective framework might
ManglePostVariables();


/*
 * Step3:
 * Validate the previous transaction, if need be. Do this first, so that we can use the same code/page to validate
 * and initialize a transaction.
 * In order for this to work, we need to construct our own response which retrieves the $_POST variables.
 * And we can't use Leap::WasSubmitted, as it checks the $_POST array
 */

// **** Don't use Leap::WasSubmitted() in this case, as it uses the $_POST data directly
if(true === array_key_exists('leap', $_SESSION) /*&& true === Leap::WasSubmitted()*/)
{
	// get the saved persistent data
	$persistentData = $_SESSION['leap'];



	/*
	 * Step3.5:
	 * Create and fill in a response object
	 */

	// create a response (pass in false for auto-fill, as we know that auto-fill won't work
	// because the POST variables have mangled names
	$response = Leap::GetResponse($persistentData, false);

	// fill in the values from the mangled post array
	foreach ($response->GetFields() as $varname)
	{
		// get the mangled name (from the variable name that the response object is looking for)
		$mangledName = GetMangledPostName($varname);

		// get the value from the $_POST array, using the mangled name
		$value = $_POST[$mangledName];

		// set the value in the response
		$response->SetVar($varname, $value );
	}




    // validate the transaction (using the hand created response object)
    $valid = Leap::ValidateTransaction($persistentData, $response);

    // check the result
    if (true == $valid)
    {
		// We have a valid captcha
		$transaction_status = "Answer was correct.";

        // This is where you'd most likely redirect to the next page, or submit the results
        // of what you were trying to validate (forum post, picture submission, etc)
    }
    else
    {
        // validation failed; find out why.
		switch (Leap::GetErrorCode())
		{
			case LMEC_WRONG:
			case LMEC_EMPTY:
				$transaction_status = "Answer was incorrect.";
			break;

			default:
				$transaction_status = sprintf('Error Code: %s Error Message: %s',
					Leap::GetErrorCode(),
					Leap::GetErrorString()
				);
			break;
		}
    }
}



/*
 * Step 1:
 * Start a new transaction
 */

// initialize the transaction
$t = Leap::InitializeTransaction();

// check if the transaction initialization was successful
if(LMEC_OK === Leap::GetErrorCode())
{
    // store the persistent data in the session for validation later
	// This should NEVER be sent to the client
    $_SESSION['leap'] = $t->GetPersistentData();

    // and get the actual player code
    $player_output = $t->GetWidget();
}
else
{
    // report a problem to the user if transaction initialization failed for some reason
    $player_output = "Getting Transaction failed: " . Leap::GetErrorString();
}






/*
 * Step 2:
 * Display the NuCaptcha widget/HTML
 */
?>
<html>
    <head>
		<title>
			NuCaptcha Minimal Demo Page
		</title>
    </head>
    <body>
		<!-- Form must use post method -->
		<form method="post">

			<?= $player_output; ?>

			<br>
			<!-- must supply your own submit button -->
			<input type="submit" value="Test Your Answer!" />
		</form>

		<!-- Tell the user what happened last time through -->
		Transaction Status: <?= $transaction_status; ?>
    </body>
</html>
