<?php

	/********** list_contents ***********************************
	*                                                           *
	*  recursively displays contents of the array               *
	*	and sub-arrays                                          *
	*                                                           *
	************************************************************/
	function list_contents($array,$break="<br>",$tab="&nbsp;&nbsp;&nbsp;&nbsp;",$indent=0) { 
		while(list($key, $value) = each($array)) {
			for($i=0; $i<$indent; $i++) $current .= $tab;
				if (is_array($value)) {
					$reveal .= "$current$key : Array: " . $break . "$current{" . $break . "";
					$reveal .= LIST_CONTENTS($value,$tab,$indent+1)."$current}" . $break . "";
				}
				else $reveal .= "$current$key => $value" . $break . "";
				$current = NULL;
			}
		return $reveal;
	}
	

	function randomString($len=5) {
	   $possible = str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"); 
	   return substr($possible, 0, $len);
	}
	
	
	// Take a string like 'Zeke Sikelianos' or ' Zeke ', and returns 'Zeke'
	function get_firstName($name) {
		$space = strpos(trim($name), " ");
		$firstName = ($space == 0) ? $name : substr($name, 0, $space);
		return $firstName;
	}
	
	
	// processURI(): 
	// Takes the query string and extracts the vars by splitting on the '/'
	// Returns an array $url_array containg keys argN for each variable.
	function processURI() {
		global $REQUEST_URI;
		$array = explode("/",$REQUEST_URI);	
		$num = count($array);
		$url_array = array();
		for ($i = 1 ; $i < $num ; $i++) {
			$url_array[$i] = $array[$i];
		}
		return $url_array;
	}

?>