<?php

/*
* class:		ModelNewsletter
* creation:		2015-04-22 01:38:39
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ModelNewsletter
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $email;
	public $date;
	public $ip;


	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->txtTable = "newsletters";
	}

	//-- CLASS CODE ENDS
};
