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
	public $txtBaseDir;

	//-- ATTRIBUTES


	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// get parent dir
		$this->txtBaseDir = dirname(__DIR__);
	}

	// check the input value
	// returns the input value if found
	// else returns a default value ("")
	function getInput ($txtInputName, $defaultValue = "")
	{
		$result = $defaultValue;

		if ( isset($_REQUEST["$txtInputName"]) )
		{
			$result = trim($_REQUEST["$txtInputName"]);
		}
		elseif ( isset($_COOKIE["$txtInputName"]) )
		{
			$result = trim($_COOKIE["$txtInputName"]);
		}

		return $result;
	}

	function findFile ($txtFile)
	{
		$txtResult = "";

		// get parent dir
		$txtCurDir = $this->txtBaseDir;

		// SEARCH IN LEVEL 1
		$tabResult = glob("$txtCurDir/*/$txtFile");
		if (count($tabResult)  > 0)
		{
			$txtResult = $tabResult[0];
		}
		else
		{
			// SEARCH IN LEVEL 2
			$tabResult = glob("$txtCurDir/*/*/$txtFile");
			if (count($tabResult)  > 0)
			{
				$txtResult = $tabResult[0];
			}
		}

		return $txtResult;
	}

	//-- CLASS CODE ENDS
};
