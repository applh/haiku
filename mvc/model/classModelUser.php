<?php

/*
* class:		ModelUser
* creation:		2015-04-22 01:26:50
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ModelUser
	extends ModelParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $email;
	public $password;
	public $level;
	public $date;


	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->txtTable = "users";
	}

	//-- CLASS CODE ENDS
};
