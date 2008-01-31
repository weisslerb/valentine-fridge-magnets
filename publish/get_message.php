<?php

	include_once("_functions.php");
	include_once("_db.php");
	//
	// Log Hit
	$query = "INSERT INTO `views` (`time` , `msg_id` , `user_ip` , `user_agent` ) VALUES ('$time', '$msg_id', '$ip', '$agent')";
	$result = mysql_query($query);
	//
	// Get Message
	$query = "SELECT * from messages WHERE msg_id='$msg_id' LIMIT 1";
	$result = mysql_query($query);
	$num_results = mysql_num_rows($result);
	if ($num_results < 1) {
		$query = "SELECT * from messages WHERE msg_id='1' LIMIT 1";
		$result = mysql_query($query);
	}
	while ($row = mysql_fetch_assoc($result)) {
		$words = stripslashes($row["words"]);
		$words_init_x = stripslashes($row["words_init_x"]);
		$words_init_y = stripslashes($row["words_init_y"]);
		$words_x = stripslashes($row["words_x"]);
		$words_y = stripslashes($row["words_y"]);
		$words_depth = stripslashes($row["words_depth"]);
	}
	//
	if ($result) {
		echo "words=" . urlencode($words);
		echo "&words_init_x=" . urlencode($words_init_x);
		echo "&words_init_y=" . urlencode($words_init_y);
		echo "&words_x=" . urlencode($words_x);
		echo "&words_y=" . urlencode($words_y);
		echo "&words_depth=" . urlencode($words_depth);
	} else {
		$no_msg = true;
		echo "no_msg=" . urlencode($no_msg);
	}

?> 