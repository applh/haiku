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

	function buildHTML ()
	{
		$result =
<<<CODEHTML
<tr>
	<td>{$this->id}</td>
	<td>{$this->email}</td>
	<td>{$this->date}</td>
	<td>{$this->ip}</td>
	<td><a href="?formhid=deleteTable&table={$this->txtTable}&id={$this->id}">delete</a></td>
</tr>
CODEHTML;

		return $result;
	}

	//-- CLASS CODE ENDS
};
