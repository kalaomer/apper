<?php

/*
 * This example is about create Apper\Application with manually
 * and use some simple functions.
 */

// First of all, add Apper files.
require_once ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "main.php";

//Now create Apper Object.
$app = new Apper\Application(

	// This function is running when call application run function.
	// $app which is function argument is application object.
	// Run function is automatically add $app argument to main function.
	function( $app ) {

		// Call $app's function.
		// This function isn't exist but we will create one, just wait :)
		$app->sayHi();

		// return $app's version info.
		return $app->version();
	},

	array(
		// This bind's default value is "0.0.0",
		// But now we define this bind.
		"version" => "0.0.1",

		// This bind's default value is "Apper\Application",
		// But now we define this bind.
		"name" => "firstApp",

		// Create another bind which name is "mySecret".
		"mySecret" => "I like her, but Shhh, this is secret! :)"
		)
);

// Now patch $app for "sayHi" function.
// Because we need this function for main function, remember? :)
$app->setPatch( "sayHi", function( $app ) {

	// Echo $app name which binded value of name.
	echo $app->get("name") . " said 'Hi!'<br/>";
	
} );

// Now run $app.
// Run function will return $app's version info.
$version = $app->run();

// Echo $version.
echo "Application's version is " . $version . "<br/>";

// Get "mySecret" from $app then echo this.
echo "My secret is: " . $app->get( "mySecret" ) . "<br/>";