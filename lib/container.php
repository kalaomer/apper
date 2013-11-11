<?php

namespace Apper;

class Container extends EventManager {
	
	/**
	 * Bindings.
	 * @var array
	 */
	Protected $bindings = array();

	/**
	 * Methode functions created with monkey pach.
	 * @var array
	 */
	Protected $monkeyPatches = array();

	/*
	 *
	 * Bind functions!
	 *
	 */

	/**
	 * Create bind.
	 */
	Public function bind( $key, $val )
	{
		return $this->bindings[ $key ] = $val;
	}

	Public function unbind( $key )
	{
		return $this->binded( $key ) ? unlink( $this->bindings[ $key ] ) : false;
	}

	Public function binded( $key, $val = null )
	{
		if ( isset($this->bindings[ $key ]) )
		{
			return true;
		}

		if ($val != null) 
		{
			$this->bindings[ $key ] = $val;
			return true;
		}

		return false;
	}

	Public function get( $key )
	{
		return $this->bindings[ $key ];
	}

	Public function call( $key, $args = array() )
	{

		$func = $this->get( $key );

		// Add $this to binded function arguments.
		array_unshift( $args, $this );

		if (is_callable($func)) {
			return call_user_func_array($func, $args);
		}

		return;
	}


	/*
	 *
	 * Monkey Patch Functions!
	 *
	 */

	/**
	 * Create Monkey Patch.
	 */
	Public function setPatch( $name, $func )
	{
		$this->monkeyPatches[ $name ] = $func;
	}

	Public function getPatch( $name ) {
		if ( $this->hasPatch( $name ) ) {
			return $this->monkeyPatches[ $name ];
		}
	}

	Public function killPatch( $name )
	{
		if ( $this->hasPatch( $name ) )
		{
			unset( $this->monkeyPatches[ $name ] );
		}
	}

	Public function hasPatch( $name )
	{
		return isset( $this->monkeyPatches[ $name ] );
	}

	function __call( $name, $args = array() )
	{
		// Add $this to binded function arguments
		array_unshift($args, $this);
		
		if ( $this->hasPatch( $name ) )
		{
			return call_user_func_array( $this->getPatch( $name ) , $args);
		}
		else
		{
			return trigger_error( 'Function didn\'t find! Function: ' . $name );
		}
	}

}
