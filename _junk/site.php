<?
// Evolt - Search Engine Friendly URLs Article
// Author : Garrett Coakley : evolt@polytechnic.co.uk
//
// Coded to: 	Gomez - "Liquid Skin"
//		Radiohead - "Amnesiac"
//		Public Enemy - "Apocolypse 91..."		 
//
// This code is free to use for whatever purpose you want. I won't be held responsible 
// if it does anything bad though.


///////// FUNCTIONS /////////////

// processURI(): 
// Takes the query string and extracts the vars by splitting on the '/'
// Returns an array $url_array containg keys argN for each variable.
function processURI() {
	global $REQUEST_URI;				// Define our global variables
							// 

	$array = explode("/",$REQUEST_URI);		// Explode the URI using '/'.
	
	$num = count($array);				// How many items in the array?
	
	$url_array = array();				// Init our new array	
	
	for ($i = 1 ; $i < $num ; $i++) {		// Insert each element from the
		$url_array["arg".$i] = $array[$i];	// request URI into $url_array
	}						// with a key of argN. We start $i
							// at 1 because exploding the URI
							// gives us an empty ref in $array[0] 
							// It's a hacky way of getting round it
							// *:)
	
	return $url_array;				// return our new shiny array
}


// displayContent(): 
// Pulls in content depending on the values passed to it;
// Takes an array as an argument. 
// FOR DEMO PURPOSES ONLY: this is only here to show an exmple app. It does
// no security checks, hell, it barely does what it's supposed to do! 

function displayContent($array) {
	$section = $array["arg3"];			// get the values out of the array and
	$cat = $array["arg4"];				// assign them. 
	
	$content = "content/" 				// cat together all our elements to
		   . $section 				// get a file name.
		   . "_"
		   . $cat
		   . ".php";

	if (!file_exists($content)) {			// Does the file exist?
		$content = "content/error.php";		// Nope, someone is playing around
		include($content);
	} else {
		include($content);			// Yes, include the file 
	}
}


///////// END OF FUNCTIONS /////////////

?>



<? 
// Init the page, run processURI and assign it.
$myarray = processURI();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Search Friendly URL's</title>
  </head>
  	
  <body>

	<h1>Garretts Front Room</h1>
	
	<p>A quick inventory of whats lying around my front room right now.</p>
	
	<ul>
	<li>Books
	
		<!-- 
		These links are hardcoded to my evolt members account
		so you'll need to change them if you want to use this
		file locally.
		-->
		<ul>
		<li><a href="/garrett/site/books/factual">Factual</a></li>
		<li><a href="/garrett/site/books/novels">Novels</a></li>
		</ul></li>
	<li>Cd's
		<ul>
		<li><a href="/garrett/site/cds/loud">Loud</a></li>
		<li><a href="/garrett/site/cds/chilled">Chilled</a></li>
		</ul></li>
	</ul>
	
	<!-- Dynamic content gets dropped in here -->
	
	<? displayContent($myarray); ?>

	<p><em>Download all the files for this app at <a href="http://members.evolt.org/garrett/search_urls_php.tar.gz">http://members.evolt.org/garrett/search_urls_php.tar.gz</a></em></p>

  </body>
</html>

