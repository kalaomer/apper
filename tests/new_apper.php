<?php

/*
 * This example is about create Apper\Application with manually
 * and use some simple functions.
 */

// First of all, add Apper files.
require_once ".." . DIRECTORY_SEPARATOR . "index.php";

$apper = new Apper(
	array(
		"name" => "newApper"
		),
	array(
		"count" => 0,
		"counter" => function()
		{
			return $this->count++;
		}
	) );

var_dump($apper);

var_dump( $apper->counter() );
var_dump( $apper->counter() );

var_dump( $apper->count );

$apper->prototype( "count", 10 );

$apper2 = $apper->newApp();

var_dump( $apper2 );

$apper2->counter();
$apper2->counter();
$apper2->counter();
$apper2->counter();

var_dump( $apper2 );

$apper2->counter = function()
{
	return $this->count--;
};

$apper2->counter();
$apper2->counter();
$apper2->counter();

var_dump( $apper2 );

var_dump($apper);

$apper->extendsApp( $apper2 );

var_dump($apper);

$apper->counter();

var_dump($apper);
