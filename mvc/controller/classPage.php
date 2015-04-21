<?php

/*
* class:		Page
* creation:		2015-04-20 13:20:04
*
* author:		Long Hai
* license:		All rights reserved
*
*/

// the class Page
// inherits from the class ControllerParent
class Page
	extends ControllerParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $pageName;
	public $pageContent;
	public $hasAccess;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ($txtPageName)
	{
		// DO THE PARENT CONSTRUCTOR
		parent::__construct();

		// ATTRIBUTES INIT
		$this->pageContent 	= "";
		$this->pageName 	= "index";
		$this->hasAccess    = true;

		if ($txtPageName != "")
		{
			$this->pageName = $txtPageName;
		}

		$accessOK = $this->checkAccess();

		if ($accessOK)
		{
			// PROCESS THE FORMS
			$this->processForm();

			// SHOW THE PAGE CONTENT
			$this->showContent();

		}

	}

	function checkAccess ()
	{
		if ( strpos($this->pageName, "private") !== FALSE)
		{
			// THIS IS A PRIVATE PAGE
			$this->hasAccess = false;
			// NEED TO CHECK USER
			$userOK = $this-> checkUserCookie ();

			if (! $userOK)
			{
				header('Location: login.php');
			}
			else
			{
				$this->hasAccess = true;
			}
		}

		return $this->hasAccess;
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
				$controllerForm = new ControllerContact;

			}
			elseif ($formhid == "newsletter")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerNewsletter;
			}
			elseif ($formhid == "login")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerLogin($formhid);
			}
			elseif ($formhid == "logout")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerLogin($formhid);
			}
		}
	}

	//
	function showContent ()
	{
		global $haiku_find_file;
		$txtPageFile = "{$this->pageName}.html";
		$txtHtmlFile = $haiku_find_file($txtPageFile);
		if ($txtHtmlFile != "")
		{
			$this->pageContent = file_get_contents($txtHtmlFile);
		}

		echo $this->pageContent;
	}

	//-- CLASS CODE ENDS
};
