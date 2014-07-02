<?php
/*
 * © 2009 Leap Marketing Technologies Inc
 * Do Not Distribute
 */

/**
 * Hello NuCaptcha *
 * This example will show the minimal code required to get a NuCaptcha on your website.  It is a minimal example, and not intended as a production implementation.
 *
 * You can also download the PHP API including full example code here: http://www.nucatpcha.com/download/api.
 *
 * After you've looked at this, proceed to: http://www.nucatpcha.com/languages/php/1.0/examples/leap_sample_simple.
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
/*
 * Step 1 - Initialize NuCaptcha Transaction
 */
	// initialize the transaction
	$t = Leap::InitializeTransaction();
/*
 * Step 2 - Display the NuCaptcha Widget
 */
    // and display the actual player code
    echo $t->GetWidget();
