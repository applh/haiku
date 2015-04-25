<?php

/*
* class:		ModelContact
* creation:		2015-04-22 01:38:53
*
* author:		Long Hai
* license:		All rights reserved
*
*/

class ModelContact
{
	//-- CLASS CODE BEGINS

	//-- ATTRIBUTES
	public $email;
	public $name;
	public $message;
	public $date;
	public $ip;

	//-- METHODS

	// CONSTRUCTOR
	function __construct ()
	{
		// WRITE YOUR CODE HERE
		$this->txtTable = "contacts";
	}

	function buildHTML ()
	{
		$result =
<<<CODEHTML
<tr>
	<td>{$this->id}</td>
	<td>{$this->email}</td>
	<td><pre>{$this->message}</pre></td>
	<td>{$this->date}</td>
	<td>{$this->ip}</td>
	<td><a href="?formhid=deleteTable&table={$this->txtTable}&id={$this->id}">delete</a></td>
</tr>
CODEHTML;

		return $result;
	}

	function create ($dbManager, $email, $name, $message, $now, $ip)
	{
		$sqlRequest =
<<<CODESQL

INSERT INTO `contacts`
(`id`, `email`, `name`, `message`, `date`, `ip`)
VALUES
(NULL, :email, :name, :message, :date, :ip);

CODESQL;

		$dbManager	->prepare($sqlRequest)
					->replace(":email", 	$email, PDO::PARAM_STR)
					->replace(":name", 		$email, PDO::PARAM_STR)
					->replace(":message", 	$email, PDO::PARAM_STR)
					->replace(":date", 		$now, 	PDO::PARAM_STR)
					->replace(":ip", 		$ip, 	PDO::PARAM_STR)
					->exec();

	}

	function update ($dbManager, $id, $email, $name, $message, $now, $ip)
	{
		$sqlRequest =
<<<CODESQL

UPDATE `contacts`
SET
`email`	 	= :email,
`name` 		= :name,
`message` 	= :message,
`date` 		= :date,
`ip` 		= :ip
WHERE
`contacts`.`id` = :id;

CODESQL;

		$dbManager	->prepare($sqlRequest)
					->replace(":id", 		$id, 	PDO::PARAM_INT)
					->replace(":email", 	$email, PDO::PARAM_STR)
					->replace(":name", 		$email, PDO::PARAM_STR)
					->replace(":message", 	$email, PDO::PARAM_STR)
					->replace(":date", 		$now, 	PDO::PARAM_STR)
					->replace(":ip", 		$ip, 	PDO::PARAM_STR)
					->exec();

	}


	//-- CLASS CODE ENDS
};
