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

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->txtHostname 	= "localhost";
		$this->txtUser 		= "root";
		$this->txtPassword 	= "";
		$this->txtDatabase 	= "haiku";
		
		//$this->txtDatabase 	= "";

		if ($this->txtDatabase)
		{
			$dsn = "mysql:host={$this->txtHostname};dbname={$this->txtDatabase};charset=utf8";

			try
			{
			    $dbh = new PDO($dsn, $this->txtUser, $this->txtPassword);
			}
			catch (PDOException $e)
			{
			    echo 'Connection failed: ' . $e->getMessage();
				exit;
			}

		}
	}

	//-- CLASS CODE ENDS
};
