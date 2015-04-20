<?php

$haiku_find_file = function ($txtFile)
{
	$txtResult = "";

	// get current dir
	$txtCurDir = basename(__DIR__);

	// SEARCH IN LEVEL 1
	$tabResult = glob("$txtCurDir/*/$txtFile");
	if (count($tabResult)  > 0)
	{
		$txtResult = $tabResult[0];
	}
	else
	{
		// SEARCH IN LEVEL 2
		$tabResult = glob("$txtCurDir/*/*/$txtFile");
		if (count($tabResult)  > 0)
		{
			$txtResult = $tabResult[0];
		}
	}

	return $txtResult;
};

$haiku_generate_class = function ($txtClass)
{
	$txtResult = "";

	$txtTemplate = $haiku_find_file("classTemplate.php");
	if ($txtTemplate != "")
	{
		$txtCodeSource 	= file_get_contents("$txtTemplate");
		$txtTargetDir  	= dirname($txtCodeSource);
		$txtTargetFile 	= "$txtTargetDir/class$txtClass.php";

		$tabReplace    	= [
			"=DATE=" 		=> date("Y-m-d H:i:s"),
			"=TEMPLATE="	=> $txtClass,
		];

		$tabSource		= array_keys($tabReplace);
		$tabTarget      = array_values($tabReplace);

		$txtCodeTarget 	= str_replace($tabSource, $tabTarget, $txtCodeSource);
		file_put_contents($txtTargetFile, $txtCodeTarget);
	}

	return $txtResult;
};

$haiku_class_autoload = function ($txtClass)
{
	$txtPath = $haiku_find_file("class$txtClass.php");
	if ($txtPath != "")
	{
		include("$txtPath");
	}
	else
	{
		$txtPath = $haiku_generate_class($txtClass);
		if ($txtPath != "")
		{
			include("$txtPath");
		}
	}
};

spl_autoload_register('haiku_class_autoload');
