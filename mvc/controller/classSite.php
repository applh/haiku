<?php

/*
* class:		Site
* creation:		2015-04-21 15:33:58
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class Site
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $tabTranslate;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->tabTranslate = [];
	}

	function replace ($txtFrom, $txtTo)
	{
		$this->tabTranslate[$txtFrom] = $txtTo;

	}

	function setup ($txtPageName)
	{
		// COMMON TO THE SITE
		$this->replace(	"=LOGO=",
						'<h3 class="masthead-brand"><a href="index.php">Haiku</a></h3>');

		// SPECIFIC FOR A PAGE
		if ($txtPageName == "index")
		{
			$this->replace("=TITLE=", 			"Welcome");
		}
		elseif ($txtPageName == "login")
		{
			$this->replace("=TITLE=", 			"Login");
		}
		elseif ($txtPageName == "private")
		{
			$this->replace("=TITLE=", 			"Private");
		}

	}

	function getTranslate ()
	{

		return $this->tabTranslate;
	}

	//-- CLASS CODE ENDS
};
