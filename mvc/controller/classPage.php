<?php

/*
* class:		Page
* creation:		2015-04-20 13:20:04
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class Page
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $pageName;
	public $pageContent;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// ATTRIBUTES INIT
		$this->pageContent 	= "";
		$this->pageName 	= "index";

		global $haiku_find_file;
		$txtPageFile = "{$this->pageName}.html";
		$txtHtmlFile = $haiku_find_file($txtPageFile);
		if ($txtHtmlFile != "")
		{
			$this->pageContent = file_get_contents($txtHtmlFile);
		}

		// SHOW THE PAGE CONTENT
		$this->showContent();
	}

	//
	function showContent ()
	{
		echo $this->pageContent;
	}

	//-- CLASS CODE ENDS
};
