<?php

/*
* class:		ControllerParent
* creation:		2015-04-20 13:57:39
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ControllerParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES


	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
	}

	// check the input value
	// returns the input value if found
	// else returns a default value ("")
	function getInput ($txtInputName, $defaultValue = "")
	{
		$result = $defaultValue;

		if ( isset($_REQUEST["$txtInputName"]) )
		{
			$result = $_REQUEST["$txtInputName"];
		}
		elseif ( isset($_COOKIE["$txtInputName"]) )
		{
			$result = $_COOKIE["$txtInputName"];
		}

		return $result;
	}

	//-- CLASS CODE ENDS
};
