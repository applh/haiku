<?php

/*
* class:		ControllerLogin
* creation:		2015-04-21 13:49:36
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ControllerLogin
	extends ControllerParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $action;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ($action)
	{
		// DO THE PARENT CONSTRUCTOR
		parent::__construct ();

		// STORE THE ACTION
		$this->action = $action;

		// PROCESS THE CONTACT FORM
		$this-> processForm ();
	}


	function processForm ()
	{
		if ( $this->action == "login" )
		{
			$this-> processFormLogin ();
		}
		elseif ( $this->action == "logout" )
		{
			$this-> processFormLogout ();
		}

	}

	function processFormLogout ()
	{
		$this-> saveCookieLogin ("", "");
	}



	function processFormLogin ()
	{
		$email 		= $this-> getInput ("h1");
		$password 	= $this-> getInput ("h2");

		if ( $email && $password )
		{
			$loginOK 	= $this-> checkLogin ($email, $password);
			if ($loginOK)
			{
				$this-> saveCookieLogin ($email, $password);

				header("Location: private.php");
			}
		}

	}


	//-- CLASS CODE ENDS
};
