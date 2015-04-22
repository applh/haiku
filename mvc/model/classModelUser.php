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

	function buildHTML ()
	{
		$result =
<<<CODEHTML
<tr>
	<td>{$this->id}</td>
	<td>{$this->email}</td>
	<td>{$this->password}</td>
	<td>{$this->level}</td>
	<td>{$this->date}</td>
	<td><a href="?formhid=deleteTable&table={$this->txtTable}&id={$this->id}">delete</a></td>
</tr>
CODEHTML;

		return $result;
	}

	//-- CLASS CODE ENDS
};
