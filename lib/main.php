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
 * Create Apper.
 */
function apper( array $binds = array(), array $prototype = array() )
{
	return new Apper( $binds, $prototype );
}

/**
 * Create Class which extends Apper\StaticApplication.
 */
function staticApper( $staticName, $binds = array(), $prototype = array(), $runFuncTemplate = null, $args = array() )
{
	$nameParts = explode("\\", $staticName);

	$className = array_pop( $nameParts );

	if ( count($nameParts) < 1 )
	{
		$nameSpace = null;
	}
	else
	{
		$nameSpace = implode("\\", $nameParts);
	}

	eval(
		($nameSpace != null ?
			'namespace ' . $nameSpace . ";" . PHP_EOL
				:
			"") .
				'class ' . $className . ' extends \Apper\StaticApplication {}'
		);

	return $staticName::init( $binds, $prototype, $runFuncTemplate, $args );
}
