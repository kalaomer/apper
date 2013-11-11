<?php

/*
 * @author Ömer KALA ( kalaomer@hotmail.com )
 * Apper is simple Application Core.
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . "eventmanager.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "container.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "application.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "staticapplication.php";

/**
 * Create Apper\Application.
 */
function apper( $mainFunction, array $binds = array() )
{
	return new Apper\Application( $mainFunction, $binds);
}

/**
 * Create Class which extends Apper\StaticApplication.
 */
function staticApper( $staticName, $mainFunction, $binds = array() )
{

	eval( 'class ' . $staticName . ' extends Apper\StaticApplication {}' );

	$binds = array_merge( array("name"=>$staticName), $binds );

	return $staticName::init( $mainFunction, $binds );
}
