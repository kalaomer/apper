<?php

namespace Apper;

class Application extends Container {

	/**
	 * Create main function, and main binds.
	 */
	function __construct( $mainFunction, array $binds = array() )
	{

		$binds = array_merge( array(
				"name" => __CLASS__,
				"version" => "0.0.0",
				"main_function" => $mainFunction
				),
				$binds
			 );

		foreach ($binds as $key => $value) {
			$this->set( $key, $value );
		}
	}

	/**
	 * Return version value from binds.
	 */
	Public function version()
	{
		return $this->get( "version" );
	}

	/**
	 * Call 'main_function' bind.
	 */
	Public function run( $args = array() )
	{
		return $this->call( 'main_function', $args );
	}

	/**
	 * Call 'boot_function' bind.
	 */
	Public function boot( $args = array() )
	{
		return $this->call( 'boot_function', $args );
	}

}
