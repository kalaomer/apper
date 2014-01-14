<?php

namespace Apper;

class StaticApplication {

	/**
	 * Kullanan objelerin tutulduğu yer.
	 */
	Protected static $objects = array();

	/**
	 * Obje istenilen fonksiyon.
	 */
	Protected static function createObject( $binds = array(), $prototype = array() )
	{
		return new \Apper( $binds, $prototype );
	}


	/**
	 * Staticer'in obje'nin ismini istediği fonksiyon.
	 */
	Public static function getObjectName()
	{
		return get_called_class();
	}

	Public static function init( $binds = array(), $prototype = array(), $runFuncTemplate = null, $args = array() )
	{
		if (! ($runFuncTemplate instanceof \Closure ) )
		{
			$runFuncTemplate = function() { $this; };
		}

		$obj = self::$objects[ static::getObjectName() ] = static::createObject( $binds, $prototype );

		$runFunc = $runFuncTemplate->bindTo( null, $obj );

		call_user_func_array($runFunc, $args);
	}

	/**
	 * Staticer'in datasından istenen objeyi çağırma. 
	 */
	Public static function getObject()
	{
		return self::$objects[ static::getObjectName() ];
	}

	/**
	 * Staticer'i static olarak tetikleme.
	 */
	Public static function __callStatic( $method, $args )
	{
		return call_user_func_array(array( static::getObject(), $method ), $args);
	}
}