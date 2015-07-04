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
	public $userOK;
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
		$this->userOK    	= false;

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
			$this->objSite->processForm();

			// PREPARE THE CONTENT TO DISPLAY
			$this->objSite->prepareContent($this->pageName);

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
			$this->userOK = $this-> checkUserCookie ();

			if (! $this->userOK)
			{
				header('Location: login.php');
			}
			else
			{
				$this->hasAccess = true;
				// TO IMPROVE
				$this->objSite->userLevel = 1;
			}
		}

		return $this->hasAccess;
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
		$pattern = "/=:[\w]+:=/";
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
			header("HTTP/1.1 404 Not Found");
		}

		$hasHtmlHead = strpos( $this->pageContent, "</head>");
		$txtHtmlHead = "";
		if ($hasHtmlHead === FALSE)
		{
			// MISSING END TAG </head>
			// FIND HEAD AND FOOT HTML
			$txtHtmlHead = $this->getFileContent("head.html");
		}
		$hasHtmlEnd = strpos( $this->pageContent, "</body>");
		$txtHtmlFoot = "";
		if ($hasHtmlEnd === FALSE)
		{
			// MISSING END TAG </body>
			// FIND HEAD AND FOOT HTML
			$txtHtmlFoot = $this->getFileContent("foot.html");

		}
		// COMPLETE THE PAGE HTML
		$this->pageContent =
			$txtHtmlHead . $this->pageContent . $txtHtmlFoot;

		$this->replaceContent();

		$this->cleanTranslate();

		echo $this->pageContent;
	}

	//-- CLASS CODE ENDS
};
