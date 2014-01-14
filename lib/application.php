<?php

class Apper extends Apper\Container {

	Public function __construct( $binds = array(), $prototype = array() )
	{
		$this->prototype( $prototype );
		$this->parsePrototypeToBinds();

		$this->parseBinds( $binds );
	}

	Public function newApp( $binds = array(), $prototype = array() )
	{
		return new static( $binds, array_merge($this->prototype, $prototype) );
	}

	Public function extendsApp( $app, $runFuncTemplate = null, $args = array() )
	{

		if ( !is_object( $app ) || !( $app instanceof self ) )
		{
			throw new \Exception("Wrong Application");
		}

		$this->parseBinds( $app->bind() );
		$this->prototype( $app->prototype() );

		if ( $runFuncTemplate instanceof \Closure )
		{
			$runcFunc = $runFuncTemplate->bindTo( $this, $this );
			return call_user_func_array($runcFunc, $args);
		}
	}
}
