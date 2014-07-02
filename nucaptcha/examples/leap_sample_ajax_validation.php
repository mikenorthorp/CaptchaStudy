<?php

/*
 * � 2009 Leap Marketing Technologies Inc
 * Do Not Distribute
 */

/**
 * AJAX Example - Validation *
 * NuCaptcha Example Script showing validation from an AJAX call.
 *
 * The following code works in conjunction with leap_sample_ajax.php to demonstrate how to do validation of NuCaptcha through AJAX calls.
 *
 * Like the other examples, this code can be thought of as two separate steps.
 * Step 1: Validate the previous transaction
 * Step 2: Initialize the next one (if the previous one failed)
 *
 **/
/*
 * General Setup
 */
// Include the Leap Client library
require_once("./../leapmarketingclient.php");

// Your ClientKey is supplied by Leap and can be downloaded from the publisher dashboard
Leap::SetClientKey("YOUR_CLIENT_KEY_HERE");

// The session is used in this example to store persistent data on the server
session_start();

// Default some variables
$response = "false";
$message = "";
$error = "false";

// This handles an error, sending data back to the javascript that indicates an error
function OutputError($response, $error, $message)
{
	echo "{\"response\":$response, \"isError\":$error, \"errorMessage\":\"$message\"}";
	exit();
}
/*
 * Step 1: Validation
 * Validate the previous transaction
 */
// Check if the persistent data was stored, and if the user actually submitted an answer
if (!isset($_SESSION['leap']))
{
	// send back that the response was invalid
	OutputError("false", "true", "No Session Data!");
}
else
{
	// validate the transaction and check the result
	if (Leap::ValidateTransaction($_SESSION['leap']))
	{
		// Success! store some values for later
		$response = "true";
		$message = "";
		$error = "false";
	}
	else
	{
		// Failure! store some values for later
		$response = "false";
		$message = "";
		$error = "false";

		// Find out why it failed
		switch (Leap::GetStatusCode())
		{
			case LMSC_WRONG:
			case LMSC_EMPTY:
				$error = "true";
				$message = "Answer was incorrect.";
			break;

			default:
				$error = "true";
				$message = sprintf('Error Code: %s Error Message: %s',
					Leap::GetStatusCode(),
					Leap::GetStatusString()
				);
			break;
		}
	}
}
/*
 * Step 2: Transaction initialization
 * Start a new transaction
 */
// initialize the transaction
$t = Leap::InitializeTransaction();
$initresult = Leap::GetStatusCode();

// check if the transaction initialization was successful
if (LMSC_OK == $initresult)
{
	// store the persistent data in the session for validation later
	$_SESSION['leap'] = $t->GetPersistentData();

	// Echo the reinitialization code out to the javascript listening.
	// GetJSONToReinitialize takes an array of name/value pairs that will be sent along
	// with the NuCaptcha variables in the response to the listening javascript code.
	// Note that strings have to be escaped ahead of time, like errorMessage.
	// The results of this should be passed to a javascript function denoted by
	// lmcTransactionInterface::GetJavascriptReinitializeFunctionName.
	echo $t->GetJSONToReinitialize(array("response"=>$response, "isError"=>$error, "errorMessage"=>'"' . $message . '"'), true);
}
else
{
	// report a problem to the user if transaction initialization failed for some reason
	OutputError($response, "true", "Error reinitializing");
}
