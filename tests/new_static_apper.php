<?php

// First of all, add Apper files.
require_once ".." . DIRECTORY_SEPARATOR . "index.php";

// Define new class which extends Apper\StaticApplication.
class App extends Apper\StaticApplication {};

// Create Apper\Application object with init() function.
App::init(
	array(
		"name" => "app",
		"version" => "0.0.1"
		// ...
		)
	);

// Path sayHi function for main_function.
App::bind( "sayHi", function() {
	echo $this->name . " said 'HI!' <br />";
} );

App::sayHi();

class App2 extends Apper\StaticApplication {}

App2::init(
	array(
		"name" => "app2"
		)
	);

App2::bind( "sayHi", function() {
	echo $this->name . " said 'HI!' <br />";
} );

App2::sayHi();

staticApper(
	"jarvis",
	[
		"name" => "Jarvis",
		"version" => "1.0.0"
	],
	[
		"whoAmI" => function()
			{
				echo "I'm " . $this->name . " <br />";			
			}
	]
	);

jarvis::whoAmI();

jarvis::extendsApp( App2::getObject(), function( $version ) { $this->version = $version; }, array( "2.1.0" ) );

jarvis::whoAmI();

var_dump( jarvis::getObject() );

var_dump( jarvis::exec( function() { return $this->name; } ) );