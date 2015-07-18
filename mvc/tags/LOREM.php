<?php

//print_r($theTag);

// NEEDS A ECHO TO BUILD CONTENT
$max = intval($theTag->val("max", 0));
if ($max > 0)
{
    echo substr($theTag->content, 0, $max);
}
else
{
    echo $theTag->content;    
}
