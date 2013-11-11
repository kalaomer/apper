<?php

require_once ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "main.php";

function jarvis_main( $app ) { var_dump( $app->get("name") ); }

staticApper( "Jarvis", "jarvis_main", array("name"=>"jarvis") );

Jarvis::run();

$app = apper( function( $app ) { var_dump( $app->get("name") ); }, array("name" => "app") );

$app->run();

Jarvis::setPatch( "hi", function() {
	echo Jarvis::get('name') . " said HI!" . PHP_EOL;
} );

Jarvis::setPatch( "count", function( $count ) {
	for ($i=0; $i < $count ; $i++) { 
		echo $i . PHP_EOL;
	}
} );

Jarvis::hi();

Jarvis::count( 10 );