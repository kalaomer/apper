<?php

// First of all, add Apper files.
require_once ".." . DIRECTORY_SEPARATOR . "index.php";

// Create Apper\Application with function.
$newApp = apper( function( $app ) {
		$app->sayHitoStaticApp();
	},
	array(
		"name" => "newApp",
		"version" => "0.1.2"
		// ...
		)
	);

// Create staticApp Class which extends Apper\StaticApplication.
staticApper( "staticApp", function( $app ) {
		$app->sayHitoNewApp();
	},
	array(
		// If don't add this bind, Apper automatically define bind which name is "name"
		// to staticApper function's first argument.
		"name" => "staticApp",
		"version" => "0.3.2",
		// ...
		)
	);

// Say 'HI!' to staticApp.
$newApp->setPatch( "sayHitoStaticApp", function( $app ) {
	echo $app->get( "name" ) . " said 'HI!' to " . staticApp::get( "name" ) . " :) <br />";
} );

// Say 'HI!' to staticApp.
staticApp::setPatch( "sayHitoNewApp", function( $app ) use ($newApp) {
	echo $app->get( "name" ) . " said 'HI!' to " . $newApp->get( "name" ) . " :) <br />";
} );

// Now run applications.
$newApp->run();

staticApp::run();