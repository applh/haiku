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

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// DO THE PARENT CONSTRUCTOR
		parent::__construct();

		// ATTRIBUTES INIT
		$this->pageContent 	= "";
		$this->pageName 	= "index";

		// PROCESS THE FORMS
		$this->processForm();

		// SHOW THE PAGE CONTENT
		$this->showContent();
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
