<?php
   $to="Zeke <zeke@rgcreative.com>";
   $from="Zeke <zeke@rgcreative.com>";
   $subject="My first HTML E-mail";
   $mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
   $headers = "From: $from\r\n" .
      "MIME-Version: 1.0\r\n" .
      "Content-Type:multipart/alternative;\n" .
      " boundary=\"{$mime_boundary}\r\n\"";
   $headers.= "From: $from\r\n";
   $message = "This is a multi-part message in MIME format.\n\n" .
      "--{$mime_boundary}\n" .
      "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
      "Content-Transfer-Encoding: 7bit\n\n" .
      "HTML E-mail\n\nThis is the text portion of an HTML e-mail\n" .
      "--{$mime_boundary}\n" .
      "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
      "Content-Transfer-Encoding: 7bit\n\n" .
      "<h1>HTML E-mail</h1>" .
      "<p>This is an <b>HTML</b> e-mail.</p>";
   if (mail($to, $subject, $message, $headers))
      echo "Message Sent!";
   else
      echo "Failed to send message.";
?>