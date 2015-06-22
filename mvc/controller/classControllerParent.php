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
	public $txtBaseDir;
	public $txtCookieName;

	public $txtMessage;

	public $objSite;
	public $useDatabase;
	
	public $tabError;
	
	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// get parent dir
		$this->txtBaseDir 	= dirname(__DIR__);

		// cookie
		$this->cookieName 	= "haikuCookie64";

		// message from form controller
		$this->txtMessage 	= "";

		$this->objSite		= null;
		$this->useDatabase  = false;
		
		$this->tabError = [];
	}

	public checkInput ($name, $errorMessage)
	{
		$val = $this->getInput($name);
		if ($val == "")
		{
			// add the error message
			$this->tabError[] = $errorMessage;
		}		
		// allow chained syntax
		return $this;	
	}

	public checkEmail ($name, $errorMessage)
	{
		$val = $this->getInput($name);
		$email2 = filter_var($val, FILTER_VALIDATE_EMAIL);
		if (($val == "") || ($val != $email2))
		{
			// add the error message
			$this->tabError[] = $errorMessage;
		}
		// allow chained syntax
		return $this;	
	}
	
	public countError ()
	{
		return count($this->tabError);
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

	function checkLogin ($email, $password)
	{
		// TEMP CODE
		$result 	= false;

		// MODEL
		$user = new ModelUser;

		$email0 	= "haiku@gmail.com";
		$password0 	= "haiku";

		if ( ($email == $email0) && ($password == $password0) )
		{
			$result = true;
		}

		return $result;
	}


	function checkUserCookie ()
	{
		$result = false;

		// GET DATA IN COOKIE
		$txtCookie64 = $this-> getInput ($this->cookieName);
		if ($txtCookie64)
		{
			$txtCookie 		= base64_decode($txtCookie64);
			$tabCookie 		= json_decode ($txtCookie, true);
			if ( is_array ($tabCookie) )
			{
				$email 		= "";
				$password 	= "";

				if ( isset($tabCookie["email"]) )
				{
					$email		= $tabCookie["email"];
				}
				if ( isset($tabCookie["password"]) )
				{
					$password	= $tabCookie["password"];
				}

				$result = $this-> checkLogin ($email, $password);
			}
		}

		return $result;
	}

	function saveCookieLogin ($email, $password)
	{
		// SAVE DATA IN COOKIE
		$txtCookie64 = $this-> getInput ($this->cookieName);
		if ($txtCookie64)
		{
			$txtCookie = base64_decode($txtCookie64);
			$tabCookie = json_decode ($txtCookie, true);
		}
		else
		{
			$tabCookie = [];
		}

		$tabCookie["email"] 	= $email;
		$tabCookie["password"] 	= $password;
		// JSON encode
		$txtJSON 	= json_encode($tabCookie);
		// BASE 64 ENCODE
		$txtSave64 	= base64_encode($txtJSON);

		// SAVE THE DATA
		setcookie($this->cookieName, $txtSave64);

	}

	function getFileContent ($txtFileName)
	{
		$result = "";
		$txtFilePath = $this->findFile($txtFileName);
		if ($txtFilePath != "")
		{
			$result = file_get_contents($txtFilePath);
		}

		return $result;
	}

	function getDatabaseContent ($pageName)
	{
		$result = "";
		// TODO
		$dbManager = new DatabaseManager($this->objSite);
		$modelPage = new ModelPage;

		return $result;
	}

	//-- CLASS CODE ENDS
};
