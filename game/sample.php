<!DOCTYPE html>
<?php
//******************************************************************************
/*
	Name:		sample.php

	Purpose:	Provide an example of how to integrate an AYAH PlayThru on PHP web form.

	Requirements:
			- your web server uses PHP5 (or higher).
			- all the AYAH PHP library files are in the same directory as this file.
			- the ayah_config.php contains a valid publisher key and scoring key.
			- you have read the installation instructions page at:
				http://portal.areyouahuman.com/installation/php

	Notes:		- if the Game Style for your PlayThru is set to "Lightbox", the
			  PlayThru will not display until after you click the submit button.
			  To change this setting, use the dashboard at:
				http://portal.areyouahuman.com/dashboard.php
*/
//******************************************************************************

// Instantiate the AYAH object. You need to instantiate the AYAH object
// on each page that is using PlayThru.
require_once("ayah.php");
$ayah = new AYAH();
?>

<!-- Now we're going to build the form that PlayThru is attached to.
In this example, the form submits to itself. -->
<form method="post" action="captcha4verify.php">
        <?php
            // Use the AYAH object to get the HTML code needed to
            // load and run PlayThru. You should place this code
            // directly before your 'Submit' button.
            echo $ayah->getPublisherHTML();
        ?>
        
        <!-- Make sure the name of your 'Submit' matches the name you used on line 9. -->
        <input type="Submit" name="my_submit_button_name" value="Submit ">
</form>
