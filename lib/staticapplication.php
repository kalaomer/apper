<?php

namespace Apper;

class StaticApplication {

	Public static $app;

	Public static function init( $mainFunction, array $binds = array() )
	{
		return self::$app = new Application( $mainFunction, $binds );
	}

	/**
	 * Return current App object.
	 */
	Public static function app() {
		return self::$app;
	}

	/**
	 * Call App Objects methodes.
	 */
	Public static function __callStatic( $name, array $args = array() )
	{
		if ( method_exists( self::app(), $name) )
		{
			return call_user_func_array( array(self::app(), $name), $args );
		}

		return call_user_func_array( array(self::app(), "__call"), array($name, $args) );
	}
}
