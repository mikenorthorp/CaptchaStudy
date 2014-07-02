<?php

/*
 * � 2009 Leap Marketing Technologies Inc
 * Do Not Distribute
 */

/**
 * AJAX Example *
 * This example uses AJAX for validation.  This is useful when creating a multi-part form where you don't want a page refresh between each page.
 *
 * This example uses jQuery (hosted by Google) to do the AJAX request, and uses the script leap_sample_ajax_validation.php to do the actual validation.
 *
 * If you are not familiar with jQuery (www.jquery.com), the important things to know are:
 *  1) Google hosts it: http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js
 *  2) You can get a jQuery DOM element using the syntax: $("#id_of_dom_element)
 *  3) You can set the text of a DOM element returned by the method in #2 by calling text("insert this text);
 *  4) You can do ajax calls using $.post. This method takes a url to post to, a javascript object with the
 *     values to send to the url, a callback function to call with the response, and the format to expect the response in.
 *
 * See leap_sample_complete.php for more information on transaction initialization, display of the NuCaptcha widget and validation.
 *
 * This example assumes you are familiar with the complete example, and know how to implement NuCaptcha in the standard post method.
 *
 * The following example intercepts the submit button press with a javascript function, and uses jQuery to post *
 * the NuCaptcha variables back to another php script which will do the validation, and return data to tell the *
 * javascript what to do next.
 *
 * Because validation is done using another php script, this example only needs to initialize a transaction with the Leap *
 * library and display the NuCaptcha widget to the web user (Steps 1 and 2 from the complete example). *
 * Validation (step 3) is done in leap_sample_ajax_validation.php.
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

/**
 * Parse the url for the current page. Strips any query parameters (such as session id)
 *
 * @return string
 */
function GetURL()
{
	$pageURL = 'http';
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".
					$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}

	$pos = strrpos($pageURL, '/');
	if ($pos !== false)
	{
		$pageURL = substr($pageURL, 0, $pos + 1);
	}

	return $pageURL;
}

// We need to figure out what our url is, so we can post to leap_sample_ajax_validation.php
$url = GetURL();

// Default some variables for substitution into the HTML output
$player_output      = "";
/*
 * Step 1:
 * Start a new transaction
 */
// initialize the transaction
$t = Leap::InitializeTransaction();

// check if the transaction initialization was successful
if(LMSC_OK == Leap::GetStatusCode())
{
    // store the persistent data in the session for validation later
	// NEVER send this to the client
    $_SESSION['leap'] = $t->GetPersistentData();

    // and get the actual player code
    $player_output = $t->GetWidget();

	// get the name of the reinitialize function call
	$reinitializeFunctionName = $t->GetJavascriptReinitializeFunctionName();
}
else
{
    // report a problem to the user if transaction initialization failed for some reason
    $player_output = "Getting Transaction failed: " . Leap::GetStatusString();

	// default the reinitialize function name to ""
	$reinitializeFunctionName = "";
}
/*
 * Step 2:
 * Display the NuCaptcha widget/HTML
 */
?>
<html>
    <head>
		<title>
			NuCaptcha AJAX Demo Page
		</title>

		<!-- include jquery for the ajax call -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>

    </head>
    <body>
		<!-- Script code to do the validation calls -->
		<script type="text/javascript">

			function validationResponse(returnedData)
			{
				if (returnedData.response)
				{
					response = "Successfully solved NuCaptcha!";
				}
				else
				{
					var response = "";
					if (returnedData.isError)
					{
						response = "There was an error. " + returnedData.errorMessage;
					}
					else
					{
						response = "Failed to solve NuCaptcha! Please try again";
					}
				}

				// tell the user what happened
				$("#transaction_status").text(response);

				// reinitialize using the Leap library's javascript reinitialize function
				// which we stored when we initialized the transaction
				// if your javascript is not embedded in your server code (ie an external js file,)
				// you can pass this function name into your script through a global variable.
				<?= $reinitializeFunctionName ?>(returnedData);
			}

			function validate()
			{
				// get the fields needed to validate; use the leap function
				// lmGetValidationFields to do this
				var vals = lmGetValidationFields();

				// figure out what url to query, using the $url that we figured out earlier
				var url = "<?= $url ?>leap_sample_ajax_validation.php";

				// do the ajax request
				$.post(url, vals, validationResponse, "json");

				// return false so that the form doesn't submit
				return false;
			}

		</script>

		<!-- Display the NuCaptcha widget -->
		<?= $player_output; ?>
		<br>

		<!-- Make the submit button do the ajax validation -->
		<button onclick="validate();">Test Your Answer!</button>

		<!-- Tell the user what happened last time through -->
		<!-- Have to label the span, so that we can replace it later -->
		Transaction Status: <span id="transaction_status" name="transaction_status">New Transaction</span>
    </body>
</html>
