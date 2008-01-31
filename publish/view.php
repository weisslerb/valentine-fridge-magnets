<?php
	include_once("_functions.php");
	include_once("_db.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>RGC Valentine Promo</title>
<style type="text/css">
<!--\
body {
	overflow-x: hidden;
	overflow-y: hidden;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" scroll="no" scrollbars="no">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="bottom">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="100%" height="100%">
        <param name="movie" value="fridge.swf">
        <param name="quality" value="high">
        <param name="allowScriptAccess" value="sameDomain">
		<param name="quality" value="high">
		<param name="bgcolor" value="#ffffff">
		<?php
			if ($msg_id>0) {
				echo  "<param name=\"FlashVars\" value=\"msg_id=$msg_id\">";
			}
		?>
        <embed src="fridge.swf" <?php if ($msg_id>0) { echo "FlashVars=\"msg_id=$msg_id\""; } ?> width="100%" height="100%" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
	</object>
	</td>
  </tr>

</table>
</body>
</html>


	