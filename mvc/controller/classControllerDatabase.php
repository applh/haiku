<?php

/*
* class:		ControllerDatabase
* creation:		2015-04-22 22:08:41
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ControllerDatabase
	extends ControllerParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES


	//-- METHODS

	// CONSTRUCTOR
	function __construct ($action, $objDbManager)
	{
		// WRITE YOUR CODE HERE
		if ($action == "deleteTable")
		{
			$txtTable 	= $this->getInput("table");
			$txtId 		= $this->getInput("id");
			if ($txtTable && $txtId)
			{
				$objDbManager->deleteTableLine($txtTable, $txtId);
				$this->txtMessage = "LINE DELETED";

			}
			else
			{
				$this->txtMessage = "MISSING INFORMATION";				
			}
		}

	}

	//-- CLASS CODE ENDS
};
