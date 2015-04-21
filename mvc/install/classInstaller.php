<?php

/*
* class:		Installer
* creation:		2015-04-21 11:23:18
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class Installer
	extends ControllerParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES


	//-- METHODS

	// CONSTRUCTOR
	function __construct ($txtSourcefile)
	{
		// DO THE PARENT CONSTRUCTOR
		parent::__construct();

		$txtRootDir 		= dirname($txtSourcefile);

		$txtFileHtaccess 	= "$txtRootDir/.htaccess";

		if ( ! is_file($txtFileHtaccess) )
		{
			// TEMPLATES
			$txtHtaccess = $this->getFileContent("htaccess.txt");

			// FIND SUB DIR
			$txtDocRoot		= $_SERVER["DOCUMENT_ROOT"];
			$txtSubDir		= str_replace($txtDocRoot, "", $txtRootDir);
			$txtHtaccess 	= str_replace("=CHANGE_ME=", $txtSubDir, $txtHtaccess);

			if (is_writable($txtRootDir))
			{
				file_put_contents($txtFileHtaccess, $txtHtaccess);

				echo ".htaccess FILE CREATED";
			}
			else
			{
				echo "FOLDER IS NOT WRITABLE";
			}
		}
		else
		{
			echo ".htaccess FILE ALREADY EXISTS";
		}

		$txtFileReadme 	= "$txtRootDir/README.md";

		if ( is_file($txtFileReadme) )
		{
			// DELETE THE README FILE
			unlink($txtFileReadme);
		}
		
		// DELETE THE SOURCE FILE
		unlink($txtSourcefile);
	}

	//-- CLASS CODE ENDS
};
