<?php

/*
* class:		ContentTag
* creation:		2015-07-16 14:12:47
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ContentTag
{
	//-- ContentTag CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $tag;
	public $tagCode;
	public $content;
	
	public $tabQuery;
	
	//-- METHODS

	// CONSTRUCTOR
	function __construct ($tag, $tagCode)
	{
		// WRITE YOUR CODE HERE
		$this->content = "";
		
		$this->tag = $tag;
		$this->tagCode = $tagCode;
		
		$this->tabQuery = null;
	}


	function parseQuery ()
	{
		$this->tabQuery = [];
		$request = trim($this->tagCode, "=::="); 
		// http://php.net/manual/en/function.parse-url.php
		$query = parse_url($request, PHP_URL_QUERY);
		
		// EXTRACT PARAMETERS AS LOCAL VARIABLES
		// http://php.net/manual/en/function.parse-str.php
		parse_str($query, $this->tabQuery);

	}
	
	function val ($name, $default = "")
	{
		$result = $default;
		if ($this->tabQuery == null)
		{
			$this->parseQuery();
		}
		if (isset($this->tabQuery["$name"]))
		{
			$result = $this->tabQuery["$name"];
		}
		return $result;
	}
	
	//-- ContentTag CLASS CODE ENDS
};
