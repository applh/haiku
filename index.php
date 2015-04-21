<?php

// load the starter code
include("mvc/starter.php");

// get the page name
$txtPageName    = $haiku_page_name(); 

// create the page
$page           = new Page($txtPageName);
