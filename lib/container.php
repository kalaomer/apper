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
	Public function set( $key, $val )
	{
		return $this->bindings[ $key ] = $val;
	}

	/**
	 * Delete binded value.
	 */
	Public function del( $key )
	{
		return $this->binded( $key ) ? unlink( $this->bindings[ $key ] ) : false;
	}

	/**
	 * Return true if $key is already binded.
	 * If false and $val is not null, then bind this value to $key.
	 */
	Public function setted( $key, $val = null )
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

	/**
	 * Call binded value if it is callable.
	 */
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

	/**
	 * Return patched function.
	 */
	Public function getPatch( $name ) {
		if ( $this->patched( $name ) ) {
			return $this->monkeyPatches[ $name ];
		}
	}

	/**
	 * Delete patch.
	 */
	Public function delPatch( $name )
	{
		if ( $this->patched( $name ) )
		{
			unset( $this->monkeyPatches[ $name ] );
		}
	}

	/**
	 * Return true if $name is already patched.
	 * If false and $func is not null, then bind this value to $name.
	 */
	Public function patched( $name, $func = null )
	{
		if ( isset($this->monkeyPatches[ $name ]) )
		{
			return true;
		}

		if ($func != null) 
		{
			$this->monkeyPatches[ $name ] = $func;
			return true;
		}

		return false;
	}

	/**
	 * Call pathed functions with __call magic methode.
	 */
	function __call( $name, $args = array() )
	{
		// Add $this to binded function arguments
		array_unshift($args, $this);
		
		if ( $this->patched( $name ) )
		{
			return call_user_func_array( $this->getPatch( $name ) , $args);
		}
		else
		{
			return trigger_error( 'Function didn\'t find! Function: ' . $name );
		}
	}

}
