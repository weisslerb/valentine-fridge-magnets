<?php	if ($msg_id) {	include_once("_functions.php");	include_once("_db.php");	//	// Log Hit	$query = "INSERT INTO `views` (`time` , `msg_id` , `user_ip` , `user_agent` ) VALUES ('$time', '$msg_id', '$ip', '$agent')";	$result = mysql_query($query);	//	// Get Message	$query = "SELECT * from messages WHERE msg_id='$msg_id' LIMIT 1";	$result = mysql_query($query);	$num_results = mysql_num_rows($result);	// Get default message if message not found	if ($num_results < 1) {		$query = "SELECT * from messages ORDER BY msg_id ASC LIMIT 1";		$result = mysql_query($query);	}		while ($row = mysql_fetch_assoc($result)) {		$sender_name = stripslashes($row["sender_name"]);		$words = str_replace("&", "AND", stripslashes($row["words"]));		$words_x_init = stripslashes($row["words_x_init"]);		$words_y_init = stripslashes($row["words_y_init"]);		$words_x = stripslashes($row["words_x"]);		$words_y = stripslashes($row["words_y"]);		$words_depth = stripslashes($row["words_depth"]);	}	//}?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>Magneato: Brand Seduction from Rome & Gold Creative</title>		<script type="text/javascript" src="swfobject.js"></script>		<style type="text/css">				/* hide from ie on mac \*/			html {				height: 100%;				overflow: hidden;			}				#flashcontent {				height: 100%;			}			/* end hide */			body {				height: 100%;				margin: 0;				padding: 0;				background-color: #FFFFFF;			}		</style>	</head>	<body>		<div id="flashcontent">			<strong>Oh no! You need Flash Player 9 or greater to view this site.</strong><br /><br />						Please <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">upgrade your Flash player</a>. It's worth it!		</div>			<script type="text/javascript">			// <![CDATA[					var so = new SWFObject("fridge.swf", "fridge", "100%", "100%", "9", "#FFFFFF");<?	if ($result) {		echo "so.addVariable(\"sender_name\", \"" . $sender_name . "\");";		echo "so.addVariable(\"words\", \"" . $words . "\");";		echo "so.addVariable(\"words_x_init\", \"" . $words_x_init . "\");";		echo "so.addVariable(\"words_y_init\", \"" . $words_y_init . "\");";		echo "so.addVariable(\"words_x\", \"" . $words_x . "\");";		echo "so.addVariable(\"words_y\", \"" . $words_y . "\");";		echo "so.addVariable(\"words_depth\", \"" . $words_depth . "\");";			}?>			so.write("flashcontent");					// ]]>		</script>		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">		</script>		<script type="text/javascript">		_uacct = "UA-432708-21";		urchinTracker();		</script>		</body></html>