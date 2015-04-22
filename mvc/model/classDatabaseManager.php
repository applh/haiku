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
			$this->objRequest = $this->databaseConnexion->prepare($txtSQL);
		}

		return $this;
	}

	function exec ()
	{
		if ($this->objRequest != null)
		{
			$this->objRequest->execute();			
		}

		return $this;

	}
	//-- CLASS CODE ENDS
};
