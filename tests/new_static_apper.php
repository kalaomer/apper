<?php

// First of all, add Apper files.
require_once ".." . DIRECTORY_SEPARATOR . "index.php";

// Define new class which extends Apper\StaticApplication.
class App extends Apper\StaticApplication {};

// Create Apper\Application object with init() function.
App::init( function( $app ) {
		// SayHi!
		$app->sayHi();
	},
	array(
		"name" => "staticApp",
		"version" => "0.0.1"
		// ...
		)
	);

// Path sayHi function for main_function.
App::setPatch( "sayHi", function( $app ) {
	echo $app->get( "name" ) . " said 'HI!' <br />";
} );

// RUN!
App::run();