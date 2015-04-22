<?php

/*
* class:		DatabaseManager
* creation:		2015-04-21 21:05:20
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class DatabaseManager
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $txtHostname;
	public $txtUser;
	public $txtPassword;
	public $txtDatabase;

	public $databaseConnexion;
	public $objRequest;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ($objSite)
	{
		$this->databaseConnexion 	= null;
		$this->objRequest 			= null;
		$this->txtDatabase 			= "";

		if ($objSite != null)
		{
			$this->txtHostname 	= $objSite->txtHostname;
			$this->txtUser 		= $objSite->txtUser;
			$this->txtPassword 	= $objSite->txtPassword;
			$this->txtDatabase 	= $objSite->txtDatabase;
		}

		if ($this->txtDatabase)
		{
			$dsn = "mysql:host={$this->txtHostname};dbname={$this->txtDatabase};charset=utf8";

			try
			{
			    $this->databaseConnexion = new PDO($dsn, $this->txtUser, $this->txtPassword);
			}
			catch (PDOException $e)
			{
			    echo 'Connection failed: ' . $e->getMessage();
				exit;
			}
		}
	}

	function prepare ($txtSQL)
	{
		if ($this->databaseConnexion != null)
		{
			try
			{
				// DEBUG
				//echo $txtSQL;
				//exit;
				
				$this->objRequest = $this->databaseConnexion->prepare($txtSQL);
			}
			catch (PDOException $e)
			{
			    echo 'Connection failed: ' . $e->getMessage();
				exit;
			}
		}

		return $this;
	}

	function exec ()
	{
		if ($this->objRequest != null)
		{
			try
			{
				$this->objRequest->execute();
			}
			catch (PDOException $e)
			{
			    echo 'Connection failed: ' . $e->getMessage();
				exit;
			}
		}

		return $this;

	}

	function fetchObject ($txtClassName)
	{
		$objResult = null;
		if ($this->objRequest != null)
		{
			$objResult = $this->objRequest->fetchObject($txtClassName);
		}
		else
		{
			echo 'DB ERROR: NO REQUEST';
			exit;
		}
		return $objResult;
	}


	function readTable ($txtTableName, $txtClassName)
	{
		$txtSQL =
<<<CODESQL
SELECT * FROM $txtTableName;
CODESQL;

		// LAUNCH THE SQL REQUEST
		$this->prepare($txtSQL)
					->exec();

		$htmlTable = '<table class="table"><tbody>';
		// GET EACH LINE AS AN OBJECT
		while ( $objLigne = $this->fetchObject($txtClassName) )
		{
			$htmlLine = $objLigne->buildHTML();
			$htmlTable = $htmlTable . $htmlLine;
		}

		$htmlTable = $htmlTable . '</tbody></table>';

		return $htmlTable;
	}

	function deleteTableLine ($txtTableName, $nbrId)
	{
		// FORCE  A NUMBER FOR ID
		$nbrId = intval($nbrId);

		$txtSQL =
<<<CODESQL
DELETE FROM $txtTableName
WHERE
id = $nbrId;
CODESQL;

		// LAUNCH THE SQL REQUEST
		$this->prepare($txtSQL)
					->exec();

	}


	//-- CLASS CODE ENDS
};
