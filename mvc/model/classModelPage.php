<?php

/*
* class:		ModelPage
* creation:		2015-04-21 21:08:32
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ModelPage
	extends ModelParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $name;
	public $content;
	public $start;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->txtTable = "pages";
	}

	//-- CLASS CODE ENDS
};
