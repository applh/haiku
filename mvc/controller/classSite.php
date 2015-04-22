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
	public $txtHostname;
	public $txtUser;
	public $txtPassword;
	public $txtDatabase;

	public $objDbManager;

	public $tabTranslate;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->tabTranslate = [];
		$this->objDbManager = null;

		// DATABASE CONFIGURATION
		$this->txtHostname 	= "localhost";
		$this->txtUser 		= "root";
		$this->txtPassword 	= "";
		$this->txtDatabase 	= "haiku";

	}

	function getDbManager ()
	{
		if ($this->objDbManager == null)
		{
			$this->objDbManager = new DatabaseManager($this);
		}
		return $this->objDbManager;
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
			$this->replace("=TITLE=", "Welcome");
		}
		elseif ($txtPageName == "login")
		{
			$this->replace("=TITLE=", "Login");
		}
		elseif ($txtPageName == "private")
		{
			$this->replace("=TITLE=", "(Private)");
		}
		elseif ($txtPageName == "private-users")
		{
			$this->replace("=TITLE=", "Users (Private)");
		}

	}

	function getTranslate ()
	{

		return $this->tabTranslate;
	}

	function prepareContent ($txtPageName)
	{
		if ($txtPageName == "private-users")
		{
			$dbManager = $this->getDbManager();
			$htmlTable = $dbManager->readTable("users", "ModelUser");
			$this->replace("=TABLE_DATABASE=", $htmlTable);
		}
		elseif ($txtPageName == "private-contacts")
		{
			$dbManager = $this->getDbManager();
			$htmlTable = $dbManager->readTable("contacts", "ModelContact");
			$this->replace("=TABLE_DATABASE=", $htmlTable);
		}
		elseif ($txtPageName == "private-newsletters")
		{
			$dbManager = $this->getDbManager();
			$htmlTable = $dbManager->readTable("newsletters", "ModelNewsletter");
			$this->replace("=TABLE_DATABASE=", $htmlTable);
		}

	}
	//-- CLASS CODE ENDS
};
