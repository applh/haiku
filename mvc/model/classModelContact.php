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

	function buildHTML ()
	{
		$result =
<<<CODEHTML
<tr>
	<td>{$this->id}</td>
	<td>{$this->email}</td>
	<td><pre>{$this->message}</pre></td>
	<td>{$this->date}</td>
	<td>{$this->ip}</td>
	<td><a href="?formhid=deleteTable&table={$this->txtTable}&id={$this->id}">delete</a></td>
</tr>
CODEHTML;

		return $result;
	}

	//-- CLASS CODE ENDS
};
