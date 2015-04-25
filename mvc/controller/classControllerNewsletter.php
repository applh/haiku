<?php

/*
* class:		ControllerNewsletter
* creation:		2015-04-20 14:20:33
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ControllerNewsletter
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

		if ($email)
		{
			$now = date("Ymd-His");
			$ip  = $_SERVER["REMOTE_ADDR"];
			// MODEL
			$model = new ModelNewsletter;
			$model->create($dbManager, $email, $now, $ip);

			$this->txtMessage = "THANKS FOR YOUR INTEREST";
		}
		else
		{
			$this->txtMessage = "THANKS TO ENTER AN EMAIL";
		}
	}

	function processFormTxt ()
	{
		$email 		= $this->getInput("email");

		if ($email)
		{
			// MODEL
			$model = new ModelNewsletter;
			$now = date("Ymd-His");
			$ip  = $_SERVER["REMOTE_ADDR"];

			// CHECK INSTALL
			$txtDataDir = $this->findFile("form-newsletter");
			if ( !is_dir($txtDataDir) )
			{
				$txtDataDir = $this->txtBaseDir."/data-txt/form-newsletter";
				mkdir($txtDataDir, 0777, true);
			}

			$txtSaveFile = "$txtDataDir/newsletter.csv";

			$txtSaveContent =
<<<TXTCONTENT
$email,$now,$ip

TXTCONTENT;
			// WRITE THE MESSAGE
			file_put_contents($txtSaveFile, $txtSaveContent, FILE_APPEND);
			chmod($txtSaveFile, 0666);

			$this->txtMessage = "THANKS FOR YOUR INTEREST";

		}
		else
		{
			$this->txtMessage = "THANKS TO ENTER AN EMAIL";
		}
	}

	//-- CLASS CODE ENDS
};
