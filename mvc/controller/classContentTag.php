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
	
	//-- METHODS

	// CONSTRUCTOR
	function __construct ($tag, $tagCode)
	{
		// WRITE YOUR CODE HERE
		$this->content = "";
		
		$this->tag = $tag;
		$this->tagCode = $tagCode;
	}

	//-- ContentTag CLASS CODE ENDS
};
