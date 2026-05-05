<?php

	include 'Common.php';

	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$BIN = (isset($_GET["BIN"])) ? trim($_GET["BIN"]) : "";
	$LOC = (isset($_GET["LOC"])) ? trim($_GET["LOC"]) : "";

	$LINKVARS = "PN=" . $PN . "&BIN=" . $BIN . "&LOC=" . $LOC;
?>

<html>
<title>
	<?php echo GetTitle(); ?>
</title>
<body>

	<table border="1" width="1024">
		<tr>
			<td valign="top">
				<?php include 'Menu.php'; ?>
			</td>
		</tr>
		<tr>
			<td valign="top">

				<font size="4">
					<b>Part Search</b>
				</font>

				<br>
				<br>

				<center>

				<form name="Action" method="get" action="Parts_Search_iFrames.php">

					<table border="0" cellspace="1">
						<tr>
							<td valign="top">
								<font size="2">
									<i>PN</i>
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<i>Bin</i>
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<i>Location</i>
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top">
								<input type="textbox" name="PN" value="<?php echo $PN; ?>">
							</td>
							<td valign="top">
								<input type="textbox" name="BIN" value="<?php echo $BIN; ?>">
							</td>

							<td valign="top">
								<input type="textbox" name="LOC" value="<?php echo $LOC; ?>">
							</td>

						</tr>
					</table>

					<br>

					<input type="submit" value="Search">

					<br>
					<br>

					<input type="button" value="Refresh" onClick="document.getElementById('PartsFrame').contentWindow.location.reload(true);" style="width='200';">
					<input type="button" value="Reset Selection" onClick="window.location='Parts_Search_iFrames.php';" style="width='200';">

				</form>

				</center>

				<br>
				<hr>

				<iframe id="PartsFrame" src="Parts_Search.php?<?php echo $LINKVARS; ?>" border='0' frameborder='0' scrolling='auto' width="100%" height="440"></iframe>

				<br>
				<br>

				<center><input type="button" value="Download as CSV File" onclick="window.location='Parts_Search_Download.php?<?php echo $LINKVARS; ?>';"></center>
			</td>
		</tr>
	</table>

</body>
</html>
