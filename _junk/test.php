<?php

	include_once("_functions.php");
	//
	$words = array("dog", "fish", "cat");
	$nums = array("two", "one", "three"); 
	$depths = array(2, 1, 3); 
	array_multisort($depths, $words, $nums); 
	//
	echo list_contents($depths);
	echo "<br><br>";
	echo list_contents($nums);
	echo "<br><br>";
	echo list_contents($words);

?>
	