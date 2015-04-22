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
	public $tabTranslate;


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

		$this->tabTranslate	= [];

		if ($txtPageName != "")
		{
			$this->pageName = $txtPageName;
		}

		$this->objSite = new Site;
		$this->objSite->setup($this->pageName);

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
		if ( strpos($this->pageName, "private") !== FALSE )
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

				$this->objSite->replace(	"=MESSAGE_CONTACT=",
											$controllerForm->txtMessage );
			}
			elseif ($formhid == "newsletter")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerNewsletter;
				$this->objSite->replace(	"=MESSAGE_NEWSLETTER=",
											$controllerForm->txtMessage );
			}
			elseif ($formhid == "login")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerLogin($formhid);
				$this->objSite->replace(	"=MESSAGE_LOGIN=",
											$controllerForm->txtMessage );
			}
			elseif ($formhid == "logout")
			{
				// PROCESS NEWSLETTER FORM
				$controllerForm = new ControllerLogin($formhid);
				$this->objSite->replace(	"=MESSAGE_LOGIN=",
											$controllerForm->txtMessage );
			}
		}
	}

	// TEMPLATE ENGINE
	// replace tags (e.g =MYTAGS= with final content)
	function replaceContent ()
	{
		$this->tabTranslate = $this->objSite->getTranslate($this->pageName)
								+ $this->tabTranslate;

		$tabTag 	= array_keys($this->tabTranslate);
		$tabContent = array_values($this->tabTranslate);

		$this->pageContent = str_replace($tabTag, $tabContent, $this->pageContent);
	}

	function cleanTranslate ()
	{
		// REMOVE REMAINING TAGS
		$pattern = "/=[\w]+=/";
		$this->pageContent = preg_replace($pattern, "", $this->pageContent);
	}



	//
	function showContent ()
	{
		$txtPageFile = "{$this->pageName}.html";

		// CHECK IF HTML FILE IS PRESENT
		$this->pageContent = $this->getFileContent($txtPageFile);

		// CHECK IF DB LINE IS PRESENT
		if ($this->pageContent == "")
		{
			$this->pageContent = $this->getDatabaseContent($this->pageName);
		}

		// CHECK IF 404 FILE IS PRESENT
		if ($this->pageContent == "")
		{
			// TRY THE 404 FILE
			$this->pageContent = $this->getFileContent("404.html");

			// SET THE HEADER RESPONSE CODEr
			header("HTTP/1.0 404 Not Found");
		}

		$hasHtmlEnd = strpos( $this->pageContent, "</body>");
		if ($hasHtmlEnd === FALSE)
		{
			// MISSING END TAG </body>
			// FIND HEAD AND FOOT HTML
			$txtHtmlHead = $this->getFileContent("head.html");
			$txtHtmlFoot = $this->getFileContent("foot.html");
			// COMPLETE THE PAGE HTML
			$this->pageContent =
				$txtHtmlHead . $this->pageContent . $txtHtmlFoot;

		}

		$this->replaceContent();

		$this->cleanTranslate();

		echo $this->pageContent;
	}

	//-- CLASS CODE ENDS
};
