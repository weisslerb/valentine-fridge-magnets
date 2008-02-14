<?php

include_once("_functions.php");
include_once("_db.php");


/* Prepare Variables
***************************************************************************/
$cipher = randomString(5);
$date = time();
$sender_ip = $REMOTE_ADDR;
$sender_agent = $HTTP_USER_AGENT;


/* Clean up message data
***************************************************************************/
$sender_name = ucwords(trim($sender_name));
$sender_firstName = get_firstName($sender_name);
$sender_email = strtolower(trim($sender_email));
$recipient_name = ucwords(trim($recipient_name));
$recipient_firstName = get_firstName($recipient_name);
$recipient_email = strtolower(trim($recipient_email));


/* Insert message into DB
***************************************************************************/
$query = "
	INSERT INTO messages (cipher, date, sender_ip, sender_agent, sender_name, sender_email, recipient_name, recipient_email, words, words_x_init, words_y_init, words_x, words_y, words_depth)
	VALUES ('$cipher', '$date', '$sender_ip', '$sender_agent', '$sender_name', '$sender_email', '$recipient_name', '$recipient_email', '$words', '$words_x_init', '$words_y_init', '$words_x', '$words_y', '$words_depth')
";
$result = mysql_query($query);


/* Get ID of new message
***************************************************************************/
$query = "SELECT LAST_INSERT_ID() FROM messages";
$id_array = mysql_fetch_array(mysql_query($query));
$msg_id = $id_array['last_insert_id()'];


/* Email Message Recipient
***************************************************************************/
require("class.phpmailer.php");
$mail = new PHPMailer();

$mail->From = $sender_email;
$mail->FromName = $sender_name;
$mail->AddAddress($recipient_email, $recipient_name);
$mail->AddCC($sender_email, $sender_name);
$mail->AddBCC("zeke@sikelianos.com", "Zeke Sikelianos");

$mail->Subject = "A Valentine message from " . $sender_name . " and Rome & Gold Creative";

$mail->Body = "Hello " . $recipient_firstName . "!\n\n";
$mail->Body .= "Your friend " . $sender_name . " has created a Magneato message for you..\n\n";
$mail->Body .= "To view it, visit http://brandseduction.com/index.php?msg_id=" . $msg_id;
$mail->Body .= "\n\nMagneato: Brand Seduction created by Rome & Gold Creative. http://rgcreative.com";

if(!$mail->Send()) {
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo $msg_id;

?>