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
	extends ControllerParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $txtHostname;
	public $txtUser;
	public $txtPassword;
	public $txtDatabase;

	public $objDbManager;

	public $tabTranslate;
	public $userLevel;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		parent::__construct();

		// WRITE YOUR CODE HERE
		$this->tabTranslate = [];
		$this->objDbManager = null;
		$this->userLevel	= 0;

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

	function hasDatabase ()
	{
		// TO IMPROVE
		$resultat = ($this->txtDatabase != "");

		return $resultat;
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

	function processForm ()
	{
		$formhid = $this->getInput("formhid");
		if ($formhid != "")
		{
			// PROCESS EACH FORM HERE
			if ($formhid == "contact")
			{
				// PROCESS CONTACT FORM
				$controllerForm = new ControllerContact( $this->getDbManager() );

				$this->replace(	"=MESSAGE_CONTACT=",
								$controllerForm->txtMessage );
			}
			elseif ($formhid == "newsletter")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerNewsletter( $this->getDbManager() );

				$this->replace(	"=MESSAGE_NEWSLETTER=",
								$controllerForm->txtMessage );
			}
			elseif ($formhid == "login")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerLogin($formhid);
				$this->replace(	"=MESSAGE_LOGIN=",
								$controllerForm->txtMessage );
			}
			elseif ($formhid == "logout")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerLogin($formhid);
				$this->replace(	"=MESSAGE_LOGIN=",
								$controllerForm->txtMessage );
			}

			// WARNING
			// PROTECTED ACTIONS
			if ($this->userLevel > 0)
			{
				if ($formhid == "deleteTable")
				{
					// PROCESS NEWSLETTER FORM
					$controllerForm = new ControllerDatabase(
											$formhid,
											$this->getDbManager() );

					$this->replace(	"=MESSAGE_ACTION=",
									$controllerForm->txtMessage );
				}
			}

		}
	}

	//-- CLASS CODE ENDS
};
