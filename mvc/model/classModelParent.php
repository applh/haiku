<?php

/*
* class:		ModelParent
* creation:		2015-04-22 00:54:18
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ModelParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $txtTable;

	public $id;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
	}

	function buildHTML ()
	{
		$result = "<tr><td>{$this->id}</td></tr>";

		return $result;
	}

	//-- CLASS CODE ENDS
};
