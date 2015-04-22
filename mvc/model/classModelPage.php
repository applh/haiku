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

	function buildHTML ()
	{
		$result =
<<<CODEHTML
<tr>
	<td>{$this->id}</td>
	<td>{$this->name}</td>
	<td><pre>{$this->content}</pre></td>
	<td>{$this->start}</td>
	<td><a href="?formhid=deleteTable&table={$this->txtTable}&id={$this->id}">delete</a></td>
</tr>
CODEHTML;

		return $result;
	}

	//-- CLASS CODE ENDS
};
