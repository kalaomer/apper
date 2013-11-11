<?php

namespace Apper;

class Application extends Container {

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
			$this->bind( $key, $value );
		}
	}

	Public function version()
	{
		return $this->get( "version" );
	}

	Public function run( $args = array() )
	{
		return $this->call( 'main_function', $args );
	}

	Public function boot( $args = array() )
	{
		return $this->call( 'boot_function', $args );
	}

}
