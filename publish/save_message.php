<?php

include_once("_functions.php");
include_once("_db.php");

/***************************************************************************
	Prepare Variables
***************************************************************************/
$cipher = randomString(5);
$date = time();
$sender_ip = $REMOTE_ADDR;
$sender_agent = $HTTP_USER_AGENT;

// Message Info
$sender_name = ucwords(trim($sender_name));
$sender_firstName = get_firstName($sender_name);
$sender_email = strtolower(trim($sender_email));
$sender_msg = $sender_msg;
$recipient_name = ucwords(trim($recipient_name));
$recipient_firstName = get_firstName($recipient_name);
$recipient_email = strtolower(trim($recipient_email));

/***************************************************************************
	Insert message into DB
***************************************************************************/
$query = "
	INSERT INTO `messages` (`cipher` , `date` , `sender_ip` , `sender_agent` , `sender_name` , `sender_email` , `sender_msg` , `recipient_name` , `recipient_email` , `words` , `words_init_x` , `words_init_y` , `words_x` , `words_y` , `words_depth`)
	VALUES ('$cipher', '$date', '$sender_ip', '$sender_agent', '$sender_name', '$sender_email', '$sender_msg', '$recipient_name', '$recipient_email', '$words', '$words_init_x', '$words_init_y', '$words_x', '$words_y', '$words_depth')
";
$result = mysql_query($query);


/***************************************************************************
	Pull Info from DB, organize, put it back
***************************************************************************/
// I don't understand why, but PHP can't unserialize the arrays properly
// until they've been put in the DB and pulled back out

// Get msg_id from last entry
$query = "SELECT LAST_INSERT_ID() FROM `messages`";
$id_array = mysql_fetch_array(mysql_query($query));
$msg_id = $id_array['last_insert_id()'];
//
$query = "SELECT * from messages WHERE msg_id='$msg_id' LIMIT 1";
$result = mysql_query($query);		
while ($row = mysql_fetch_assoc($result)) {
	$words = unserialize(stripslashes($row["words"]));
	$words_init_x = unserialize(stripslashes($row["words_init_x"]));
	$words_init_y = unserialize(stripslashes($row["words_init_y"]));
	$words_x = unserialize(stripslashes($row["words_x"]));
	$words_y = unserialize(stripslashes($row["words_y"]));
	$words_depth = unserialize(stripslashes($row["words_depth"]));
}

// Sort all arrays by word depth
array_multisort($words_depth, $words, $words_init_x, $words_init_y, $words_x, $words_y);

// Re-serialize for DB entry
$words = serialize($words);
$words_init_x = serialize($words_init_x);
$words_init_y = serialize($words_init_y);
$words_x = serialize($words_x);
$words_y = serialize($words_y);
$words_depth = serialize($words_depth);
//
$query = "UPDATE messages SET `words`='$words', `words_init_x`='$words_init_x', `words_init_y`='$words_init_y', `words_x`='$words_x', `words_y`='$words_y', `words_depth`='$words_depth' WHERE msg_id='$msg_id' LIMIT 1";
$result = mysql_query($query);




/***************************************************************************
	Email DB Insertion Results
***************************************************************************/
/*
if (!$result) {
	$subject = "DB Insert Failed";
	$message = "Problem inserting entry into DB: " . mysql_error();
	exit;
} else {
	$subject = "Successful DB Insert";
	$message =  "Start\n\n";
	$message .= list_contents(unserialize(reset($words), "\n");
	$message .= "\n";
	$message .= list_contents(unserialize(reset($words_init_x), "\n");
	$message .= "\n";
	$message .= list_contents(unserialize(reset($words_init_y), "\n");
	$message .= "\n";
	$message .= list_contents(unserialize(reset($words_x), "\n");
	$message .= "\n";
	$message .= list_contents(unserialize(reset($words_y), "\n");
	$message .= "\n";
	$message .= list_contents(unserialize(reset($words_depth), "\n");
	$message .= "\n\nDone";
}
$headers = "RGC Valentine Testing <zeke@rgcreative.com>\r\n";
mail("zeke@rgcreative.com", $subject, $message, $headers);
*/



/***************************************************************************
	(TESTING PURPOSES) Email new DB entry contents to Zeke
***************************************************************************/
/*
$query = "SELECT * from messages WHERE msg_id='$msg_id' LIMIT 1";
//echo "Query: $query<br><br>";
$result = mysql_query($query);		
while ($row = mysql_fetch_assoc($result)) {
	$words = stripslashes($row["words"]);
	$words_init_x = stripslashes($row["words_init_x"]);
	$words_init_y = stripslashes($row["words_init_y"]);
	$words_x = stripslashes($row["words_x"]);
	$words_y = stripslashes($row["words_y"]);
	$words_depth = stripslashes($row["words_depth"]);
	
	$subject = "DB Contents";
	$message =  "Start\n\n";
	$message .= "Words: " . list_contents( unserialize(reset($words) ) . "\n\n";
	$message .= "Init X Positions: " . list_contents( unserialize(reset($words_init_x) ) . "\n\n";
	$message .= "Init Y Positions: " . list_contents( unserialize(reset($words_init_y) ) . "\n\n";
	$message .= "X Positions: " . list_contents( unserialize(reset($words_x) ) . "\n\n";
	$message .= "Y Positions: " . list_contents( unserialize(reset($words_y) ) . "\n\n";
	$message .= "Depths: " . list_contents( unserialize(reset($words_depth) ) . "\n\n";
	$headers = "RGC Valentine Testing <zeke@rgcreative.com>\r\n";
	mail("zeke@rgcreative.com", $subject, $message, $headers);
}
*/




/***************************************************************************
	Email Message Recipient
***************************************************************************/


$message = "Hello " . $recipient_firstName . "!\n\n";
$message .= "The following is a message from your good friend $sender_name: " . $sender_msg . "\n\n";
$message .= "To view " . $sender_firstName . "'s valentine creation,";
$message .= " please visit http://rgcreative.com/valentine/index.php/$msg_id/$cipher";
//
$headers = "From: Comfort Foods Shopper <$s_email>\r\n";
$headers .= "Cc: zeke@rgcreative.com\r\n";
//
$subject = "A Valentine's message from " . $sender_name . " and Rome & Gold Creative";
//
mail($recipient_email, $subject, $message, $headers);



?> 