<?php

	/********** list_contents ***********************************
	*                                                           *
	*  recursively displays contents of the array               *
	*	and sub-arrays                                          *
	*                                                           *
	************************************************************/
	function list_contents($array,$tab="&nbsp;&nbsp;&nbsp;&nbsp;",$indent=0) { 
		while(list($key, $value) = each($array)) {
			for($i=0; $i<$indent; $i++) $current .= $tab;
				if (is_array($value)) {
					$reveal .= "$current$key : Array: <BR>$current{<BR>";
					$reveal .= LIST_CONTENTS($value,$tab,$indent+1)."$current}<BR>";
				}
				else $reveal .= "$current$key => $value<BR>";
				$current = NULL;
			}
		return $reveal;
	}
	//
	$myArray = $HTTP_POST_VARS['myArray'];	
	$myArray = stripslashes($myArray);
	$myArray = unserialize($myArray);
	$myArray = ($myArray == false) ? "Unserialize Problem" : $myArray;
	//
	
	//
	$message =  "Start\n\n";
	$message .= list_contents($myArray);
	// $message .= $myArray;
	$message .= "\n\nDone";
	//
	echo $message;
	//
	mail("zeke@rgcreative.com", "serialize test", $message);
	

	/*
	class myclass
	{
	  var $db = "resource";
	  var $integer = 1;
	}
	// ****************************
	// create the array to be
	// passed to Flash unserializer
	// ****************************
	$testArray = array();
	$testArray['intero'] = 1000;
	$testArray['stringa'] = "nuova stringa";
	$testArray['doubleval'] = doubleval(100.54);
	$testArray['floatval'] = floatval(100.54);
	$testArray['booleano'] = true;
	array_push($testArray, "{Run to the hills!!!}");
	$testArray['oggetto'] = new myclass();
	$testArray['servertime'] = gmdate('D, d M Y H:i:s \G\M\T', time());
	
	// ******************************
	// send back the value serialized
	// ******************************
	print "flashVar=" . urlencode(utf8_encode(serialize($testArray)));
	*/

?> 