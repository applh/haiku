<?php

/*
* class:		ControllerContact
* creation:		2015-04-20 14:20:28
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ControllerContact
	extends ControllerParent
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES


	//-- METHODS

	// CONSTRUCTOR
	function __construct ($dbManager)
	{
		// DO THE PARENT CONSTRUCTOR
		parent::__construct();

		// PROCESS THE CONTACT FORM
		if ($dbManager->isReady)
		{
			$this->processForm($dbManager);
		}
		else
		{
			$this->processFormTxt();
		}
	}

	function processForm ($dbManager)
	{
		$email 		= $this->getInput("email");
		$name 		= $this->getInput("name");
		$message 	= $this->getInput("message");

		if ($email && $name && $message)
		{

			$now = date("Ymd-His");
			$ip  = $_SERVER["REMOTE_ADDR"];

			// MODEL
			$model = new ModelContact($dbManager);
			$model->create($dbManager, $email, $name, $message, $now, $ip);

			$this->txtMessage = "THANKS FOR YOUR MESSAGE";
		}
		else
		{
			$this->txtMessage = "THANKS TO COMPLETE MISSING INFORMATION";
		}
	}

	function processFormTxt ()
	{
		$email 		= $this->getInput("email");
		$name 		= $this->getInput("name");
		$message 	= $this->getInput("message");

		if ($email && $name && $message)
		{
			// MODEL
			$model = new ModelContact;

			// CHECK INSTALL
			$txtDataDir = $this->findFile("form-contact");
			if ( !is_dir($txtDataDir) )
			{
				$txtDataDir = $this->txtBaseDir."/data-txt/form-contact";
				mkdir($txtDataDir, 0777, true);
			}

			$now = date("Ymd-His");
			$ip  = $_SERVER["REMOTE_ADDR"];

			$txtSaveFile = "$txtDataDir/contact-$now.txt";

			$txtSaveContent =
<<<TXTCONTENT
===
$ip
$now
===
$email
$name
===
$message
===
TXTCONTENT;
			// WRITE THE MESSAGE
			file_put_contents($txtSaveFile, $txtSaveContent);
			chmod($txtSaveFile, 0666);

			$this->txtMessage = "THANKS FOR YOUR MESSAGE";
		}
		else
		{
			$this->txtMessage = "THANKS TO COMPLETE MISSING INFORMATION";
		}
	}

	//-- CLASS CODE ENDS
};
