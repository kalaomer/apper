<?php

namespace Apper;

class EventManager {

	Protected $events = array();

	/**
	 * Creating Event Node.
	 * @var $cat string
	 * @var $func callable
	 * @var $args array
	 * @var $one boolean
	 */
	Public function on( $cat, $func, $args = array(), $one = false )
	{
		$node = array(
			'func' => $func,
			'args' => $args,
			'one' => $one
			);
		$this->events[ $cat ][] = $node;
	}

	/**
	 * Creating Event node for only one call.
	 */
	Public function one( $cat, $func, $args = array() ) {
		return $this->on( $cat, $func, $args, true );
	}

	Public function isEvent( $cat ) {
		return isset( $this->events[ $cat ] );
	}

	Public function killEvent( $cat ) {
		if ( $this->isEvent( $cat ) )
		{
			unset( $this->events[ $cat ] );
		}
	}

	/**
	 * Creating before.{$cat} event node.
	 * This nodes will call before $cat event nodes run.
	 */
	Public function before( $cat, $func, $args = array(), $one = false )
	{
		$this->on( 'before.' . $cat, $func, $args, $one );
	}

	/**
	 * Creating after.{$cat} event node.
	 * This nodes will call after $cat event nodes run.
	 */
	Public function after( $cat, $func, $args = array(), $one = false )
	{
		$this->on( 'after.' . $cat, $func, $args, $one );
	}

	/**
	 * Call event nodes.
	 */
	Public function trigger( $cat, $args = array() )
	{

		if ( $this->isEvent('before.'.$cat) )
		{
			$this->trigger('before.'.$cat);
		}
		
		foreach ($this->events[ $cat ] as $key => $node)
		{
			
			$_args = $args;
			
			array_unshift($_args, $this, $node['args']);
			
			call_user_func_array( $node['func'], $_args);

			if ($node['one']) {
				unset( $this->events[ $cat ][ $key ] );
			}
		}

		if ( $this->isEvent('after.'.$cat) )
		{
			$this->trigger('after.'.$cat);
		}
	}
}
