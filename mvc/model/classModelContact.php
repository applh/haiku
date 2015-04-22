<?php

/*
* class:		ModelContact
* creation:		2015-04-22 01:38:53
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ModelContact
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $email;
	public $name;
	public $message;
	public $date;
	public $ip;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->txtTable = "contacts";
	}

	//-- CLASS CODE ENDS
};
