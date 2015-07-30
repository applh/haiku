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
	
	public $tabTag;
	
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
		$this->tagTag		= [];
		
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
	// replace tags (e.g =:MYTAGS:= with final content)
	function replaceContent ()
	{
		$this->tabTranslate = $this->objSite->getTranslate($this->pageName)
								+ $this->tabTranslate;

		$tabTag 	= array_keys($this->tabTranslate);
		$tabContent = array_values($this->tabTranslate);

		$this->pageContent = str_replace($tabTag, $tabContent, $this->pageContent);
		
		$this->getTags();
		$this->processTagList();
		
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

		// PARSE THE TAG LIST FROM THE PAGE CONTENT
		$this->getTags();
		
		$this->replaceContent();

		$this->cleanTranslate();

		echo $this->pageContent;
	}
	
	function getTags ()
	{
		// https://regex101.com/
		$re = "/(=:[\\w+].*:=)/"; 
		$tabResult = [];
		
		// http://php.net/manual/fr/function.preg-match-all.php
		preg_match_all($re, $this->pageContent, $tabResult);
		
		if (isset($tabResult[1]) && is_array($tabResult[1]))
		{
			foreach($tabResult[1] as $tagCode)
			{
				// http://php.net/manual/fr/function.parse-url.php
				$tagCode2 = trim($tagCode, "=::=");
				$tag = parse_url($tagCode2, PHP_URL_PATH);
				$contentTag = new ContentTag($tag, $tagCode);
				
				// KEEP THE WHOLE LIST SO KEEP OPEN ITERATION AND ASSOCIATION BETWEEN TAGS
				$this->tabTag[] = $contentTag;
			}

		}
		return $this->tabTag;
	}

	function processTagList ()
	{
		global $haiku_find_file;
		global $haiku_find_content;
		
		foreach ($this->tabTag as $contentTag)
		{
			$tag = $contentTag->tag;
			// SEARCH A HTML FILE WITH THE TAG NAME
			$htmlFileContent = $haiku_find_content("$tag.html");
			if ($htmlFileContent != "")
			{
				$contentTag->content = $htmlFileContent;
			}

			// CAN ALSO HAVE A PHP FILE
			// NOTE: IS IT REALLY USEFUL?
			// SEARCH A PHP FILE WITH THE TAG NAME
			$phpPathContent = $haiku_find_file("$tag.php");
			if ($phpPathContent != "")
			{
				$contentTag->file = $phpPathContent;
				$this->buildDynamicContent($contentTag, $this);
			}
			

			// REPLACE THE TAG WITH CONTENT
			$this->pageContent = str_replace($contentTag->tagCode, $contentTag->content, $this->pageContent);
		}
	}
	
	function buildDynamicContent ($theTag, $thePage)
	{
		// WARNING: CAN PROVOKE ERRORS IF BAD USE
		// http://php.net/manual/en/function.ob-start.php
		// START BUFFERING OUTPUT
		ob_start();
		
		// INCLUDE THE PHP FILE
		include("{$theTag->file}");
		
		// http://php.net/manual/en/function.ob-get-clean.php
		// END BUFFERING OUTPUT
		$theTag->content = ob_get_clean();
		
	}
	
	
	function getMenuClass ($pageName)
	{
		$resultat = "";
		
		if ($pageName == $this->pageName)
		{
			$resultat = "active";
		}
		
		return $resultat;
	}
	//-- CLASS CODE ENDS
};
