<?php

/*
* class:		Installer
* creation:		2015-04-21 11:23:18
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class Installer
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES


	//-- METHODS

	// CONSTRUCTOR
	function __construct ($txtSourcefile)
	{
		// WRITE YOUR CODE HERE

		// DELETE THE SOURCE FILE
		unlink($txtSourcefile);
	}

	//-- CLASS CODE ENDS
};
