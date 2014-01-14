<?php

namespace Apper;

class Container {

	Protected $binds = array();

	Protected $prototype = array();

	/**
	 * ==================================================================
	 * ==================================================================
	 * Bind functions.
	 */

	/**
	 * If Binds's including Closure, this is merge with object.
	 */
	Public function parseBinds( $rawBinds = array() )
	{
		foreach ($rawBinds as $key => $bind) {

			// If Bind is Closure, bind it.
			if ($bind instanceof \Closure) {
				$this->binds[ $key ] = $bind->bindTo( $this, $this );
			}
			else
			{
				$this->binds[ $key ] = $bind;
			}
		
		}
	}

	Public function changeBinds( $binds )
	{
		$this->delBind();
		return $this->parseBinds( $binds );
	}

	Public function bind()
	{
		$args = func_get_args();

		switch (count($args)) {
			case 0:
				return $this->binds;
			
			case 1:
				if ( is_array( $arg = $args[0] ) )
				{
					return $this->parseBinds( $arg );
				}

				return $this->binds[ $arg ];

			case 2:
				return $this->parseBinds( array( $args[0] => $args[1] ) );

			default:
				throw new Exception("Wrong arguments");
				break;
		}
	}

	Public function delBind()
	{
		$args = func_get_args();
		if ( count( $args ) > 0 ) {
			unset( $this->binds[ $args[0] ] );
		}
		else
		{
			$this->binds = array();
		}
	}

	Public function isBind( $key )
	{
		return isset( $this->binds[ $key ] );
	}

	Public function isCallableBind( $key )
	{
		return $this->isBind( $key ) && is_callable( $this->bind( $key ) );
	}

	/**
	 * ==================================================================
	 * ==================================================================
	 * Prototype functions.
	 */
	
	Public function isPrototype( $key )
	{
		return isset( $this->prototype[ $key ] );
	}

	Public function prototype()
	{
		$args = func_get_args();

		switch (count($args)) {
			case 0:
				return $this->prototype;
			
			case 1:
				if ( is_array( $arg = $args[0] ) )
				{
					return $this->prototype = array_merge( $this->prototype, $arg );
				}

				return $this->prototype[ $arg ];

			case 2:
				return $this->prototype[ $args[0] ] = $args[1];

			default:
				throw new Exception("Wrong arguments");
				break;
		}
	}

	Public function delPrototype()
	{
		$args = func_get_args();
		if ( count( $args ) > 0 ) {
			unset( $this->prototype[ $args[0] ] );
		}
		else
		{
			$this->prototype = array();
		}
	}

	Public function changePrototype( $prototype )
	{
		$this->delPrototype();
		return $this->prototype = $prototype;
	}

	Public function parsePrototypeToBinds()
	{
		return $this->parseBinds( $this->prototype );
	}

	/**
	 * ==================================================================
	 * ==================================================================
	 * Magic Metods.
	 */

	Public function __set( $key, $value )
	{
		$this->bind( $key, $value );
	}

	Public function __get( $key )
	{
		if ( !$this->isBind( $key ) )
		{
			throw new \Exception( "This variable isn't exists. Variable: " . $key );
		}

		return $this->bind( $key );
	}

	Public function __call( $bind, $args )
	{
		if ( ! $this->isCallableBind( $bind ) )
		{
			throw new \Exception("Wrong function name. Function Name: " . $bind);
		}

		return call_user_func_array($this->bind($bind), $args);
	}

	/**
	 * ==================================================================
	 * ==================================================================
	 * Quick functions.
	 */

	Public function exec( \Closure $funcTemplate, array $args = array() )
	{
		$func = $funcTemplate->bindTo( $this, $this );

		return call_user_func_array($func, $args);
	}
}
